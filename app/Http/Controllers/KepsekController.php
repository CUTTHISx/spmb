<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;

class KepsekController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total' => Pendaftar::count(),
            'submitted' => Pendaftar::where('status', 'SUBMITTED')->count(),
            'verified' => Pendaftar::where('status', 'VERIFIED_ADM')->count(),
            'rejected' => Pendaftar::where('status', 'REJECTED')->count(),
        ];

        return view('dashboard.kepsek', compact('stats'));
    }
}