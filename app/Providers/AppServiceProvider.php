<?php

namespace BDS\Providers;

use BDS\Listeners\Cleaning\AlertSubscriber as AlertCleaningSubscriber;
use BDS\Listeners\Part\AlertSubscriber as AlertPartSubscriber;
use BDS\Listeners\Site\SiteSubscriber;
use BDS\Listeners\User\AuthSubscriber;
use BDS\Models\Permission;
use BDS\Models\Role;
use BDS\Models\Selvah\CorrespondenceSheet;
use BDS\Models\User;
use BDS\Policies\PermissionPolicy;
use BDS\Policies\RolePolicy;
use BDS\Policies\Selvah\CorrespondenceSheetPolicy;
use BDS\Settings\Settings;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rules\Password;
use Livewire\Volt\Volt;

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
        // Models
        //Model::preventLazyLoading();
        //Model::preventAccessingMissingAttributes();

        // Routes
        Route::namespace('BDS\Http\Controllers');
        Route::pattern('id', '[0-9]+');

        // Policies
        Gate::policy(Permission::class, PermissionPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(CorrespondenceSheet::class, CorrespondenceSheetPolicy::class);
        Gate::define('viewPulse', function (User $user) {
            return $user->hasRole('Développeur');
        });

        // Subscribers
        Event::subscribe(AlertCleaningSubscriber::class);
        //Event::subscribe(AlertPartSubscriber::class);
        Event::subscribe(SiteSubscriber::class);
        Event::subscribe(AuthSubscriber::class);

        // Volt
        Volt::mount([
            resource_path('views/livewire'),
            resource_path('views/pages'),
        ]);

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

        // Register the Settings class
        $this->app->singleton(Settings::class, function (Application $app) {
            return new Settings($app['cache.store']);
        });


        /**
         * All credits from this blade directive goes to Konrad Kalemba.
         * Just copied and modified for my very specifc use case.
         *
         * https://github.com/konradkalemba/blade-components-scoped-slots
         */
        Blade::directive('scope', function ($expression) {
            // Split the expression by `top-level` commas (not in parentheses)
            $directiveArguments = preg_split("/,(?![^\(\(]*[\)\)])/", $expression);
            $directiveArguments = array_map('trim', $directiveArguments);

            [$name, $functionArguments] = $directiveArguments;

            /**
             *  Slot names can`t contains dot , eg: `user.city`.
             *  So we convert `user.city` to `user___city`
             *
             *  Later, on component you must replace it back.
             */
            $name = str_replace('.', '___', $name);

            return "<?php \$__env->slot({$name}, function({$functionArguments}) use (\$__env) { ?>";
        });

        Blade::directive('endscope', function () {
            return '<?php }); ?>';
        });
    }
}
