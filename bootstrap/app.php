<?php

use App\Http\Middleware\CompletedProfile;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    commands: __DIR__ . '/../routes/console.php',
    channels: __DIR__ . '/../routes/channels.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->redirectGuestsTo('/auth/login');
    $middleware->redirectUsersTo('/dashboard');

    $middleware->alias([
      'role' => RoleMiddleware::class,
      'completed' => CompletedProfile::class,
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    //
  })->create();
