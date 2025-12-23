<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah user sudah login dan apakah role-nya sesuai
        if (!$request->user() || $request->user()->role !== $role) {
            // Jika bukan admin, tampilkan error 403 (Forbidden)
            abort(403, 'Maaf Sultan, halaman ini hanya untuk Admin.');
        }

        return $next($request);
    }
}