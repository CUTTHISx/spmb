<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\LogAktivitas;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPendaftar = Pendaftar::count();
        $diterima = Pendaftar::where('status', 'DITERIMA')->count();
        $menunggu = Pendaftar::whereIn('status', ['DRAFT', 'SUBMITTED', 'REVIEW_ADMINISTRASI', 'REVIEW_AKADEMIK'])->count();
        $ditolak = Pendaftar::where('status', 'DITOLAK')->count();
        
        $recentActivities = LogAktivitas::with('pengguna')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPendaftar',
            'diterima', 
            'menunggu',
            'ditolak',
            'recentActivities'
        ));
    }
}