<?php

namespace BDS\Listeners\User;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Notification;
use BDS\Events\Auth\RegisteredEvent;
use BDS\Notifications\Auth\RegisteredNotification;

class AuthSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @return array<string, string>
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            RegisteredEvent::class => 'handleUserRegistered',
        ];
    }

    /**
     * Handle user registered events.
     */
    public function handleUserRegistered(RegisteredEvent $event): void
    {
        $user = $event->user;

        $user->sendEmailRegisteredNotification();
    }
}
