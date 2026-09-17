<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        Vite::useCspNonce();
        $response = $next($request);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $policy = "base-uri 'self'; object-src 'none'; frame-ancestors 'none'; form-action 'self'";
        if (! app()->isLocal() || ! Vite::isRunningHot()) {
            $policy .= "; default-src 'self'; script-src 'self' 'nonce-".Vite::cspNonce()."'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: blob: https:; connect-src 'self'";
        }
        $response->headers->set('Content-Security-Policy', $policy);
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000');
        }
        if ($request->is('admin/*', 'login', 'api/*', 'projects*', 'landing-content') || $request->is('/')) {
            $response->headers->set('Cache-Control', 'no-store, private');
        }

        return $response;
    }
}
