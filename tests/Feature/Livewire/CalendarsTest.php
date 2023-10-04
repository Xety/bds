<?php
namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Selvah\Http\Livewire\Calendars;
use Selvah\Models\User;
use Tests\TestCase;

class CalendarsTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $user = User::find(1);

        $this->actingAs($user);
        $this->get('/calendars')->assertSeeLivewire(Calendars::class);
    }

    public function test_create_modal()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Calendars::class)
            ->call('eventAdd', [
                "start" => "2023-07-04T00:00:00.000Z",
                "end" => "2023-07-05T00:00:00.000Z",
                "startStr" => "2023-07-04",
                "endStr" => "2023-07-05",
                "allDay" => true
            ])
            ->assertSet('showModal', true);
    }
}
