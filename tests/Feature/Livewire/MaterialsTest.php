<?php
namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Selvah\Http\Livewire\Materials;
use Selvah\Models\Material;
use Selvah\Models\User;
use Selvah\Models\Zone;
use Tests\TestCase;

class MaterialsTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $user = User::find(1);

        $this->actingAs($user);
        $this->get('/materials')->assertSeeLivewire(Materials::class);
    }

    public function test_create_modal()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Materials::class)
            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ;
    }

    public function test_create_modal_with_edit_model_before()
    {
        $this->actingAs(User::find(1));
        $model = Material::find(1);

        Livewire::test(Materials::class)
            ->call('edit', 1)
            ->assertSet('model.name', $model->name)
            ->assertSet('model.zone_id', $model->zone_id)
            ->assertSet('model.description', $model->description)

            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ->assertSet('model.name', '')
            ->assertSet('model.zone_id', '')
            ->assertSet('model.description', '');
    }

    public function test_edit_modal()
    {
        $this->actingAs(User::find(1));
        $model = Material::find(1);

        Livewire::test(Materials::class)
            ->assertSet('model.name', '')
            ->assertSet('model.zone_id', '')
            ->assertSet('model.description', '')

            ->call('edit', 1)
            ->assertSet('isCreating', false)
            ->assertSet('showModal', true)
            ->assertSet('model.name', $model->name)
            ->assertSet('model.zone_id', $model->zone_id)
            ->assertSet('model.cleaning_test_ph_enabled', $model->cleaning_test_ph_enabled)
            ->assertSet('model.cleaning_alert', $model->cleaning_alert)
            ->assertSet('model.cleaning_alert_email', $model->cleaning_alert_email)
            ->assertSet('model.cleaning_alert_frequency_repeatedly', $model->cleaning_alert_frequency_repeatedly)
            ->assertSet('model.cleaning_alert_frequency_type', $model->cleaning_alert_frequency_type);
    }

    public function test_save_new_model_without_cleaning()
    {
        $this->actingAs(User::find(1));

        $zone = Zone::find(1);
        Livewire::test(Materials::class)
            ->call('create')
            ->set('model.name', 'Test matériel')
            ->set('model.zone_id', 1)
            ->set('model.description', 'Test de description')

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $last = Material::orderBy('id', 'desc')->first();
            $this->assertSame('Test matériel', $last->name);
            $this->assertSame(1, $last->zone_id);
            $this->assertSame('Test de description', $last->description);
            // Test the count_cache is working well.
            $this->assertSame($last->zone->material_count, $zone->material_count + 1);
    }

    public function test_save_new_model_with_cleaning()
    {
        $this->actingAs(User::find(1));

        $zone = Zone::find(1);
        Livewire::test(Materials::class)
            ->call('create')
            ->set('model.name', 'Test matériel')
            ->set('model.zone_id', 1)
            ->set('model.description', 'Test de description')
            ->set('model.cleaning_test_ph_enabled', 1)
            ->set('model.cleaning_alert', 1)
            ->set('model.cleaning_alert_email', 1)
            ->set('model.cleaning_alert_frequency_repeatedly', 3)
            ->set('model.cleaning_alert_frequency_type', 'daily')

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

        $last = Material::orderBy('id', 'desc')->first();
        $this->assertSame('Test matériel', $last->name);
        $this->assertSame(1, $last->zone_id);
        $this->assertSame('Test de description', $last->description);
        $this->assertSame(true, $last->cleaning_test_ph_enabled);
        $this->assertSame(true, $last->cleaning_alert);
        $this->assertSame(true, $last->cleaning_alert_email);
        $this->assertSame(3, $last->cleaning_alert_frequency_repeatedly);
        $this->assertSame('daily', $last->cleaning_alert_frequency_type);
        // Test the count_cache is working well.
        $this->assertSame($last->zone->material_count, $zone->material_count + 1);
    }

    public function test_save_edit()
    {
        $this->actingAs(User::find(1));

        $oldZone = Zone::find(1);
        Livewire::test(Materials::class)
            ->call('edit', 1)
            ->set('model.name', 'Test matériel')
            ->set('model.zone_id', 2)
            ->set('model.description', 'Test de description')

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $newZone = Zone::find(1);
            $model = Material::find(1);
            $this->assertSame('Test matériel', $model->name);
            $this->assertSame(2, $model->zone_id);
            $this->assertSame('Test de description', $model->description);
            // Test the count_cache is working well.
            $this->assertSame($newZone->material_count, $oldZone->material_count - 1);
    }

    public function test_delete_selected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Materials::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertEmitted('alert')
            ->assertSeeHtml('<b>1</b> matériel(s) ont été supprimé(s) avec succès !')
            ->assertHasNoErrors();
    }

    public function test_with_search_with_result()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Materials::class)
            ->set('filters.search', 'bmp1')
            ->assertDontSee('Aucun matériel trouvé');
    }

    public function test_with_search_no_rows()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Materials::class)
            ->set('filters.search', 'xxzz')
            ->assertSee('Aucun matériel trouvé');
    }

    public function test_with_sort_field_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Materials::class)
            ->set('sortField', 'name')
            ->assertSet('sortField', 'name');
    }

    public function test_with_sort_field_not_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Materials::class)
            ->set('sortField', 'notallowed')
            ->assertSet('sortField', 'created_at');
    }

    public function test_with_sort_field_not_allowed_on_mount()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['f' => 'notallowed'])
            ->test(Materials::class)
            ->assertSet('sortField', 'created_at');
    }

    public function test_can_export_all_materials()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Materials::class)
            ->set('selected', [1, 2])
            ->call('exportSelected')
            ->assertFileDownloaded('materiels.xlsx');
    }

    public function test_edit_with_qrcode_and_qrcodeid()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['qrcode' => 'true', 'qrcodeid' => '1'])
            ->test(Materials::class)
            ->assertSet('showQrCodeModal', true);
    }

    public function test_edit_with_edit_and_editid()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['edit' => 'true', 'editid' => '1'])
            ->test(Materials::class)
            ->assertSet('isCreating', false)
            ->assertSet('showModal', true);
    }
}
