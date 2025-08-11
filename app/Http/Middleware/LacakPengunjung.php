<?php

namespace App\Http\Middleware;

use App\Models\Pengunjung;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LacakPengunjung
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tracking untuk environment local
        if (app()->environment(['local', 'testing'])) {
            return $next($request);
        }

        // Skip tracking untuk admin panel dan API
        if ($request->is('admin/*') || $request->is('api/*') || $request->is('livewire/*')) {
            return $next($request);
        }

        // Skip untuk assets
        if ($request->is('css/*') || $request->is('js/*') || $request->is('images/*') || $request->is('storage/*')) {
            return $next($request);
        }

        $sessionKey = 'last_visit_' . md5($request->ip() . $request->path());
        $lastVisit = session($sessionKey);

        // Hanya track jika belum dikunjungi dalam 30 menit terakhir
        if (!$lastVisit || now()->diffInMinutes($lastVisit) > 30) {
            Pengunjung::trackVisit($request);
            session([$sessionKey => now()]);
        }

        $response = $next($request);

        return $response;
    }
}
