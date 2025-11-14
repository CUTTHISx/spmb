<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\PendaftarDataSiswa;
use Illuminate\Http\Request;

class PendaftarController extends Controller
{
    public function index()
    {
        $data = Pendaftar::with('user')->orderBy('id','desc')->get();
        return view('admin.pendaftar.index', compact('data'));
    }

    public function detail($id)
    {
        $detail = Pendaftar::with('user')->findOrFail($id);
        $siswa  = PendaftarDataSiswa::where('pendaftar_id',$id)->first();
        return view('admin.pendaftar.detail', compact('detail','siswa'));
    }

    public function verifikasi(Request $r, $id)
    {
        $status = $r->status; // ADM_PASS | ADM_REJECT

        Pendaftar::where('id',$id)->update([
            'status' => $status,
            'user_verifikasi_adm' => session('user')->nama,
            'tgl_verifikasi_adm' => now()
        ]);

        return redirect('/admin/pendaftar')->with('success','Status diperbarui');
    }
}

