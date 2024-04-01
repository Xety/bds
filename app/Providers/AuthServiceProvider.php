<?php

namespace BDS\Providers;

use BDS\Models\Selvah\CorrespondenceSheet;
use BDS\Models\User;
use BDS\Policies\Selvah\CorrespondenceSheetPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use BDS\Policies\PermissionPolicy;
use BDS\Policies\RolePolicy;
use BDS\Models\Permission;
use BDS\Models\Role;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        CorrespondenceSheet::class => CorrespondenceSheetPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('viewPulse', function (User $user) {
            return $user->hasRole('Développeur');
        });
    }
}
