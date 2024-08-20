<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
//use App\Http\Middleware\EnsureTokenIsValid;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        
        //optional custom routefile
        then: function () 
        {
            Route::prefix('teacher')->group(base_path('routes/teacher.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
       $middleware->alias([
        'isAdmin'=>\App\Http\Middleware\IsAdmin::class,

       ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
