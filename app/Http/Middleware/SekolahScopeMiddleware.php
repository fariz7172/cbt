<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SekolahScopeMiddleware
{
    /**
     * Handle an incoming request.
     * 
     * This middleware automatically scopes queries to the user's sekolah
     * for admin, guru, and siswa roles. Super admin can see all data.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Super admin can see all data, skip scoping
        if ($user && $user->isSuperAdmin()) {
            return $next($request);
        }

        // For admin, guru, and siswa - add global scope
        if ($user && $user->sekolah_id) {
            // Add global scope to models that have sekolah_id
            \App\Models\Kelas::addGlobalScope('sekolah', function ($builder) use ($user) {
                $builder->where('sekolah_id', $user->sekolah_id);
            });

            \App\Models\Pelajaran::addGlobalScope('sekolah', function ($builder) use ($user) {
                $builder->where('sekolah_id', $user->sekolah_id);
            });

            \App\Models\Guru::addGlobalScope('sekolah', function ($builder) use ($user) {
                $builder->where('sekolah_id', $user->sekolah_id);
            });

            \App\Models\Siswa::addGlobalScope('sekolah', function ($builder) use ($user) {
                $builder->where('sekolah_id', $user->sekolah_id);
            });

            \App\Models\Rombel::addGlobalScope('sekolah', function ($builder) use ($user) {
                $builder->where('sekolah_id', $user->sekolah_id);
            });

            \App\Models\User::addGlobalScope('sekolah', function ($builder) use ($user) {
                // Only scope non-super-admin users
                $builder->where(function ($query) use ($user) {
                    $query->where('sekolah_id', $user->sekolah_id)
                          ->orWhere('role', 'super_admin');
                });
            });
        }

        return $next($request);
    }
}
