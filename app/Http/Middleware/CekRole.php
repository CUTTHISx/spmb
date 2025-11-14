<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = session('user');
        
        if (!$user || $user->role !== $role) {
            return redirect('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        return $next($request);
    }
}