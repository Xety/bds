<?php
namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    public function test_password_reset_can_be_rendered(): void
    {
        $response = $this->get('/password/reset');
        $response->assertSuccessful();
    }

    public function test_can_send_reset_link_email(): void
    {
        $response = $this->post('/password/email', ['email' => 'emeric@xetaravel.com']);
        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }
}
