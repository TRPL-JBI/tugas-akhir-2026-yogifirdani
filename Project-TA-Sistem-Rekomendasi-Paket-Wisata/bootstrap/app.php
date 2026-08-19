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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
        $middleware->redirectGuestsTo(fn (\Illuminate\Http\Request $request) => route('login', ['locale' => app()->getLocale() ?: config('app.locale', 'id')]));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            return redirect()->route('login', ['locale' => app()->getLocale() ?: 'id'])
                ->withErrors(['email' => 'Sesi Anda telah berakhir karena terlalu lama tidak aktif. Silakan login kembali.']);
        });
    })->create();
