<?php

namespace Tests\Feature\Listeners\Cleaning;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Selvah\Events\Cleaning\AlertEvent;
use Selvah\Listeners\Cleaning\AlertSubscriber;
use Selvah\Models\Material;
use Selvah\Models\User;
use Selvah\Notifications\Cleaning\AlertNotification;
use Tests\TestCase;

class AlertSubscriberTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_it_send_notifications()
    {
        Notification::fake();

        $material = Material::find(1);
        $event = new AlertEvent($material);
        $listener = new AlertSubscriber();
        $listener->handleAlert($event);

        $user = User::find(1);

        Notification::assertSentTo($user, AlertNotification::class);
    }
}
