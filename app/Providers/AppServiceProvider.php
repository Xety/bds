<?php

namespace BDS\Providers;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rules\Password;
use BDS\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set default password rule for the application.
        Password::defaults(function () {
            $rule = Password::min(8);

            return App::isProduction() || App::isLocal()
                        ? $rule->letters()
                                ->mixedCase()
                                ->numbers()
                                ->symbols()
                        : $rule;
        });

        // Set the default locale of the application.
        App::setLocale(config('app.locale'));

        // Pagination
        Paginator::defaultView('vendor.pagination.tailwind');

        // ResetPassword
        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            // Add `auth.` to the route to respect the namespace.
            return url(route('auth.password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        });
    }
}
