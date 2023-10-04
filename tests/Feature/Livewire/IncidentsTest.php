<?php
namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Selvah\Http\Livewire\Incidents;
use Selvah\Models\Incident;
use Selvah\Models\Material;
use Selvah\Models\User;
use Tests\TestCase;

class IncidentsTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $user = User::find(1);

        $this->actingAs($user);
        $this->get('/incidents')->assertSeeLivewire(Incidents::class);
    }

    public function test_create_modal()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Incidents::class)
            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ;
    }

    public function test_create_modal_with_edit_model_before()
    {
        $this->actingAs(User::find(1));
        $model = Incident::find(1);

        $incident = Incident::make();
        $incident->is_finished = false;

        Livewire::test(Incidents::class)
            ->call('edit', 1)
            ->assertSet('model.material_id', $model->material_id)
            ->assertSet('model.description', $model->description)
            ->assertSet('model.impact', $model->impact)
            ->assertSet('model.is_finished', (bool)$model->is_finished)
            ->assertSet('started_at', $model->started_at->format('d-m-Y H:i'))
            ->assertSet('finished_at', $model->finished_at->format('d-m-Y H:i'))

            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ->assertSet('model.material_id', '')
            ->assertSet('model.description', '')
            ->assertSet('model.impact', '')
            ->assertSet('model.is_finished', false)
            ->assertSet('started_at', '')
            ->assertSet('finished_at', '')
            ->assertSet('model', $incident);
    }

    public function test_edit_modal()
    {
        $this->actingAs(User::find(1));
        $model = Incident::find(1);

        $incident = Incident::make();
        $incident->is_finished = false;

        Livewire::test(Incidents::class)
            ->assertSet('model.material_id', '')
            ->assertSet('model.description', '')
            ->assertSet('model.impact', '')
            ->assertSet('model.is_finished', false)
            ->assertSet('started_at', '')
            ->assertSet('finished_at', '')
            ->assertSet('model', $incident)

            ->call('edit', 1)
            ->assertSet('isCreating', false)
            ->assertSet('showModal', true)
            ->assertSet('model.material_id', $model->material_id)
            ->assertSet('model.description', $model->description)
            ->assertSet('model.impact', $model->impact)
            ->assertSet('model.is_finished', (bool)$model->is_finished)
            ->assertSet('started_at', $model->started_at->format('d-m-Y H:i'))
            ->assertSet('finished_at', $model->finished_at->format('d-m-Y H:i'));
    }

    public function test_save_new_model()
    {
        $this->actingAs(User::find(1));

        $material = Material::find(1);
        Livewire::test(Incidents::class)
            ->call('create')
            ->set('model.material_id', 1)
            ->set('model.description', 'Test de description')
            ->set('model.impact', 'critique')
            ->set('model.is_finished', true)
            ->set('started_at', '22-07-2023 00:37')
            ->set('finished_at', '25-07-2023 00:50')

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $last = Incident::orderBy('id', 'desc')->first();
            $this->assertSame(1, $last->material_id);
            $this->assertSame('Test de description', $last->description);
            $this->assertSame('critique', $last->impact);
            $this->assertSame(true, (bool)$last->is_finished);
            $this->assertSame('22-07-2023 00:37', $last->started_at->format('d-m-Y H:i'));
            $this->assertSame('25-07-2023 00:50', $last->finished_at->format('d-m-Y H:i'));
            // Test the count_cache is working well.
            $this->assertSame($material->incident_count + 1, $last->material->incident_count);
    }

    public function test_save_edit()
    {
        $this->actingAs(User::find(1));

        $materialId = Incident::find(2)->material_id;
        $oldMaterial = Material::find($materialId);
        Livewire::test(Incidents::class)
            ->call('edit', 2)
            ->set('model.material_id', 1)
            ->set('model.description', 'Test de description')
            ->set('model.impact', 'critique')
            ->set('model.is_finished', true)
            ->set('started_at', '22-07-2023 00:37')
            ->set('finished_at', '25-07-2023 00:50')

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $newMaterial = Material::find($materialId);
            $model = Incident::find(2);
            $this->assertSame(1, $model->material_id);
            $this->assertSame('Test de description', $model->description);
            $this->assertSame('critique', $model->impact);
            $this->assertSame(true, (bool)$model->is_finished);
            $this->assertSame('22-07-2023 00:37', $model->started_at->format('d-m-Y H:i'));
            $this->assertSame('25-07-2023 00:50', $model->finished_at->format('d-m-Y H:i'));
            // Test the count_cache is working well.
            $this->assertSame($oldMaterial->incident_count - 1, $newMaterial->incident_count);
    }

    public function test_delete_selected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Incidents::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertEmitted('alert')
            ->assertSeeHtml('<b>1</b> incident(s) ont été supprimé(s) avec succès !')
            ->assertHasNoErrors();
    }

    public function test_with_search_with_result()
    {
        $this->actingAs(User::find(1));

            Livewire::test(Incidents::class)
            ->set('filters.search', 'ensacheuse')
            ->assertDontSee('Aucun incident trouvé');
    }

    public function test_with_search_no_rows()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Incidents::class)
            ->set('filters.search', 'xxzz')
            ->assertSee('Aucun incident trouvé');
    }

    public function test_with_sort_field_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Incidents::class)
            ->set('sortField', 'material_id')
            ->assertSet('sortField', 'material_id');
    }

    public function test_with_sort_field_not_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Incidents::class)
            ->set('sortField', 'notallowed')
            ->assertSet('sortField', 'created_at');
    }

    public function test_with_sort_field_not_allowed_on_mount()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['f' => 'notallowed'])
            ->test(Incidents::class)
            ->assertSet('sortField', 'created_at');
    }

    public function test_can_export_all_incidents()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Incidents::class)
            ->set('selected', [1, 2])
            ->call('exportSelected')
            ->assertFileDownloaded('incidents.xlsx');
    }
}
