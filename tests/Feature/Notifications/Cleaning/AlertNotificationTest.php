<?php
namespace Tests\Feature\Notifications\Cleaning;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Selvah\Models\Material;
use Selvah\Models\User;
use Selvah\Notifications\Cleaning\AlertNotification;
use Tests\TestCase;

class AlertNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    private User $user;

    public function test_alert_notification_is_send_via_database_and_mail()
    {
        Notification::fake();

        $this->user = User::find(1);

        $material = Material::find(1);
        $material->cleaning_alert = true;
        $material->cleaning_alert_email = true;
        $material->save();


        $this->user->notify(new AlertNotification($material));

        Notification::assertSentTo($this->user, AlertNotification::class, function ($notification, $channels) use($material) {
            $this->assertContains('database', $channels);
            $this->assertContains('mail', $channels);

            $rendered = $notification->toMail($this->user)->render();
            $this->assertStringContainsString($material->name, $rendered);

            return true;
        });
    }

    public function test_alert_notification_is_send_via_database_not_mail()
    {
        Notification::fake();

        $this->user = User::find(1);

        $material = Material::find(1);
        $material->cleaning_alert = true;
        $material->save();

        $this->user->notify(new AlertNotification($material));

        Notification::assertSentTo($this->user, AlertNotification::class, function ($notification, $channels) use($material) {
            $this->assertContains('database', $channels);
            $this->assertNotContains('mail', $channels);

            $rendered = $notification->toDatabase($this->user);
            $this->assertEquals('alert', $rendered['type']);
            $this->assertEquals('BMP1', $rendered['message_key'][0]);

            return true;
        });
    }
}
