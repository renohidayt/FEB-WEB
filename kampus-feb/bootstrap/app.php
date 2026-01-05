<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // 🔒 TRUST PROXIES - Penting untuk ngrok!
        $middleware->trustProxies(at: '*');

        // ROUTE MIDDLEWARE ALIAS
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'security' => \App\Http\Middleware\SecurityHeaders::class,
            'throttle.uploads' => \App\Http\Middleware\ThrottleFileUploads::class,
        ]);

        // GLOBAL MIDDLEWARE (dipasang ke semua route)
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();