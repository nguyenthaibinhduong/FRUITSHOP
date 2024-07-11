<?php

use App\Http\Middleware\CheckAuth;
use App\Http\Middleware\CheckLogin;
use App\Http\Middleware\CheckPermission;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Mockery\Exception\InvalidOrderException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'authAdmin' => CheckAuth::class,
            'checkpermission'=>CheckPermission::class,
            'checklogin'=>CheckLogin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
         $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->view('error.error404', [], 404);
        });
    })->create();