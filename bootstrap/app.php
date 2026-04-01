<?php

use App\Http\Middleware\SecurityHeaders;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Security Middleware Stack
        $middleware->web([
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            ValidateCsrfToken::class,
            TrimStrings::class,
            ConvertEmptyStringsToNull::class,
            SecurityHeaders::class,
        ]);

        // Rate Limiting Configuration
        $middleware->api([
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
        ]);

        // Rate Limiting Groups
        $middleware->group('throttle', [
            'throttle:60,1', // 60 requests per minute
        ]);

        $middleware->group('throttle.strict', [
            'throttle:10,1', // 10 requests per minute for sensitive operations
        ]);

        $middleware->group('throttle.auth', [
            'throttle:30,1', // 30 requests per minute for authenticated users
        ]);

        // CORS Configuration
        $middleware->group('cors', [
            HandleCors::class,
        ]);

        // Security Headers
        $middleware->group('security', [
            TrustProxies::class,
            SetCacheHeaders::class,
        ]);

        // Authentication
        $middleware->alias([
            'auth' => Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
            'cache.headers' => SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle' => ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Security Exception Handling
        $exceptions->shouldRenderJsonWhen(function ($request, Throwable $e) {
            if ($request->expectsJson()) {
                return true;
            }

            // Log security exceptions
            if ($e instanceof \Illuminate\Session\TokenMismatchException) {
                \Log::warning('CSRF token mismatch detected', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'url' => $request->fullUrl(),
                ]);
            }

            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                \Log::warning('Unauthorized access attempt', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'url' => $request->fullUrl(),
                ]);
            }

            return false;
        });
    })->create();
