<?php
namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Selvah\Http\Livewire\PartExits;
use Selvah\Models\Part;
use Selvah\Models\PartExit;
use Selvah\Models\User;
use Tests\TestCase;

class PartExitsTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $user = User::find(1);

        $this->actingAs($user);
        $response = $this->get('/part-exits')->assertSeeLivewire(PartExits::class);
    }

    public function test_create_modal()
    {
        $this->actingAs(User::find(1));

        Livewire::test(PartExits::class)
            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ;
    }

    public function test_create_modal_with_edit_model_before()
    {
        $this->actingAs(User::find(1));
        $model = PartExit::find(1);

        Livewire::test(PartExits::class)
            ->call('edit', 1)
            ->assertSet('model.part_id', $model->part_id)
            ->assertSet('model.maintenance_id', $model->maintenance_id)
            ->assertSet('model.number', $model->number)
            ->assertSet('model.description', $model->description)

            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ->assertSet('model.part_id', '')
            ->assertSet('model.maintenance_id', '')
            ->assertSet('model.number', '')
            ->assertSet('model.description', '')
            ->assertSet('model', PartExit::make());
    }

    public function test_edit_modal()
    {
        $this->actingAs(User::find(1));
        $model = PartExit::find(1);

        Livewire::test(PartExits::class)
            ->assertSet('model.part_id', '')
            ->assertSet('model.maintenance_id', '')
            ->assertSet('model.number', '')
            ->assertSet('model.description', '')
            ->assertSet('model', PartExit::make())

            ->call('edit', 1)
            ->assertSet('isCreating', false)
            ->assertSet('showModal', true)
            ->assertSet('model.part_id', $model->part_id)
            ->assertSet('model.maintenance_id', $model->maintenance_id)
            ->assertSet('model.number', $model->number)
            ->assertSet('model.description', $model->description)
            ->assertSet('model', $model);
    }

    public function test_save_new_model()
    {
        $this->actingAs(User::find(1));

        $part = Part::find(1);
        Livewire::test(PartExits::class)
            ->call('create')
            ->set('model.part_id', 1)
            ->set('model.maintenance_id', "")
            ->set('model.number', 2)
            ->set('model.description', 'Test de description')

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $last = PartExit::orderBy('id', 'desc')->first();
            $this->assertSame(1, $last->part_id);
            $this->assertSame(null, $last->maintenance_id);
            $this->assertSame(2, $last->number);
            $this->assertSame('Test de description', $last->description);
            // Test the count_cache is working well.
            $this->assertSame($last->part->stock_total, ($part->stock_total - $last->number));
    }

    public function test_save_edit()
    {
        $this->actingAs(User::find(1));
        $model = PartExit::find(1);

        Livewire::test(PartExits::class)
            ->call('edit', 1)
            ->set('model.maintenance_id', 1)
            ->set('model.description', 'Test de description')

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $model = PartExit::find(1);
            $this->assertSame(1, $model->maintenance_id);
            $this->assertSame('Test de description', $model->description);
    }

    public function test_delete_selected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(PartExits::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertEmitted('alert')
            ->assertSeeHtml('<b>1</b> sortie(s) ont été supprimée(s) avec succès !')
            ->assertHasNoErrors();
    }

    public function test_with_search_with_result()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['s' => 'ventouse'])
            ->test(PartExits::class)
            ->assertSet('search', 'ventouse')
            ->assertDontSee('Aucune sortie trouvée');
    }

    public function test_with_search_no_rows()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['s' => 'xxzz'])
            ->test(PartExits::class)
            ->assertSet('search', 'xxzz')
            ->assertSee('Aucune sortie trouvée');
    }

    public function test_with_sort_field_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(PartExits::class)
            ->set('sortField', 'number')
            ->assertSet('sortField', 'number');
    }

    public function test_with_sort_field_not_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(PartExits::class)
            ->set('sortField', 'notallowed')
            ->assertSet('sortField', 'created_at');
    }

    public function test_with_sort_field_not_allowed_on_mount()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['f' => 'notallowed'])
            ->test(PartExits::class)
            ->assertSet('sortField', 'created_at');
    }

    public function test_qrcode_open_create_modal()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['qrcode' => 'true', 'qrcodeid' => '1'])
            ->test(PartExits::class)
            ->assertSet('model.part_id', 1)
            ->assertSet('model.maintenance_id', '')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true);
    }
}
