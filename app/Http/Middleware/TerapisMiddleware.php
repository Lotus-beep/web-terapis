<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TerapisMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role_users !== 'terapis') {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Terapis.');
        }

        return $next($request);
    }
}
