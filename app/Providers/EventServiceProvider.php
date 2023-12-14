<?php

namespace BDS\Providers;

use BDS\Models\Part;
use BDS\Models\Supplier;
use BDS\Observers\PartObserver;
use BDS\Observers\SupplierObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use BDS\Listeners\User\AuthSubscriber;
use BDS\Models\Cleaning;
use BDS\Models\Material;
use BDS\Models\User;
use BDS\Observers\CleaningObserver;
use BDS\Observers\MaterialObserver;
use BDS\Observers\UserObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        /*Registered::class => [
            SendEmailVerificationNotification::class,
        ],*/
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        AuthSubscriber::class,
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        User::class => [UserObserver::class],
        Cleaning::class => [CleaningObserver::class],
        Material::class => [MaterialObserver::class],
        Part::class => [PartObserver::class],
        Supplier::class => [SupplierObserver::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
