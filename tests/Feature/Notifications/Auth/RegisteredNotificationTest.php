<?php
namespace Notifications\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Selvah\Models\User;
use Selvah\Notifications\Auth\RegisteredNotification;
use Tests\TestCase;

class RegisteredNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    private User $user;

    public function test_registered_notification_is_send_via_mail()
    {
        Notification::fake();

        $this->user = User::find(1);

        $this->user->notify(new RegisteredNotification());

        Notification::assertSentTo($this->user, RegisteredNotification::class, function ($notification, $channels) {
            $this->assertContains('mail', $channels);

            $rendered = $notification->toMail($this->user)->render();
            $this->assertStringContainsString($this->user->full_name, $rendered);

            return true;
        });
    }
}
