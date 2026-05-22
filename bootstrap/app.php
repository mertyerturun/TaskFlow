<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware; // Bizim yazdığımız middleware'i dahil ettik [cite: 512]

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Hocanın Kısa Ad Tanımlama (Alias) Mantığı [cite: 515]
        $middleware->alias([
            'role' => RoleMiddleware::class, // Artık rotalarda 'role:admin' şeklinde çağırabileceğiz [cite: 516]
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
