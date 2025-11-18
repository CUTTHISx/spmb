<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        $users = Pengguna::orderBy('created_at', 'desc')->paginate(20);
        
        $stats = [
            'totalUsers' => Pengguna::count(),
            'adminCount' => Pengguna::where('role', 'admin')->count(),
            'kepsekCount' => Pengguna::where('role', 'kepsek')->count(),
            'keuanganCount' => Pengguna::where('role', 'keuangan')->count(),
            'verifikatorCount' => Pengguna::where('role', 'verifikator_adm')->count(),
            'pendaftarCount' => Pengguna::where('role', 'pendaftar')->count(),
        ];
        
        return view('admin.akun', array_merge(compact('users'), $stats));
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:pengguna,email',
                'role' => 'required|in:admin,kepsek,keuangan,verifikator,verifikator_adm,pendaftar',
                'password' => 'required|min:6'
            ]);
            
            Pengguna::create([
                'nama' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password_hash' => bcrypt($request->password)
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
    
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:pengguna,email,'.$id,
                'role' => 'required|in:admin,kepsek,keuangan,verifikator,verifikator_adm,pendaftar'
            ]);
            
            $user = Pengguna::findOrFail($id);
            $user->update([
                'nama' => $request->name,
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
    
    public function destroy(Request $request, $id)
    {
        try {
            $user = Pengguna::findOrFail($id);
            
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
    
    public function changePassword(Request $request, $id)
    {
        try {
            $request->validate([
                'password' => 'required|min:6'
            ]);
            
            $user = Pengguna::findOrFail($id);
            
            $user->update([
                'password_hash' => bcrypt($request->password)
            ]);
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Password berhasil diubah']);
            }
            
            return back()->with('success', 'Password berhasil diubah');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }
}