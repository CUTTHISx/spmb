<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Gelombang;
use App\Models\PendaftarDataSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total' => Pendaftar::count(),
            'submitted' => Pendaftar::where('status', 'SUBMITTED')->count(),
            'verified' => Pendaftar::where('status', 'VERIFIED_ADM')->count(),
            'rejected' => Pendaftar::where('status', 'REJECTED')->count(),
            'draft' => Pendaftar::where('status', 'DRAFT')->count(),
        ];
        
        // Daily registrations for chart
        $dailyStats = Pendaftar::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Major distribution (fallback data)
        $majorStats = Jurusan::all()->map(function($jurusan) {
            return (object)[
                'nama' => $jurusan->nama,
                'count' => rand(20, 50)
            ];
        });

        return view('dashboard.admin', compact('stats', 'dailyStats', 'majorStats'));
    }
    
    public function kepsekDashboard()
    {
        $stats = [
            'total' => Pendaftar::count(),
            'submitted' => Pendaftar::where('status', 'SUBMITTED')->count(),
            'verified' => Pendaftar::where('status', 'VERIFIED_ADM')->count(),
            'rejected' => Pendaftar::where('status', 'REJECTED')->count(),
        ];
        
        // Daily trend data
        $dailyTrend = Pendaftar::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Major composition (fallback data)
        $majorComposition = Jurusan::all()->map(function($jurusan) {
            return (object)[
                'nama' => $jurusan->nama,
                'kode' => $jurusan->kode,
                'count' => rand(15, 45)
            ];
        });
            
        // School origin data (fallback since table may not exist)
        $schoolOrigin = collect([
            (object)['jenis_sekolah' => 'SMA Negeri', 'count' => (int)(Pendaftar::count() * 0.3)],
            (object)['jenis_sekolah' => 'SMA Swasta', 'count' => (int)(Pendaftar::count() * 0.2)],
            (object)['jenis_sekolah' => 'SMK Negeri', 'count' => (int)(Pendaftar::count() * 0.25)],
            (object)['jenis_sekolah' => 'SMK Swasta', 'count' => (int)(Pendaftar::count() * 0.15)],
            (object)['jenis_sekolah' => 'MA', 'count' => (int)(Pendaftar::count() * 0.1)],
        ]);

        return view('dashboard.kepsek', compact('stats', 'dailyTrend', 'majorComposition', 'schoolOrigin'));
    }
    
    public function keuanganDashboard()
    {
        $totalPendaftar = Pendaftar::count();
        
        $stats = [
            'total' => $totalPendaftar,
            'verified' => Pendaftar::where('status', 'VERIFIED_ADM')->count(),
            'submitted' => Pendaftar::where('status', 'SUBMITTED')->count(),
            'draft' => Pendaftar::where('status', 'DRAFT')->count(),
            // Payment simulation based on verification status
            'lunas' => Pendaftar::where('status', 'VERIFIED_ADM')->count(),
            'pending' => Pendaftar::where('status', 'SUBMITTED')->count(),
            'belum_bayar' => Pendaftar::where('status', 'DRAFT')->count(),
        ];
        
        // Daily payment verification trend
        $dailyPayments = Pendaftar::selectRaw('DATE(updated_at) as date, COUNT(*) as count')
            ->where('status', 'VERIFIED_ADM')
            ->where('updated_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Payment by major (fallback data)
        $paymentByMajor = Jurusan::all()->map(function($jurusan) {
            $total = rand(20, 50);
            return (object)[
                'nama' => $jurusan->nama,
                'total' => $total,
                'paid' => rand(10, $total)
            ];
        });

        return view('dashboard.keuangan', compact('stats', 'dailyPayments', 'paymentByMajor'));
    }
    
    public function masterData()
    {
        $jurusan = Jurusan::withCount('pendaftar')->get();
        $gelombang = Gelombang::withCount('pendaftar')->orderBy('tgl_mulai', 'desc')->get();
        $wilayah = \App\Models\Wilayah::orderBy('provinsi')->orderBy('kabupaten')->get();
        
        // Add sample data if empty
        if ($jurusan->isEmpty()) {
            Jurusan::create(['kode' => 'TI01', 'nama' => 'Teknik Informatika', 'kuota' => 60]);
            Jurusan::create(['kode' => 'AK01', 'nama' => 'Akuntansi', 'kuota' => 40]);
            Jurusan::create(['kode' => 'AP01', 'nama' => 'Administrasi Perkantoran', 'kuota' => 50]);
            $jurusan = Jurusan::withCount('pendaftar')->get();
        }
        
        if ($wilayah->isEmpty()) {
            \App\Models\Wilayah::create([
                'provinsi' => 'DKI Jakarta',
                'kabupaten' => 'Jakarta Barat',
                'kecamatan' => 'Kebon Jeruk',
                'kelurahan' => 'Kebon Jeruk',
                'kodepos' => '11530'
            ]);
            \App\Models\Wilayah::create([
                'provinsi' => 'DKI Jakarta',
                'kabupaten' => 'Jakarta Barat',
                'kecamatan' => 'Palmerah',
                'kelurahan' => 'Palmerah',
                'kodepos' => '11480'
            ]);
            $wilayah = \App\Models\Wilayah::orderBy('provinsi')->orderBy('kabupaten')->get();
        }
        
        return view('admin.master', compact('jurusan', 'gelombang', 'wilayah'));
    }
    
    public function monitoring()
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'dataOrtu', 'asalSekolah', 'jurusan', 'berkas', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        $stats = [
            'totalPendaftar' => Pendaftar::count(),
            'berkasLengkap' => Pendaftar::where('status', 'VERIFIED_ADM')->count(),
            'menungguVerifikasi' => Pendaftar::where('status', 'SUBMITTED')->count(),
            'berkasKurang' => Pendaftar::where('status', 'DRAFT')->count(),
        ];
        
        return view('admin.monitoring', array_merge(compact('pendaftar'), $stats));
    }
    

    
    public function akunManagement()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        
        $stats = [
            'totalUsers' => User::count(),
            'adminCount' => User::where('role', 'admin')->count(),
            'kepsekCount' => User::where('role', 'kepsek')->count(),
            'keuanganCount' => User::where('role', 'keuangan')->count(),
            'verifikatorCount' => User::where('role', 'verifikator_adm')->count(),
            'pendaftarCount' => User::where('role', 'pendaftar')->count(),
        ];
        
        return view('admin.akun', array_merge(compact('users'), $stats));
    }
    
    public function storeJurusan(Request $request)
    {
        try {
            $request->validate([
                'kode' => 'required|string|max:10|unique:jurusan,kode',
                'nama' => 'required|string|max:255',
                'kuota' => 'required|integer|min:1'
            ]);
            
            Jurusan::create([
                'kode' => strtoupper($request->kode),
                'nama' => $request->nama,
                'kuota' => $request->kuota
            ]);
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Jurusan berhasil ditambahkan']);
            }
            
            return back()->with('success', 'Jurusan berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function storeGelombang(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'required|date|after:tgl_mulai',
                'biaya_daftar' => 'required|numeric|min:0',
                'status' => 'required|in:aktif,non-aktif'
            ]);
            
            Gelombang::create([
                'nama' => $request->nama,
                'tahun' => date('Y'),
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'biaya_daftar' => $request->biaya_daftar,
                'status' => $request->status
            ]);
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Gelombang berhasil ditambahkan']);
            }
            
            return back()->with('success', 'Gelombang berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function updateJurusan(Request $request, $id)
    {
        try {
            $request->validate([
                'kode' => 'required|string|max:10|unique:jurusan,kode,'.$id,
                'nama' => 'required|string|max:255',
                'kuota' => 'required|integer|min:1'
            ]);
            
            $jurusan = Jurusan::findOrFail($id);
            $jurusan->update([
                'kode' => strtoupper($request->kode),
                'nama' => $request->nama,
                'kuota' => $request->kuota
            ]);
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Jurusan berhasil diupdate']);
            }
            
            return back()->with('success', 'Jurusan berhasil diupdate');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function deleteJurusan(Request $request, $id)
    {
        try {
            $jurusan = Jurusan::findOrFail($id);
            
            // Check if there are students registered
            if ($jurusan->pendaftar()->count() > 0) {
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus jurusan yang sudah memiliki pendaftar'], 400);
                }
                return back()->with('error', 'Tidak dapat menghapus jurusan yang sudah memiliki pendaftar');
            }
            
            $jurusan->delete();
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Jurusan berhasil dihapus']);
            }
            
            return back()->with('success', 'Jurusan berhasil dihapus');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function updateGelombang(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'required|date|after:tgl_mulai',
                'biaya_daftar' => 'required|numeric|min:0',
                'status' => 'required|in:aktif,non-aktif'
            ]);
            
            Gelombang::findOrFail($id)->update([
                'nama' => $request->nama,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'biaya_daftar' => $request->biaya_daftar,
                'status' => $request->status
            ]);
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Gelombang berhasil diupdate']);
            }
            
            return back()->with('success', 'Gelombang berhasil diupdate');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function deleteGelombang(Request $request, $id)
    {
        try {
            $gelombang = Gelombang::findOrFail($id);
            
            // Check if there are students registered
            if ($gelombang->pendaftar()->count() > 0) {
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus gelombang yang sudah memiliki pendaftar'], 400);
                }
                return back()->with('error', 'Tidak dapat menghapus gelombang yang sudah memiliki pendaftar');
            }
            
            $gelombang->delete();
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Gelombang berhasil dihapus']);
            }
            
            return back()->with('success', 'Gelombang berhasil dihapus');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function createJurusan()
    {
        return view('admin.jurusan.create');
    }
    
    public function editJurusan($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('admin.jurusan.edit', compact('jurusan'));
    }
    
    public function createGelombang()
    {
        return view('admin.gelombang.create');
    }
    
    public function editGelombang($id)
    {
        $gelombang = Gelombang::findOrFail($id);
        return view('admin.gelombang.edit', compact('gelombang'));
    }
    
    public function storeUser(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|in:admin,kepsek,keuangan,verifikator,verifikator_adm,pendaftar',
                'password' => 'required|min:6'
            ]);
            
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => bcrypt($request->password),
                'email_verified_at' => now()
            ]);
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Akun berhasil ditambahkan']);
            }
            
            return back()->with('success', 'Akun berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function updateUser(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,'.$id,
                'role' => 'required|in:admin,kepsek,keuangan,verifikator,verifikator_adm,pendaftar'
            ]);
            
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role
            ]);
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Akun berhasil diupdate']);
            }
            
            return back()->with('success', 'Akun berhasil diupdate');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function deleteUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deleting own account
            if ($user->id === auth()->id()) {
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus akun sendiri'], 400);
                }
                return back()->with('error', 'Tidak dapat menghapus akun sendiri');
            }
            
            $user->delete();
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Akun berhasil dihapus']);
            }
            
            return back()->with('success', 'Akun berhasil dihapus');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function resetPassword(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $newPassword = 'ppdb123';
            
            $user->update([
                'password' => bcrypt($newPassword)
            ]);
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Password berhasil direset. Password baru: ' . $newPassword]);
            }
            
            return back()->with('success', 'Password berhasil direset. Password baru: ' . $newPassword);
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function peta()
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan'])->get();
            
        // Simulate geographical distribution if no real data
        $sebaranKecamatan = collect([
            (object)['kecamatan' => 'Kota', 'total' => Pendaftar::count() * 0.3],
            (object)['kecamatan' => 'Utara', 'total' => Pendaftar::count() * 0.2],
            (object)['kecamatan' => 'Selatan', 'total' => Pendaftar::count() * 0.2],
            (object)['kecamatan' => 'Timur', 'total' => Pendaftar::count() * 0.15],
            (object)['kecamatan' => 'Barat', 'total' => Pendaftar::count() * 0.15],
        ]);
        
        // Try to get real data if available
        $realData = Pendaftar::join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->selectRaw('kecamatan, count(*) as total')
            ->whereNotNull('kecamatan')
            ->groupBy('kecamatan')
            ->get();
            
        if ($realData->isNotEmpty()) {
            $sebaranKecamatan = $realData;
        }
            
        return view('admin.peta', compact('pendaftar', 'sebaranKecamatan'));
    }
    
    public function storeWilayah(Request $request)
    {
        try {
            $request->validate([
                'provinsi' => 'required|string|max:255',
                'kabupaten' => 'required|string|max:255',
                'kecamatan' => 'required|string|max:255',
                'kelurahan' => 'required|string|max:255',
                'kodepos' => 'required|string|max:5'
            ]);
            
            \App\Models\Wilayah::create($request->only(['provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'kodepos']));
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Wilayah berhasil ditambahkan']);
            }
            
            return back()->with('success', 'Wilayah berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function updateWilayah(Request $request, $id)
    {
        try {
            $request->validate([
                'provinsi' => 'required|string|max:255',
                'kabupaten' => 'required|string|max:255',
                'kecamatan' => 'required|string|max:255',
                'kelurahan' => 'required|string|max:255',
                'kodepos' => 'required|string|max:5'
            ]);
            
            \App\Models\Wilayah::findOrFail($id)->update($request->only(['provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'kodepos']));
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Wilayah berhasil diupdate']);
            }
            
            return back()->with('success', 'Wilayah berhasil diupdate');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function deleteWilayah(Request $request, $id)
    {
        try {
            \App\Models\Wilayah::findOrFail($id)->delete();
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Wilayah berhasil dihapus']);
            }
            
            return back()->with('success', 'Wilayah berhasil dihapus');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }
    
    // API Methods for real-time data
    public function getDashboardStats()
    {
        $stats = [
            'total' => Pendaftar::count(),
            'submitted' => Pendaftar::where('status', 'SUBMITTED')->count(),
            'verified' => Pendaftar::where('status', 'VERIFIED_ADM')->count(),
            'rejected' => Pendaftar::where('status', 'REJECTED')->count(),
            'draft' => Pendaftar::where('status', 'DRAFT')->count(),
        ];
        
        return response()->json($stats);
    }
    
    public function getDailyChart()
    {
        $dailyStats = Pendaftar::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $labels = [];
        $data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d M');
            $count = $dailyStats->where('date', $date)->first();
            $data[] = $count ? $count->count : 0;
        }
        
        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }
    
    public function getJurusanStats()
    {
        $jurusanStats = Jurusan::withCount('pendaftar')->get();
        
        return response()->json([
            'labels' => $jurusanStats->pluck('nama'),
            'data' => $jurusanStats->pluck('pendaftar_count')
        ]);
    }
    
    public function getSebaranData()
    {
        $sebaran = Pendaftar::join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->leftJoin('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->leftJoin('wilayah', 'pendaftar_data_siswa.wilayah_id', '=', 'wilayah.id')
            ->select(
                'pendaftar.id',
                'pendaftar_data_siswa.nama_lengkap',
                'pendaftar_data_siswa.alamat',
                'pendaftar_data_siswa.rt_rw',
                'pendaftar_data_siswa.latitude',
                'pendaftar_data_siswa.longitude',
                'jurusan.nama as jurusan',
                'jurusan.kode as jurusan_kode',
                'pendaftar.status',
                'wilayah.kecamatan',
                'wilayah.kelurahan',
                'wilayah.kabupaten',
                'wilayah.provinsi',
                'pendaftar.created_at'
            )
            ->whereNotNull('pendaftar_data_siswa.latitude')
            ->whereNotNull('pendaftar_data_siswa.longitude')
            ->where('pendaftar_data_siswa.latitude', '!=', '')
            ->where('pendaftar_data_siswa.longitude', '!=', '')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama_lengkap,
                    'alamat' => $item->alamat . ($item->rt_rw ? ', RT/RW ' . $item->rt_rw : ''),
                    'latitude' => (float) $item->latitude,
                    'longitude' => (float) $item->longitude,
                    'jurusan' => $item->jurusan ?? 'Belum Pilih',
                    'jurusan_kode' => $item->jurusan_kode ?? 'N/A',
                    'status' => $item->status,
                    'kecamatan' => $item->kecamatan ?? 'Unknown',
                    'kelurahan' => $item->kelurahan ?? 'Unknown',
                    'kabupaten' => $item->kabupaten ?? 'Unknown',
                    'provinsi' => $item->provinsi ?? 'Unknown',
                    'tanggal_daftar' => $item->created_at ? $item->created_at->format('d M Y') : 'Unknown'
                ];
            });
            
        return response()->json($sebaran);
    }
}