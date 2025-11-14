<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\Gelombang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PendaftarController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->first();
        
        $stats = [
            'status' => $pendaftar->status ?? 'DRAFT',
            'progress' => $this->calculateProgress($pendaftar),
            'gelombang_aktif' => Gelombang::where('tgl_mulai', '<=', now())
                ->where('tgl_selesai', '>=', now())
                ->first(),
        ];
        
        $jurusan = Jurusan::all();
        
        return view('dashboard.pendaftar', compact('stats', 'pendaftar', 'jurusan'));
    }
    
    public function form()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->with(['dataSiswa', 'dataOrtu', 'asalSekolah'])->first();
        $jurusan = Jurusan::all();
        $gelombang = Gelombang::where('tgl_mulai', '<=', now())
            ->where('tgl_selesai', '>=', now())
            ->first();
        $wilayah = \App\Models\Wilayah::all();
            
        return view('pendaftaran.form', compact('pendaftar', 'jurusan', 'gelombang', 'wilayah'));
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'jurusan_id' => 'required|exists:jurusan,id',
            'nik' => 'required|string|max:16',
            'nisn' => 'required|string|max:10',
            'nama' => 'required|string|max:120',
            'jk' => 'required|in:L,P',
            'tmp_lahir' => 'required|string|max:60',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required|string',
            'wilayah_id' => 'required|exists:wilayah,id',
            'nama_sekolah' => 'required|string|max:150',
            'ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'akta' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto' => 'required|file|mimes:jpg,jpeg,png|max:1024',
            'bukti_bayar' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'nominal' => 'required|numeric|min:150000',
            'tgl_bayar' => 'required|date',
            'nama_pengirim' => 'required|string|max:100',
        ]);
        
        $gelombang = Gelombang::where('tgl_mulai', '<=', now())
            ->where('tgl_selesai', '>=', now())
            ->first();
            
        $pendaftar = Pendaftar::updateOrCreate(
            ['user_id' => $user->id],
            [
                'jurusan_id' => $request->jurusan_id,
                'gelombang_id' => $gelombang ? $gelombang->id : null,
                'status' => 'DRAFT',
                'no_pendaftaran' => 'PPDB' . date('Y') . str_pad(Pendaftar::count() + 1, 4, '0', STR_PAD_LEFT)
            ]
        );
        
        // Save data siswa
        \App\Models\PendaftarDataSiswa::updateOrCreate(
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
            ]
        );
        
        // Save data orang tua
        \App\Models\PendaftarDataOrtu::updateOrCreate(
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
        \App\Models\PendaftarAsalSekolah::updateOrCreate(
            ['pendaftar_id' => $pendaftar->id],
            [
                'npsn' => $request->npsn,
                'nama_sekolah' => $request->nama_sekolah,
                'kabupaten' => $request->kabupaten,
                'nilai_rata' => $request->nilai_rata,
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
                $file->move(public_path('uploads/berkas'), $filename);
                
                \App\Models\PendaftarBerkas::updateOrCreate(
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
        
        // Handle payment
        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $filename = time() . '_bukti_bayar.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pembayaran'), $filename);
            
            \App\Models\PendaftarPembayaran::updateOrCreate(
                ['pendaftar_id' => $pendaftar->id],
                [
                    'nominal' => $request->nominal,
                    'tgl_bayar' => $request->tgl_bayar,
                    'tanggal_transfer' => $request->tgl_bayar,
                    'nama_pengirim' => $request->nama_pengirim,
                    'bukti_pembayaran' => 'uploads/pembayaran/' . $filename,
                    'status_verifikasi' => 'PENDING'
                ]
            );
        }
        
        // Update status to SUBMITTED
        $pendaftar->update(['status' => 'SUBMITTED']);
        
        return redirect('/dashboard/pendaftar')->with('success', 'Pendaftaran berhasil disubmit! Silakan tunggu proses verifikasi.');
    }
    
    public function upload()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->first();
        
        return view('pendaftaran.upload', compact('pendaftar'));
    }
    
    public function storeUpload(Request $request)
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->first();
        
        if (!$pendaftar) {
            return redirect('/dashboard/pendaftar')->with('error', 'Silakan lengkapi data pendaftaran terlebih dahulu');
        }
        
        $request->validate([
            'ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'akta' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto' => 'required|file|mimes:jpg,jpeg,png|max:1024',
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
                $file->move(public_path('uploads/berkas'), $filename);
                
                \App\Models\PendaftarBerkas::updateOrCreate(
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
        
        return redirect('/dashboard/pendaftar')->with('success', 'Berkas berhasil diupload');
    }
    
    public function berkas()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->first();
        
        return view('pendaftaran.berkas', compact('pendaftar'));
    }
    
    public function pembayaran()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->first();
        
        return view('pendaftaran.pembayaran', compact('pendaftar'));
    }
    
    public function status()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->first();
        
        return view('pendaftaran.status', compact('pendaftar'));
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
            $file->move(public_path('uploads/pembayaran'), $filename);
            
            \App\Models\PendaftarPembayaran::updateOrCreate(
                ['pendaftar_id' => $pendaftar->id],
                [
                    'nominal' => $request->nominal,
                    'tgl_bayar' => $request->tanggal_transfer,
                    'nama_pengirim' => $request->nama_pengirim,
                    'bukti_bayar' => 'uploads/pembayaran/' . $filename,
                    'status_verifikasi' => 'PENDING',
                    'catatan' => $request->catatan
                ]
            );
        }
        
        return redirect('/pendaftaran/status')->with('success', 'Bukti pembayaran berhasil diupload');
    }
    
    public function autoSave(Request $request)
    {
        $user = Auth::user();
        
        // Create or get pendaftar record
        $pendaftar = Pendaftar::firstOrCreate(
            ['user_id' => $user->id],
            [
                'status' => 'DRAFT',
                'no_pendaftaran' => 'PPDB' . date('Y') . str_pad(Pendaftar::count() + 1, 4, '0', STR_PAD_LEFT)
            ]
        );
        
        // Save data siswa if provided
        if ($request->has('nama')) {
            \App\Models\PendaftarDataSiswa::updateOrCreate(
                ['pendaftar_id' => $pendaftar->id],
                $request->only(['nik', 'nisn', 'nama', 'jk', 'tmp_lahir', 'tgl_lahir', 'alamat', 'wilayah_id'])
            );
        }
        
        // Save data orang tua if provided
        if ($request->has('nama_ayah')) {
            \App\Models\PendaftarDataOrtu::updateOrCreate(
                ['pendaftar_id' => $pendaftar->id],
                $request->only(['nama_ayah', 'pekerjaan_ayah', 'hp_ayah', 'nama_ibu', 'pekerjaan_ibu', 'hp_ibu', 'wali_nama', 'wali_hp'])
            );
        }
        
        // Save asal sekolah if provided
        if ($request->has('nama_sekolah')) {
            \App\Models\PendaftarAsalSekolah::updateOrCreate(
                ['pendaftar_id' => $pendaftar->id],
                $request->only(['npsn', 'nama_sekolah', 'kabupaten', 'nilai_rata'])
            );
        }
        
        // Update jurusan if provided
        if ($request->has('jurusan_id')) {
            $pendaftar->update(['jurusan_id' => $request->jurusan_id]);
        }
        
        return response()->json(['success' => true]);
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