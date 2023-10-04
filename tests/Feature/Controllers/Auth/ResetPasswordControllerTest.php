<?php
namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    public function test_show_reset_form_can_be_rendered()
    {
        $response = $this->get('/password/reset/123456');
        $response->assertSuccessful();
    }
}
