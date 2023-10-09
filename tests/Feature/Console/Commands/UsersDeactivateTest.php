<?php
namespace Console\Commands;

use BDS\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UsersDeactivateTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_cleaning_alert_command()
    {
        $this->artisan('users:deactivate')
            ->assertSuccessful();
    }

    public function test_cleaning_alert_command_with_event()
    {
        Event::fake();

        $material = Material::find(1);
        $material->cleaning_alert = true;
        $material->cleaning_alert_frequency_repeatedly = 2;
        $material->cleaning_alert_frequency_type = 'daily';
        $material->last_cleaning_at = null;
        $material->last_cleaning_alert_send_at = null;
        $material->save();

        $this->artisan('cleaning:alert')
            ->assertSuccessful();

        Event::assertDispatched(AlertEvent::class);
    }
}
