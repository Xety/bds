<?php

namespace BDS\Providers;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\App;
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

        // Builder
        Builder::macro('search', function ($field, $string) {
            return $string ? $this->where($field, 'like', '%' . $string . '%') : $this;
        });

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

        // Set the all Settings in the config array.
        if (App::environment() !== 'testing' && Schema::hasTable('settings')) {
            $settings = Setting::all([
                'name',
                'value_int',
                'value_str',
                'value_bool',
            ])
            ->keyBy('name') // key every setting by its name
            ->transform(function ($setting) {
                return $setting->value; // return only the value
            })
            ->toArray();

            $array = [];
            // Convert the `dot` syntax to array.
            foreach ($settings as $setting => $value) {
                data_set($array, $setting, $value);
            }
            config(['settings' => $array]);
        }
    }
}
