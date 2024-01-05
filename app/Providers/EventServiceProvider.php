<?php

namespace BDS\Providers;


use BDS\Listeners\Cleaning\AlertSubscriber as AlertCleaningSubscriber;
use BDS\Listeners\Part\AlertSubscriber as AlertPartSubscriber;
use BDS\Listeners\User\AuthSubscriber;
use BDS\Models\Part;
use BDS\Models\PartEntry;
use BDS\Models\PartExit;
use BDS\Models\Supplier;
use BDS\Models\Cleaning;
use BDS\Models\Material;
use BDS\Models\User;
use BDS\Observers\CleaningObserver;
use BDS\Observers\MaterialObserver;
use BDS\Observers\UserObserver;
use BDS\Observers\PartEntryObserver;
use BDS\Observers\PartExitObserver;
use BDS\Observers\PartObserver;
use BDS\Observers\SupplierObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        AlertCleaningSubscriber::class,
        AlertPartSubscriber::class,
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
        PartEntry::class => [PartEntryObserver::class],
        PartExit::class => [PartExitObserver::class],
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
