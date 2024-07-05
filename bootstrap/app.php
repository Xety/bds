<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \Xetaio\IpTraceable\Http\Middleware\IpTraceable::class,
            \BDS\Http\Middleware\SetCurrentSite::class,
            \BDS\Http\Middleware\SetCurrentSitePermission::class,
        ]);

        $middleware->alias([
            'auth' => \BDS\Http\Middleware\Authenticate::class,

            // Spatie
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function(\Exception $e) {
            // Error 404 model not found
            if ($e->getPrevious() instanceof ModelNotFoundException) {
                return Redirect::route('dashboard.index')
                    ->with('toasts', [[
                        'type' => 'error',
                        'duration' => 4000,
                        'message' =>"Cette donnée n'existe pas ou a été supprimée !"
                    ]]);
            };

            // Error 419 csrf token expiration error
            if ($e->getPrevious() instanceof TokenMismatchException) {
                return Redirect::back()
                    ->error("Vous avez mis trop de temps à valider le formulaire ! C'est l'heure de prendre un café !");
            };

            // Error 403 Access unauthorized
            if ($e->getPrevious() instanceof AuthorizationException) {
                return Redirect::route('dashboard.index')
                    ->error("Vous n'avez pas l'autorisation d'accéder à cette page !");
            }
        });
    })
    ->withSchedule(function (Schedule $schedule) {
        // Users Deactivate
        $schedule->command('users:deactivate')->everyFifteenMinutes();

        if (\Illuminate\Support\Facades\App::environment() == 'production') {
            // Backup Database
            $schedule->command('backup:clean')->daily()->at('01:00');
            $schedule->command('backup:run')->daily()->at('01:30');

            // Cleaning Alerts
            //$schedule->command('cleaning:alert')->everyFifteenMinutes();
        }
    })->create();
