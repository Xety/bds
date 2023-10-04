<?php
namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Selvah\Http\Livewire\Cleanings;
use Selvah\Models\Cleaning;
use Selvah\Models\User;
use Tests\TestCase;

class CleaningsTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));

        $this->get('/cleanings')->assertSeeLivewire(Cleanings::class);
    }

    public function test_create_modal()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Cleanings::class)
            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true);
    }

    public function test_create_modal_with_edit_model_before()
    {
        $this->actingAs(User::find(1));
        $model = Cleaning::find(1);

        $cleaning = Cleaning::make();
        $cleaning->type = 'daily';

        Livewire::test(Cleanings::class)
            ->call('edit', 1)
            ->assertSet('model.material_id', $model->material_id)
            ->assertSet('model.description', $model->description)
            ->assertSet('model.type', $model->type)
            ->assertSet('model.ph_test_water', $model->ph_test_water)
            ->assertSet('model.ph_test_water_after_cleaning', $model->ph_test_water_after_cleaning)

            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ->assertSet('model.material_id', '')
            ->assertSet('model.description', '')
            ->assertSet('model.type', 'daily')
            ->assertSet('model.ph_test_water', '')
            ->assertSet('model.ph_test_water_after_cleaning', '')
            ->assertSet('model', $cleaning);
    }

    public function test_edit_modal()
    {
        $this->actingAs(User::find(1));
        $model = Cleaning::with('material')->find(1);

        $cleaning = Cleaning::make();
        $cleaning->type = 'daily';

        Livewire::test(Cleanings::class)
            ->assertSet('model.material_id', '')
            ->assertSet('model.description', '')
            ->assertSet('model.type', 'daily')
            ->assertSet('model.ph_test_water', '')
            ->assertSet('model.ph_test_water_after_cleaning', '')
            ->assertSet('model', $cleaning)

            ->call('edit', 1)
            ->assertSet('model.material_id', $model->material_id)
            ->assertSet('model.description', $model->description)
            ->assertSet('model.type', $model->type)
            ->assertSet('model.ph_test_water', $model->ph_test_water)
            ->assertSet('model.ph_test_water_after_cleaning', $model->ph_test_water_after_cleaning)
            ->assertSet('model', $model);
    }

    public function test_save_new_model_without_ph()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Cleanings::class)
            ->call('create')
            ->set('model.material_id', 1)
            ->set('model.description', 'test description')
            ->set('model.type', 'weekly')
            ->set('model.ph_test_water', 7)
            ->set('model.ph_test_water_after_cleaning', 7)

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $last = Cleaning::orderBy('id', 'desc')->first();
            $this->assertSame(1, $last->material_id);
            $this->assertSame('test description', $last->description);
            $this->assertSame('weekly', $last->type);
            $this->assertSame(null, $last->ph_test_water);
            $this->assertSame(null, $last->ph_test_water_after_cleaning);
    }

    public function test_save_new_model_with_ph()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Cleanings::class)
            ->call('create')
            ->set('model.material_id', 83) // Filière
            ->set('model.description', 'test description')
            ->set('model.type', 'weekly')
            ->set('model.ph_test_water', 7)
            ->set('model.ph_test_water_after_cleaning', 7)

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $last = Cleaning::orderBy('id', 'desc')->first();
            $this->assertSame(83, $last->material_id);
            $this->assertSame('test description', $last->description);
            $this->assertSame('weekly', $last->type);
            $this->assertSame(7.0, $last->ph_test_water);
            $this->assertSame(7.0, $last->ph_test_water_after_cleaning);
    }

    public function test_delete_selected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Cleanings::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertEmitted('alert')
            ->assertSeeHtml('<b>1</b> nettoyage(s) ont été supprimé(s) avec succès !')
            ->assertHasNoErrors();
    }

    public function test_with_search_with_result()
    {
            Livewire::test(Cleanings::class)
            ->set('filters.search', 'filière')
            ->assertDontSee('Aucun nettoyage trouvé');
    }

    public function test_with_search_no_rows()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Cleanings::class)
            ->set('filters.search', 'xxzz')
            ->assertSee('Aucun nettoyage trouvé');
    }

    public function test_with_sort_field_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Cleanings::class)
            ->set('sortField', 'ph_test_water')
            ->assertSet('sortField', 'ph_test_water');
    }

    public function test_with_sort_field_not_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Cleanings::class)
            ->set('sortField', 'notallowed')
            ->assertSet('sortField', 'created_at');
    }

    public function test_with_sort_field_not_allowed_on_mount()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['f' => 'notallowed'])
            ->test(Cleanings::class)
            ->assertSet('sortField', 'created_at');
    }

    public function test_can_export_all_cleanings()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Cleanings::class)
            ->set('selected', [1, 2])
            ->call('exportSelected')
            ->assertFileDownloaded('nettoyages.xlsx');
    }

    public function test_can_export_last_week_cleanings()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Cleanings::class)
            ->call('exportLastWeek')
            ->assertFileDownloaded('nettoyages.xlsx');
    }

    public function test_can_generate_cleaning_plan()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Cleanings::class)
            ->call('generateCleaningPlan')
            ->assertFileDownloaded('plan-de-nettoyage.xlsx');
    }
}
