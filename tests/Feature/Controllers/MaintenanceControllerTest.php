<?php
namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Selvah\Models\User;

class MaintenanceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_show_maintenance_can_be_rendered(): void
    {
        $user = User::find(1);

        $response = $this
            ->actingAs($user)
            ->get('/maintenances/1')
            ->assertSee('profils de vis');

        $response->assertOk();
    }

    public function test_show_maintenance_not_found(): void
    {
        $user = User::find(1);

        $response = $this
            ->actingAs($user)
            ->get('/maintenances/9999');

        $response
            ->assertSessionHas('danger')
            ->assertStatus(302);
    }
}
