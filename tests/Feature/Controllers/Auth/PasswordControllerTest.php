<?php
namespace Tests\Feature\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Selvah\Models\User;
use Selvah\Notifications\Auth\RegisteredNotification;
use Selvah\Providers\RouteServiceProvider;
use Tests\TestCase;

class PasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_show_setup_form_can_be_rendered(): void
    {
        $url = URL::temporarySignedRoute(
            'auth.password.setup',
            Carbon::now()->addMinutes(Config::get('auth.password_setup.timeout', 1440)),
            [
                'id' => 1,
                'hash' => sha1('emeric@xetaravel.com2'),
            ]
        );
        $response = $this->get($url);

        $response->assertOk();
    }

    public function test_show_setup_form_without_valid_signed_route(): void
    {
        $response = $this->get('password/setup/8/123456789');

        $response->assertStatus(403);
    }

    public function test_setup_with_valid_password(): void
    {
        $response = $this->post('password/setup/1/123456789', [
            'password' => 'Ab123456+',
            'password_confirmation' => 'Ab123456+'
        ]);

        $response->assertRedirect(route('dashboard.index'));
        $response->assertSessionHas('success');
    }

    public function test_setup_with_invalid_id(): void
    {
        $response = $this->post('password/setup/999/123456789', [
            'password' => 'Ab123456+',
            'password_confirmation' => 'Ab123456+'
        ]);

        $response->assertStatus(404);
    }

    public function test_setup_already_setup_password(): void
    {
        $this->post('password/setup/1/123456789', [
            'password' => 'Ab123456+',
            'password_confirmation' => 'Ab123456+'
        ]);
        $response = $this->post('password/setup/1/123456789', [
            'password' => 'Ab123456+',
            'password_confirmation' => 'Ab123456+'
        ]);

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_show_resend_request_form_can_be_rendered(): void
    {
        $response = $this->get('password/resend');

        $response->assertOk();
    }

    public function test_resend_with_invalid_email(): void
    {
        $response = $this->post('password/resend', [
            'email' => 'invalid@xetaravel.com'
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_resend_with_valid_email(): void
    {
        Notification::fake();

        $response = $this->post('password/resend', [
            'email' => 'emeric@xetaravel.com'
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');

        Notification::assertSentTo(User::find(1), RegisteredNotification::class);
    }

}
