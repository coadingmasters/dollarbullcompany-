<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        channels: __DIR__.'/../routes/channels.php',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'verified.course' => \App\Http\Middleware\EnsureVerifiedCourseAccess::class,
            'enrollment.approved' => \App\Http\Middleware\EnsureEnrollmentApproved::class,
            'admin' => \App\Http\Middleware\EnsureAdmin::class,
        ]);

        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }

            if ($request->is('live-sessions') || $request->is('live-sessions/*')) {
                return route('student.login', [
                    'redirect' => $request->fullUrl(),
                ]);
            }

            if ($request->is('courses/*/learn')) {
                return route('student.login', [
                    'redirect' => $request->fullUrl(),
                ]);
            }

            return route('student.login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
