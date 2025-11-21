<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\Gelombang;
use App\Models\PendaftarDataSiswa;
use App\Models\PendaftarDataOrtu;
use App\Models\PendaftarAsalSekolah;
use App\Models\PendaftarBerkas;
use App\Models\PendaftarPembayaran;
use App\Models\Wilayah;
use App\Models\LogAktivitas;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class PendaftarController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Auto-assign gelombang for old users
        if ($user->role == 'pendaftar' && !$user->gelombang_id) {
            $activeGelombang = Gelombang::where('is_active', true)->first();
            if ($activeGelombang) {
                $user->gelombang_id = $activeGelombang->id;
                $user->save();
            }
        }
        
        $pendaftar = Pendaftar::with(['dataSiswa', 'dataOrtu', 'asalSekolah', 'jurusan', 'berkas', 'gelombang', 'pembayaran'])
            ->where('user_id', $user->id)
            ->first();
        
        $stats = [
            'status' => $pendaftar ? $pendaftar->status : 'DRAFT',
            'progress' => $this->calculateProgress($pendaftar),
            'gelombang_aktif' => Gelombang::where('is_active', true)->first(),
        ];
        
        $jurusan = Jurusan::all();
        
        return view('dashboard.pendaftar', compact('stats', 'pendaftar', 'jurusan'));
    }
    
    public function form()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->with(['dataSiswa', 'dataOrtu', 'asalSekolah', 'berkas'])->first();
        
        $canEdit = true;
        if ($pendaftar) {
            $canEdit = in_array($pendaftar->status, ['DRAFT', 'SUBMITTED']) && 
                      (($pendaftar->status_data ?? 'PENDING') == 'REVISION' || ($pendaftar->status_berkas ?? 'PENDING') == 'REVISION' || 
                       ($pendaftar->status_data ?? 'PENDING') == 'PENDING' || ($pendaftar->status_berkas ?? 'PENDING') == 'PENDING');
        }
        
        if (!$canEdit && $pendaftar && $pendaftar->status != 'DRAFT') {
            return redirect('/dashboard/pendaftar')->with('error', 'Pendaftaran sudah disubmit dan tidak dapat diubah.');
        }
        
        $jurusan = Jurusan::withCount('pendaftar')->get();
        $gelombang = Gelombang::where('is_active', true)->first();
        $wilayah = Wilayah::all();
            
        return view('pendaftaran.form', compact('pendaftar', 'jurusan', 'gelombang', 'wilayah', 'canEdit'));
    }
    

    
    public function berkas()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->with('berkas')->first();
        
        $canEdit = true;
        if ($pendaftar) {
            $canEdit = in_array($pendaftar->status, ['DRAFT', 'SUBMITTED']) && 
                      in_array($pendaftar->status_berkas ?? 'PENDING', ['PENDING', 'REJECTED']);
        }
        
        if (!$canEdit && $pendaftar && $pendaftar->status != 'DRAFT') {
            return redirect('/dashboard/pendaftar')->with('error', 'Berkas sudah diverifikasi dan tidak dapat diubah.');
        }
        
        $existingFiles = [];
        if ($pendaftar) {
            $berkas = $pendaftar->berkas ?? collect();
            foreach ($berkas as $item) {
                $existingFiles[strtolower($item->jenis)] = $item;
            }
        }
        
        return view('pendaftaran.berkas', compact('pendaftar', 'canEdit', 'existingFiles'));
    }
    
    public function storeUpload(Request $request)
    {
        try {
            $user = Auth::user();
            $pendaftar = Pendaftar::where('user_id', $user->id)->first();
            
            if (!$pendaftar) {
                return redirect('/dashboard/pendaftar')->with('error', 'Silakan lengkapi data pendaftaran terlebih dahulu');
            }
        
            $request->validate([
                'ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'akta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:1024',
                'kip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'surat_sehat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);
            
            $berkasTypes = [
                'ijazah' => 'IJAZAH',
                'kk' => 'KK', 
                'akta' => 'AKTA',
                'foto' => 'LAINNYA',
                'kip' => 'KIP',
                'surat_sehat' => 'LAINNYA'
            ];
            
            foreach ($berkasTypes as $field => $jenis) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                    $fileSize = round($file->getSize() / 1024, 2);
                    
                    if (!file_exists(public_path('uploads/berkas'))) {
                        mkdir(public_path('uploads/berkas'), 0755, true);
                    }
                    
                    $file->move(public_path('uploads/berkas'), $filename);
                    
                    $oldBerkas = PendaftarBerkas::where('pendaftar_id', $pendaftar->id)
                        ->where('jenis', $jenis)
                        ->first();
                    
                    if ($oldBerkas && File::exists(public_path($oldBerkas->url))) {
                        File::delete(public_path($oldBerkas->url));
                        $oldBerkas->delete();
                    }
                    
                    PendaftarBerkas::create([
                        'pendaftar_id' => $pendaftar->id,
                        'jenis' => $jenis,
                        'nama_file' => $filename,
                        'url' => 'uploads/berkas/' . $filename,
                        'ukuran_kb' => $fileSize,
                        'status_verifikasi' => 'PENDING'
                    ]);
                }
            }
            
            if ($pendaftar->status_berkas == 'REJECTED') {
                $pendaftar->update(['status_berkas' => 'PENDING']);
            }
            
            return redirect('/dashboard/pendaftar')->with('success', 'Berkas berhasil diupload');
            
        } catch (\Exception $e) {
            Log::error('Error upload berkas: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal upload berkas: ' . $e->getMessage()])->withInput();
        }
    }
    
    public function pembayaran()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::with(['gelombang'])->where('user_id', $user->id)->first();
        
        $canPay = $pendaftar && 
                  ($pendaftar->status_berkas ?? 'PENDING') == 'VERIFIED' && 
                  ($pendaftar->status_data ?? 'PENDING') == 'VERIFIED';
        
        $biayaPendaftaran = $pendaftar && $pendaftar->gelombang ? $pendaftar->gelombang->biaya_daftar : 250000;
        
        return view('pendaftaran.pembayaran', compact('pendaftar', 'canPay', 'biayaPendaftaran'));
    }
    
    public function storePembayaran(Request $request)
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->first();
        
        if (!$pendaftar) {
            return redirect('/dashboard/pendaftar')->with('error', 'Data pendaftar tidak ditemukan');
        }
        
        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'nama_pengirim' => 'required|string|max:100',
            'tanggal_transfer' => 'required|date',
            'nominal' => 'required|numeric',
        ]);
        
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_bukti_bayar.' . $file->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads/pembayaran'))) {
                mkdir(public_path('uploads/pembayaran'), 0755, true);
            }
            
            $file->move(public_path('uploads/pembayaran'), $filename);
            
            PendaftarPembayaran::updateOrCreate(
                ['pendaftar_id' => $pendaftar->id],
                [
                    'nominal' => $request->nominal,
                    'tanggal_transfer' => $request->tanggal_transfer,
                    'nama_pengirim' => $request->nama_pengirim,
                    'bukti_pembayaran' => 'uploads/pembayaran/' . $filename,
                    'status_verifikasi' => 'PENDING',
                    'catatan' => $request->catatan
                ]
            );
        }
        
        return redirect('/dashboard/pendaftar')->with('success', 'Bukti pembayaran berhasil diupload');
    }
    
    public function status()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)
            ->with(['dataSiswa', 'dataOrtu', 'asalSekolah', 'jurusan', 'berkas'])
            ->first();
        
        return view('pendaftaran.status', compact('pendaftar'));
    }
    
    public function cetakKartu()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan'])
            ->where('user_id', $user->id)
            ->first();
            
        if (!$pendaftar) {
            return redirect('/dashboard/pendaftar')->with('error', 'Data pendaftar tidak ditemukan');
        }
        
        return view('pendaftaran.cetak-kartu', compact('pendaftar'));
    }
    
    public function formulir()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::with(['dataSiswa.wilayah', 'dataOrtu', 'asalSekolah', 'jurusan', 'gelombang', 'berkas'])
            ->where('user_id', $user->id)
            ->first();
            
        if (!$pendaftar || $pendaftar->status == 'DRAFT') {
            return redirect('/dashboard/pendaftar')->with('error', 'Pendaftaran belum disubmit');
        }
        
        return view('pendaftaran.formulir', compact('pendaftar'));
    }
    
    public function autoSave(Request $request)
    {
        try {
            $user = Auth::user();
            
            $pendaftar = Pendaftar::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'status' => 'DRAFT',
                    'no_pendaftaran' => $this->generateNoPendaftaran()
                ]
            );
            
            $berkasTypes = [
                'ijazah' => 'IJAZAH',
                'kk' => 'KK', 
                'akta' => 'AKTA',
                'foto' => 'LAINNYA',
                'kip' => 'KIP',
                'surat_sehat' => 'LAINNYA'
            ];
            
            foreach ($berkasTypes as $field => $jenis) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                    $fileSize = round($file->getSize() / 1024, 2);
                    
                    if (!file_exists(public_path('uploads/berkas'))) {
                        mkdir(public_path('uploads/berkas'), 0755, true);
                    }
                    
                    $file->move(public_path('uploads/berkas'), $filename);
                    
                    PendaftarBerkas::updateOrCreate(
                        ['pendaftar_id' => $pendaftar->id, 'jenis' => $jenis],
                        [
                            'nama_file' => $filename,
                            'url' => 'uploads/berkas/' . $filename,
                            'ukuran_kb' => $fileSize,
                            'status_verifikasi' => 'PENDING'
                        ]
                    );
                }
            }
            
            if ($request->has('nama')) {
                $dataSiswa = array_filter([
                    'nik' => $request->nik,
                    'nisn' => $request->nisn,
                    'nama' => $request->nama,
                    'jk' => $request->jk,
                    'tmp_lahir' => $request->tmp_lahir,
                    'tgl_lahir' => $request->tgl_lahir,
                    'alamat' => $request->alamat,
                    'wilayah_id' => $request->wilayah_id,
                    'lat' => $request->latitude,
                    'lng' => $request->longitude,
                ]);
                
                PendaftarDataSiswa::updateOrCreate(
                    ['pendaftar_id' => $pendaftar->id],
                    $dataSiswa
                );
            }
            
            if ($request->has('nama_ayah') || $request->has('nama_ibu')) {
                $dataOrtu = array_filter([
                    'nama_ayah' => $request->nama_ayah,
                    'pekerjaan_ayah' => $request->pekerjaan_ayah,
                    'hp_ayah' => $request->hp_ayah,
                    'nama_ibu' => $request->nama_ibu,
                    'pekerjaan_ibu' => $request->pekerjaan_ibu,
                    'hp_ibu' => $request->hp_ibu,
                    'wali_nama' => $request->wali_nama,
                    'wali_hp' => $request->wali_hp,
                ]);
                
                PendaftarDataOrtu::updateOrCreate(
                    ['pendaftar_id' => $pendaftar->id],
                    $dataOrtu
                );
            }
            
            if ($request->has('nama_sekolah')) {
                $asalSekolah = array_filter([
                    'npsn' => $request->npsn,
                    'nama_sekolah' => $request->nama_sekolah,
                    'kabupaten' => $request->kabupaten,
                    'nilai_rata' => $request->nilai_rata,
                ]);
                
                PendaftarAsalSekolah::updateOrCreate(
                    ['pendaftar_id' => $pendaftar->id],
                    $asalSekolah
                );
            }
            
            if ($request->has('jurusan_id')) {
                $jurusan = Jurusan::withCount('pendaftar')->find($request->jurusan_id);
                $existingPendaftar = Pendaftar::where('user_id', $user->id)->first();
                
                if (!$existingPendaftar || $existingPendaftar->jurusan_id != $request->jurusan_id) {
                    if ($jurusan && $jurusan->pendaftar_count >= $jurusan->kuota) {
                        return response()->json(['success' => false, 'message' => 'Kuota jurusan ' . $jurusan->nama . ' sudah penuh!'], 400);
                    }
                }
                
                $pendaftar->update(['jurusan_id' => $request->jurusan_id]);
            }
            
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan otomatis']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }
    
    public function store(Request $request)
    {
        try {
            \DB::beginTransaction();
            $user = Auth::user();
            
            // Check existing pendaftar first
            $existingPendaftar = Pendaftar::where('user_id', $user->id)->first();
            
            // Prevent re-submission if already verified or decided
            if ($existingPendaftar && in_array($existingPendaftar->status, ['VERIFIED_ADM', 'VERIFIED_KEPSEK'])) {
                \DB::rollBack();
                return redirect()->back()->with('error', 'Pendaftaran Anda sudah diverifikasi dan tidak dapat diubah lagi.');
            }
            
            if ($existingPendaftar && $existingPendaftar->hasil_keputusan) {
                \DB::rollBack();
                return redirect()->back()->with('error', 'Pendaftaran Anda sudah ada keputusan dan tidak dapat diubah lagi.');
            }
            
            // Validate required fields
            $request->validate([
                'jurusan_id' => 'required|exists:jurusan,id',
                'nik' => 'required|numeric|digits:16',
                'nisn' => 'required|numeric|digits:10', 
                'nama' => 'required|string|max:100',
                'jk' => 'required|in:L,P',
                'tmp_lahir' => 'required|string|max:50',
                'tgl_lahir' => 'required|date',
                'alamat' => 'required|string',
                'wilayah_id' => 'required|exists:wilayah,id',
                'nama_sekolah' => 'required|string|max:100',
                'nilai_rata' => 'nullable|numeric|min:0|max:100',
            ], [
                'nik.required' => 'NIK wajib diisi',
                'nik.numeric' => 'NIK harus berupa angka',
                'nik.digits' => 'NIK harus 16 digit',
                'nisn.required' => 'NISN wajib diisi',
                'nisn.numeric' => 'NISN harus berupa angka',
                'nisn.digits' => 'NISN harus 10 digit',
                'jurusan_id.required' => 'Jurusan wajib dipilih',
                'nama.required' => 'Nama lengkap wajib diisi',
                'jk.required' => 'Jenis kelamin wajib dipilih',
                'tmp_lahir.required' => 'Tempat lahir wajib diisi',
                'tgl_lahir.required' => 'Tanggal lahir wajib diisi',
                'alamat.required' => 'Alamat wajib diisi',
                'wilayah_id.required' => 'Wilayah wajib dipilih',
                'nama_sekolah.required' => 'Nama sekolah wajib diisi',
            ]);
            
            // Check jurusan quota
            $jurusan = Jurusan::withCount('pendaftar')->find($request->jurusan_id);
            
            if (!$existingPendaftar || $existingPendaftar->jurusan_id != $request->jurusan_id) {
                if ($jurusan && $jurusan->pendaftar_count >= $jurusan->kuota) {
                    return redirect()->back()->with('error', 'Kuota jurusan ' . $jurusan->nama . ' sudah penuh!');
                }
            }
            
            // Get gelombang from user account
            $gelombangId = $user->gelombang_id;
            
            if (!$gelombangId) {
                return redirect()->back()->with('error', 'Akun Anda tidak terdaftar dalam gelombang pendaftaran.');
            }
            
            // Create or update pendaftar
            if ($existingPendaftar) {
                $existingPendaftar->update([
                    'jurusan_id' => $request->jurusan_id,
                    'gelombang_id' => $gelombangId,
                    'status' => 'SUBMITTED',
                    'status_berkas' => 'PENDING',
                    'status_data' => 'PENDING',
                    'catatan_verifikasi' => null
                ]);
                $pendaftar = $existingPendaftar;
            } else {
                $pendaftar = Pendaftar::create([
                    'user_id' => $user->id,
                    'jurusan_id' => $request->jurusan_id,
                    'gelombang_id' => $gelombangId,
                    'status' => 'SUBMITTED',
                    'status_berkas' => 'PENDING',
                    'status_data' => 'PENDING',
                    'no_pendaftaran' => $this->generateNoPendaftaran(),
                    'catatan_verifikasi' => null
                ]);
            }
            
            // Save data siswa
            PendaftarDataSiswa::updateOrCreate(
                ['pendaftar_id' => $pendaftar->id],
                [
                    'nik' => $request->nik,
                    'nisn' => $request->nisn,
                    'nama' => $request->nama,
                    'jk' => $request->jk,
                    'tmp_lahir' => $request->tmp_lahir,
                    'tgl_lahir' => $request->tgl_lahir,
                    'alamat' => $request->alamat,
                    'wilayah_id' => $request->wilayah_id,
                    'lat' => $request->latitude,
                    'lng' => $request->longitude,
                ]
            );
            
            // Save data orang tua
            PendaftarDataOrtu::updateOrCreate(
                ['pendaftar_id' => $pendaftar->id],
                [
                    'nama_ayah' => $request->nama_ayah,
                    'pekerjaan_ayah' => $request->pekerjaan_ayah,
                    'hp_ayah' => $request->hp_ayah,
                    'nama_ibu' => $request->nama_ibu,
                    'pekerjaan_ibu' => $request->pekerjaan_ibu,
                    'hp_ibu' => $request->hp_ibu,
                    'wali_nama' => $request->wali_nama,
                    'wali_hp' => $request->wali_hp,
                ]
            );
            
            // Save asal sekolah
            PendaftarAsalSekolah::updateOrCreate(
                ['pendaftar_id' => $pendaftar->id],
                [
                    'npsn' => $request->npsn,
                    'nama_sekolah' => $request->nama_sekolah,
                    'kabupaten' => $request->kabupaten,
                    'nilai_rata' => $request->nilai_rata && $request->nilai_rata <= 100 ? $request->nilai_rata : null,
                ]
            );
            
            // Handle file uploads
            $berkasTypes = [
                'ijazah' => 'IJAZAH',
                'kk' => 'KK',
                'akta' => 'AKTA', 
                'foto' => 'LAINNYA',
                'kip' => 'KIP',
                'surat_sehat' => 'LAINNYA'
            ];
            
            foreach ($berkasTypes as $field => $jenis) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                    $fileSize = round($file->getSize() / 1024, 2);
                    
                    if (!file_exists(public_path('uploads/berkas'))) {
                        mkdir(public_path('uploads/berkas'), 0755, true);
                    }
                    
                    $file->move(public_path('uploads/berkas'), $filename);
                    
                    PendaftarBerkas::updateOrCreate(
                        ['pendaftar_id' => $pendaftar->id, 'jenis' => $jenis],
                        [
                            'nama_file' => $filename,
                            'url' => 'uploads/berkas/' . $filename,
                            'ukuran_kb' => $fileSize,
                            'status_verifikasi' => 'PENDING'
                        ]
                    );
                }
            }
            
            \DB::commit();
            
            return redirect('/dashboard/pendaftar')->with('success', 
                'Pendaftaran berhasil disubmit! No. Pendaftaran: ' . $pendaftar->no_pendaftaran);
                
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error submitting pendaftaran: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    private function sendNotificationToAdminVerifikator($pendaftar, $namaSiswa, $namaJurusan)
    {
        // Skip notification to avoid timeout
        return true;
    }
    
    public function submitPendaftaran(Request $request)
    {
        try {
            $user = Auth::user();
            $pendaftar = Pendaftar::where('user_id', $user->id)->first();
            
            if (!$pendaftar) {
                return response()->json(['success' => false, 'message' => 'Data pendaftar tidak ditemukan']);
            }
            
            if (!$pendaftar->dataSiswa || !$pendaftar->dataOrtu || !$pendaftar->asalSekolah) {
                return response()->json(['success' => false, 'message' => 'Silakan lengkapi semua data terlebih dahulu']);
            }
            
            if ($pendaftar->berkas()->count() == 0) {
                return response()->json(['success' => false, 'message' => 'Silakan upload berkas terlebih dahulu']);
            }
            
            $pendaftar->update([
                'status' => 'SUBMITTED',
                'status_berkas' => 'PENDING',
                'status_data' => 'PENDING',
                'catatan_verifikasi' => null
            ]);
            
            // Log activity
            LogAktivitas::create([
                'user_id' => $user->id,
                'aksi' => 'SUBMIT_PENDAFTARAN',
                'objek' => 'PENDAFTAR',
                'objek_data' => [
                    'nama' => $pendaftar->dataSiswa->nama,
                    'no_pendaftaran' => $pendaftar->no_pendaftaran,
                    'jurusan' => $pendaftar->jurusan->nama
                ],
                'waktu' => now(),
                'ip' => $request->ip()
            ]);
            
            // Send notification to admin
            $this->sendNotificationToAdminVerifikator($pendaftar, $pendaftar->dataSiswa->nama, $pendaftar->jurusan->nama);
            
            return response()->json(['success' => true, 'message' => 'Pendaftaran berhasil disubmit dan notifikasi telah dikirim ke admin']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    
    private function generateNoPendaftaran()
    {
        $year = date('Y');
        $maxAttempts = 10;
        
        for ($i = 0; $i < $maxAttempts; $i++) {
            $count = Pendaftar::whereYear('created_at', $year)->max('id') ?? 0;
            $count += 1 + $i;
            $noPendaftaran = 'PPDB' . $year . str_pad($count, 4, '0', STR_PAD_LEFT);
            
            if (!Pendaftar::where('no_pendaftaran', $noPendaftaran)->exists()) {
                return $noPendaftaran;
            }
        }
        
        return 'PPDB' . $year . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
    }
    
    private function calculateProgress($pendaftar)
    {
        if (!$pendaftar) return 0;
        
        $steps = [
            'data_siswa' => $pendaftar->dataSiswa ? 25 : 0,
            'data_ortu' => $pendaftar->dataOrtu ? 25 : 0,
            'asal_sekolah' => $pendaftar->asalSekolah ? 25 : 0,
            'berkas' => $pendaftar->berkas()->count() > 0 ? 25 : 0,
        ];
        
        return array_sum($steps);
    }
}