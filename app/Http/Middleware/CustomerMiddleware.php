<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role_users !== 'customer') {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Customer.');
        }

        return $next($request);
    }
}
