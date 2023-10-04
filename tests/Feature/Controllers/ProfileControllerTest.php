<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Selvah\Models\User;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::find(1);

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }
}
