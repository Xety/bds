<?php
namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Selvah\Http\Livewire\Zones;
use Selvah\Models\User;
use Selvah\Models\Zone;
use Tests\TestCase;

class ZonesTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));

        $this->get('/zones')->assertSeeLivewire(Zones::class);
    }

    public function test_create_modal()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Zones::class)
            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true);
    }

    public function test_create_modal_with_edit_model_before()
    {
        $this->actingAs(User::find(1));
        $model = Zone::find(1);

        Livewire::test(Zones::class)
            ->call('edit', 1)
            ->assertSet('model.name', $model->name)

            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ->assertSet('name', '')
            ->assertSet('model', Zone::make());
    }

    public function test_edit_modal()
    {
        $this->actingAs(User::find(1));
        $model = Zone::find(1);

        Livewire::test(Zones::class)
            ->assertSet('model.name', '')
            ->assertSet('model', Zone::make())

            ->call('edit', 1)
            ->assertSet('isCreating', false)
            ->assertSet('showModal', true)
            ->assertSet('model.name', $model->name)
            ->assertSet('model', $model);
    }

    public function test_save_new_model()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Zones::class)
            ->call('create')
            ->set('model.name', 'Test Zone')

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $last = Zone::orderBy('id', 'desc')->first();
            $this->assertSame('Test Zone', $last->name);
    }

    public function test_delete_selected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Zones::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertEmitted('alert')
            ->assertSeeHtml('<b>1</b> zone(s) ont été supprimée(s) avec succès !')
            ->assertHasNoErrors();
    }

    public function test_with_search_with_result()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['s' => 'broyage'])
            ->test(Zones::class)
            ->assertSet('search', 'broyage')
            ->assertDontSee('Aucune zone trouvée');
    }

    public function test_with_search_no_rows()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['s' => 'xx'])
            ->test(Zones::class)
            ->assertSet('search', 'xx')
            ->assertSee('Aucune zone trouvée');
    }

    public function test_with_sort_field_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Zones::class)
            ->set('sortField', 'name')
            ->assertSet('sortField', 'name');
    }

    public function test_with_sort_field_not_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Zones::class)
            ->set('sortField', 'notallowed')
            ->assertSet('sortField', 'created_at');
    }

    public function test_with_sort_field_not_allowed_on_mount()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['f' => 'notallowed'])
            ->test(Zones::class)
            ->assertSet('sortField', 'created_at');
    }
}
