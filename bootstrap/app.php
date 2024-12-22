<?php

use App\Http\Middleware\CheckRoleRedirect;
use App\Http\Middleware\FirstAuthMiddleware;
use App\Http\Middleware\NotFirstAuthMiddleware;
use App\Http\Middleware\RoleRedirectMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('roles', [
            RoleRedirectMiddleware::class
        ]);
        $middleware->alias([
            'first.auth' => FirstAuthMiddleware::class,
            'role' => IsAdminMiddleware::class,
            'not.first.auth' => IsAdminMiddleware::class,
            'check.role.redirect' => CheckRoleRedirect::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
