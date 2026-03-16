<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Admin bisa akses semua
        if (auth()->user()->role === 'admin') {
            return $next($request);
        }

        if (auth()->user()->role !== $role) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return $next($request);
    }
}