<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed ...$roles  // daftar role yang diizinkan
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            // jika belum login
            return redirect()->route('login');
        }

        // cek apakah role user termasuk role yang diizinkan
        if (!in_array($user->role?->name, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
