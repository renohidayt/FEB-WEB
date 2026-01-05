<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        /*
        |--------------------------------------------------------------------------
        | Standard Security Headers
        |--------------------------------------------------------------------------
        */
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        /*
        |--------------------------------------------------------------------------
        | Content Security Policy (CSP)
        |--------------------------------------------------------------------------
        */
        $csp = "
    default-src 'self';

    script-src
        'self'
        'unsafe-inline'
        'unsafe-eval'
        https://cdn.tailwindcss.com
        https://cdn.jsdelivr.net
        https://cdnjs.cloudflare.com
        https://unpkg.com
        https://code.jquery.com
        https://ajax.googleapis.com
        https://kit.fontawesome.com
        https://www.youtube.com
        https://s.ytimg.com
        https://www.google.com
        https://www.google.co.id
        https://fast.wistia.com
        https://cdn.ckeditor.com;

    frame-src
        'self'
        https://www.youtube.com
        https://www.youtube-nocookie.com
        https://player.vimeo.com
        https://fast.wistia.net
        https://www.google.com
        https://www.google.co.id
        https://www.google.com/maps;

    style-src
        'self'
        'unsafe-inline'
        https://cdn.jsdelivr.net
        https://cdnjs.cloudflare.com
        https://fonts.googleapis.com
        https://cdn.flowbite.com
        https://flowbite.com
        https://fonts.bunny.net;

    font-src
        'self'
        data:
        https://fonts.gstatic.com
        https://cdnjs.cloudflare.com
        https://cdn.jsdelivr.net
        https://fonts.bunny.net;

    img-src
        'self'
        data:
        blob:
        https:;
        https://86445d34edbd.ngrok-free.app;

    connect-src
        'self'
        https:
        ws:;

    object-src 'none';
";

    

        // Rapikan spasi & newline
        $csp = preg_replace('/\s+/', ' ', trim($csp));

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
