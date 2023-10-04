<?php
namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Selvah\Http\Livewire\Maintenances;
use Selvah\Models\Maintenance;
use Selvah\Models\Material;
use Selvah\Models\User;
use Tests\TestCase;

class MaintenancesTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $user = User::find(1);

        $this->actingAs($user);
        $this->get('/maintenances')->assertSeeLivewire(Maintenances::class);
    }

    public function test_create_modal()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Maintenances::class)
            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ;
    }

    public function test_create_modal_with_edit_model_before()
    {
        $this->actingAs(User::find(1));
        $model = Maintenance::find(1);

        $maintenance = Maintenance::make();
        $maintenance->type = 'curative';
        $maintenance->realization = 'external';

        Livewire::test(Maintenances::class)
            ->call('edit', 1)
            ->assertSet('model.gmao_id', $model->gmao_id)
            ->assertSet('model.material_id', $model->material_id)
            ->assertSet('model.description', $model->description)
            ->assertSet('model.reason', $model->reason)
            ->assertSet('model.type', $model->type)
            ->assertSet('model.realization', $model->realization)
            ->assertSet('operatorsSelected', $model->operators()->pluck('id')->toArray())
            ->assertSet('companiesSelected', $model->companies()->pluck('id')->toArray())
            ->assertSet('started_at', $model->started_at->format('d-m-Y H:i'))
            ->assertSet('finished_at', $model->finished_at->format('d-m-Y H:i'))

            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ->assertSet('model.gmao_id', '')
            ->assertSet('model.material_id', '')
            ->assertSet('model.description', '')
            ->assertSet('model.reason', '')
            ->assertSet('model.type', 'curative')
            ->assertSet('model.realization', 'external')
            ->assertSet('operatorsSelected', [])
            ->assertSet('companiesSelected', [])
            ->assertSet('started_at', '')
            ->assertSet('finished_at', '')
            ->assertSet('model', $maintenance);
    }

    public function test_edit_modal()
    {
        $this->actingAs(User::find(1));
        $model = Maintenance::find(1);

        $maintenance = Maintenance::make();
        $maintenance->type = 'curative';
        $maintenance->realization = 'external';

        Livewire::test(Maintenances::class)
            ->assertSet('model.gmao_id', '')
            ->assertSet('model.material_id', '')
            ->assertSet('model.description', '')
            ->assertSet('model.reason', '')
            ->assertSet('model.type', 'curative')
            ->assertSet('model.realization', 'external')
            ->assertSet('operatorsSelected', [])
            ->assertSet('companiesSelected', [])
            ->assertSet('started_at', '')
            ->assertSet('finished_at', '')
            ->assertSet('model', $maintenance)

            ->call('edit', 1)
            ->assertSet('isCreating', false)
            ->assertSet('showModal', true)
            ->assertSet('model.gmao_id', $model->gmao_id)
            ->assertSet('model.material_id', $model->material_id)
            ->assertSet('model.description', $model->description)
            ->assertSet('model.reason', $model->reason)
            ->assertSet('model.type', $model->type)
            ->assertSet('model.realization', $model->realization)
            ->assertSet('operatorsSelected', $model->operators()->pluck('id')->toArray())
            ->assertSet('companiesSelected', $model->companies()->pluck('id')->toArray())
            ->assertSet('started_at', $model->started_at->format('d-m-Y H:i'))
            ->assertSet('finished_at', $model->finished_at->format('d-m-Y H:i'));
    }

    public function test_save_new_model()
    {
        $this->actingAs(User::find(1));

        $material = Material::find(1);
        Livewire::test(Maintenances::class)
            ->call('create')
            ->set('model.gmao_id', '123456')
            ->set('model.material_id', 1)
            ->set('model.description', 'Test de description')
            ->set('model.reason', 'Test de raison')
            ->set('model.type', 'curative')
            ->set('model.realization', 'both')
            ->set('operatorsSelected', [1, 2])
            ->set('companiesSelected', [3, 4])
            ->set('started_at', '22-07-2023 00:37')
            ->set('finished_at', '25-07-2023 00:50')

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $last = Maintenance::orderBy('id', 'desc')->first();
            $this->assertSame('123456', $last->gmao_id);
            $this->assertSame(1, $last->material_id);
            $this->assertSame('Test de description', $last->description);
            $this->assertSame('Test de raison', $last->reason);
            $this->assertSame('curative', $last->type);
            $this->assertSame('both', $last->realization);
            $this->assertSame([1, 2], $last->operators()->pluck('id')->toArray());
            $this->assertSame([3, 4], $last->companies()->pluck('id')->toArray());
            $this->assertSame('22-07-2023 00:37', $last->started_at->format('d-m-Y H:i'));
            $this->assertSame('25-07-2023 00:50', $last->finished_at->format('d-m-Y H:i'));
            // Test the count_cache is working well.
            $this->assertSame($material->maintenance_count + 1, $last->material->maintenance_count);
    }

    public function test_save_edit()
    {
        $this->actingAs(User::find(1));

        $materialId = Maintenance::find(2)->material_id;
        $oldMaterial = Material::find($materialId);
        Livewire::test(Maintenances::class)
            ->call('edit', 2)
            ->set('model.gmao_id', '123456')
            ->set('model.material_id', 1)
            ->set('model.description', 'Test de description')
            ->set('model.reason', 'Test de raison')
            ->set('model.type', 'preventive')
            ->set('model.realization', 'both')
            ->set('operatorsSelected', [1, 2])
            ->set('companiesSelected', [3, 4])
            ->set('started_at', '22-07-2023 00:37')
            ->set('finished_at', '25-07-2023 00:50')

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $newMaterial = Material::find($materialId);
            $model = Maintenance::find(2);
            $this->assertSame('123456', $model->gmao_id);
            $this->assertSame(1, $model->material_id);
            $this->assertSame('Test de description', $model->description);
            $this->assertSame('Test de raison', $model->reason);
            $this->assertSame('preventive', $model->type);
            $this->assertSame('both', $model->realization);
            $this->assertSame([1, 2], $model->operators()->pluck('id')->toArray());
            $this->assertSame([3, 4], $model->companies()->pluck('id')->toArray());
            $this->assertSame('22-07-2023 00:37', $model->started_at->format('d-m-Y H:i'));
            $this->assertSame('25-07-2023 00:50', $model->finished_at->format('d-m-Y H:i'));
            // Test the count_cache is working well.
            $this->assertSame($oldMaterial->maintenance_count - 1, $newMaterial->maintenance_count);
    }

    public function test_delete_selected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Maintenances::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertEmitted('alert')
            ->assertSeeHtml('<b>1</b> maintenance(s) ont été supprimée(s) avec succès !')
            ->assertHasNoErrors();
    }

    public function test_with_search_with_result()
    {
        $this->actingAs(User::find(1));

            Livewire::test(Maintenances::class)
            ->set('filters.search', 'ensacheuse')
            ->assertDontSee('Aucune maintenance trouvée');
    }

    public function test_with_search_no_rows()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Maintenances::class)
            ->set('filters.search', 'xxzz')
            ->assertSee('Aucune maintenance trouvée');
    }

    public function test_with_sort_field_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Maintenances::class)
            ->set('sortField', 'gmao_id')
            ->assertSet('sortField', 'gmao_id');
    }

    public function test_with_sort_field_not_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Maintenances::class)
            ->set('sortField', 'notallowed')
            ->assertSet('sortField', 'created_at');
    }

    public function test_with_sort_field_not_allowed_on_mount()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['f' => 'notallowed'])
            ->test(Maintenances::class)
            ->assertSet('sortField', 'created_at');
    }

    public function test_can_export_all_maintenances()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Maintenances::class)
            ->set('selected', [1, 2])
            ->call('exportSelected')
            ->assertFileDownloaded('maintenances.xlsx');
    }

    public function test_qrcode_open_create_modal()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['qrcode' => 'true', 'qrcodeid' => '1'])
            ->test(Maintenances::class)
            ->assertSet('model.material_id', 1)
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true);
    }
}
