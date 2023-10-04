<?php
namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Selvah\Models\User;

class PartControllerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_show_part_can_be_rendered(): void
    {
        $user = User::find(1);

        $response = $this
            ->actingAs($user)
            ->get('/parts/1')
            ->assertSee('Ventouse');

        $response->assertOk();
    }

    public function test_show_part_not_found(): void
    {
        $user = User::find(1);

        $response = $this
            ->actingAs($user)
            ->get('/parts/9999');

        $response
            ->assertSessionHas('danger')
            ->assertStatus(302);
    }
}
