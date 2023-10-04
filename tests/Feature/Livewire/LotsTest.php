<?php
namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Selvah\Http\Livewire\Lots;
use Selvah\Models\Lot;
use Selvah\Models\User;
use Tests\TestCase;

class LotsTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $user = User::find(1);

        $this->actingAs($user);
        $this->get('/lots')->assertSeeLivewire(Lots::class);
    }

    public function test_create_modal()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Lots::class)
            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true);
    }

    public function test_create_modal_with_edit_model_before()
    {
        $this->actingAs(User::find(1));
        $model = Lot::find(1);

        Livewire::test(Lots::class)
            ->call('edit', 1)
            ->assertSet('model.number', $model->number)
            ->assertSet('model.description', $model->description)
            ->assertSet('model.crushed_seeds', $model->crushed_seeds)
            ->assertSet('model.harvest', $model->harvest)
            ->assertSet('crushedSeedsStartedAt', $model->crushed_seeds_started_at->format('d-m-Y H:i'))
            ->assertSet('crushedSeedsFinishedAt', $model->crushed_seeds_finished_at->format('d-m-Y H:i'))
            ->assertSet('model.crude_oil_production', $model->crude_oil_production)
            ->assertSet('model.soy_hull', $model->soy_hull)
            ->assertSet('extrusionStartedAt', $model->extrusion_started_at->format('d-m-Y H:i'))
            ->assertSet('extrusionFinishedAt', $model->extrusion_finished_at->format('d-m-Y H:i'))
            ->assertSet('model.extruded_flour', $model->extruded_flour)
            ->assertSet('model.bagged_tvp', $model->bagged_tvp)
            ->assertSet('model.compliant_bagged_tvp', $model->compliant_bagged_tvp)

            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ->assertSet('model.number', '')
            ->assertSet('model.description', '')
            ->assertSet('model.crushed_seeds', '')
            ->assertSet('model.harvest', '')
            ->assertSet('crushedSeedsStartedAt', '')
            ->assertSet('crushedSeedsFinishedAt', '')
            ->assertSet('model.crude_oil_production', '')
            ->assertSet('model.soy_hull', '')
            ->assertSet('extrusionStartedAt', '')
            ->assertSet('extrusionFinishedAt', '')
            ->assertSet('model.extruded_flour', '')
            ->assertSet('model.bagged_tvp', '')
            ->assertSet('model.compliant_bagged_tvp', '')
            ->assertSet('model', Lot::make());
    }

    public function test_edit_modal()
    {
        $this->actingAs(User::find(1));
        $model = Lot::find(1);

        Livewire::test(Lots::class)
            ->assertSet('model.number', '')
            ->assertSet('model.description', '')
            ->assertSet('model.crushed_seeds', '')
            ->assertSet('model.harvest', '')
            ->assertSet('crushedSeedsStartedAt', '')
            ->assertSet('crushedSeedsFinishedAt', '')
            ->assertSet('model.crude_oil_production', '')
            ->assertSet('model.soy_hull', '')
            ->assertSet('extrusionStartedAt', '')
            ->assertSet('extrusionFinishedAt', '')
            ->assertSet('model.extruded_flour', '')
            ->assertSet('model.bagged_tvp', '')
            ->assertSet('model.compliant_bagged_tvp', '')
            ->assertSet('model', Lot::make())

            ->call('edit', 1)
            ->assertSet('isCreating', false)
            ->assertSet('showModal', true)
            ->assertSet('model.number', $model->number)
            ->assertSet('model.description', $model->description)
            ->assertSet('model.crushed_seeds', $model->crushed_seeds)
            ->assertSet('model.harvest', $model->harvest)
            ->assertSet('crushedSeedsStartedAt', $model->crushed_seeds_started_at->format('d-m-Y H:i'))
            ->assertSet('crushedSeedsFinishedAt', $model->crushed_seeds_finished_at->format('d-m-Y H:i'))
            ->assertSet('model.crude_oil_production', $model->crude_oil_production)
            ->assertSet('model.soy_hull', $model->soy_hull)
            ->assertSet('extrusionStartedAt', $model->extrusion_started_at->format('d-m-Y H:i'))
            ->assertSet('extrusionFinishedAt', $model->extrusion_finished_at->format('d-m-Y H:i'))
            ->assertSet('model.extruded_flour', $model->extruded_flour)
            ->assertSet('model.bagged_tvp', $model->bagged_tvp)
            ->assertSet('model.compliant_bagged_tvp', $model->compliant_bagged_tvp)
            ->assertSet('model', $model);
    }

    public function test_save_new_model()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Lots::class)
            ->call('create')
            ->set('model.number', '519-001')
            ->set('model.description', 'Test de description')
            ->set('model.crushed_seeds', 86595)
            ->set('model.harvest', 2022)
            ->set('crushedSeedsStartedAt', '22-07-2023 00:37')
            ->set('crushedSeedsFinishedAt', '24-07-2023 00:37')
            ->set('model.crude_oil_production', 9865)
            ->set('model.soy_hull', 10562)
            ->set('extrusionStartedAt', '25-07-2023 00:37')
            ->set('extrusionFinishedAt', '26-07-2023 00:37')
            ->set('model.extruded_flour', 70895)
            ->set('model.bagged_tvp', 56264.5)
            ->set('model.compliant_bagged_tvp', 55985.5)

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $last = Lot::orderBy('id', 'desc')->first();
            $this->assertSame('519-001', $last->number);
            $this->assertSame('Test de description', $last->description);
            $this->assertSame(86595, $last->crushed_seeds);
            $this->assertSame(2022, $last->harvest);
            $this->assertSame('22-07-2023 00:37', $last->crushed_seeds_started_at->format('d-m-Y H:i'));
            $this->assertSame('24-07-2023 00:37', $last->crushed_seeds_finished_at->format('d-m-Y H:i'));
            $this->assertSame(9865, $last->crude_oil_production);
            $this->assertSame(10562, $last->soy_hull);
            $this->assertSame('25-07-2023 00:37', $last->extrusion_started_at->format('d-m-Y H:i'));
            $this->assertSame('26-07-2023 00:37', $last->extrusion_finished_at->format('d-m-Y H:i'));
            $this->assertSame(70895, $last->extruded_flour);
            $this->assertSame(56264.5, $last->bagged_tvp);
            $this->assertSame(55985.5, $last->compliant_bagged_tvp);
    }

    public function test_save_edit()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Lots::class)
            ->call('edit', 1)
            ->set('model.number', '519-001')
            ->set('model.description', 'Test de description')
            ->set('model.crushed_seeds', 86595)
            ->set('model.harvest', 2022)
            ->set('crushedSeedsStartedAt', '22-07-2023 00:37')
            ->set('crushedSeedsFinishedAt', '24-07-2023 00:37')
            ->set('model.crude_oil_production', 9865)
            ->set('model.soy_hull', 10562)
            ->set('extrusionStartedAt', '25-07-2023 00:37')
            ->set('extrusionFinishedAt', '26-07-2023 00:37')
            ->set('model.extruded_flour', 70895)
            ->set('model.bagged_tvp', 56264.5)
            ->set('model.compliant_bagged_tvp', 55985.5)

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $model = Lot::find(1);
            $this->assertSame('519-001', $model->number);
            $this->assertSame('Test de description', $model->description);
            $this->assertSame(86595, $model->crushed_seeds);
            $this->assertSame(2022, $model->harvest);
            $this->assertSame('22-07-2023 00:37', $model->crushed_seeds_started_at->format('d-m-Y H:i'));
            $this->assertSame('24-07-2023 00:37', $model->crushed_seeds_finished_at->format('d-m-Y H:i'));
            $this->assertSame(9865, $model->crude_oil_production);
            $this->assertSame(10562, $model->soy_hull);
            $this->assertSame('25-07-2023 00:37', $model->extrusion_started_at->format('d-m-Y H:i'));
            $this->assertSame('26-07-2023 00:37', $model->extrusion_finished_at->format('d-m-Y H:i'));
            $this->assertSame(70895, $model->extruded_flour);
            $this->assertSame(56264.5, $model->bagged_tvp);
            $this->assertSame(55985.5, $model->compliant_bagged_tvp);
    }

    public function test_delete_selected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Lots::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertEmitted('alert')
            ->assertSeeHtml('<b>1</b> lot(s) ont été supprimé(s) avec succès !')
            ->assertHasNoErrors();
    }

    public function test_with_search_with_result()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['s' => '519-023'])
            ->test(Lots::class)
            ->assertSet('search', '519-023')
            ->assertDontSee('Aucun lot trouvé');
    }

    public function test_with_search_no_rows()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['s' => 'xx'])
            ->test(Lots::class)
            ->assertSet('search', 'xx')
            ->assertSee('Aucun lot trouvé');
    }

    public function test_with_sort_field_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Lots::class)
            ->set('sortField', 'number')
            ->assertSet('sortField', 'number');
    }

    public function test_with_sort_field_not_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Lots::class)
            ->set('sortField', 'notallowed')
            ->assertSet('sortField', 'created_at');
    }

    public function test_with_sort_field_not_allowed_on_mount()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['f' => 'notallowed'])
            ->test(Lots::class)
            ->assertSet('sortField', 'created_at');
    }
}
