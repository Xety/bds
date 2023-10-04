<?php
namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Selvah\Http\Livewire\Companies;
use Selvah\Models\Company;
use Selvah\Models\User;
use Tests\TestCase;

class CompaniesTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $user = User::find(1);

        $this->actingAs($user);
        $this->get('/companies')->assertSeeLivewire(Companies::class);
    }

    public function test_create_modal()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Companies::class)
            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true);
    }

    public function test_create_modal_with_edit_model_before()
    {
        $this->actingAs(User::find(1));
        $model = Company::find(1);

        Livewire::test(Companies::class)
            ->call('edit', 1)
            ->assertSet('model.name', $model->name)
            ->assertSet('model.description', $model->description)

            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ->assertSet('name', '')
            ->assertSet('description', '')
            ->assertSet('model', Company::make());
    }

    public function test_edit_modal()
    {
        $this->actingAs(User::find(1));
        $model = Company::find(1);

        Livewire::test(Companies::class)
            ->assertSet('model.name', '')
            ->assertSet('model.description', '')
            ->assertSet('model', Company::make())

            ->call('edit', 1)
            ->assertSet('isCreating', false)
            ->assertSet('showModal', true)
            ->assertSet('model.name', $model->name)
            ->assertSet('model.description', $model->description)
            ->assertSet('model', $model);
    }

    public function test_save_new_model()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Companies::class)
            ->call('create')
            ->set('model.name', 'Test Entreprise')
            ->set('model.description', 'Test de description')

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $last = Company::orderBy('id', 'desc')->first();
            $this->assertSame('Test Entreprise', $last->name);
            $this->assertSame('Test de description', $last->description);
    }

    public function test_save_edit()
    {
        $this->actingAs(User::find(1));
        $model = Company::find(1);

        Livewire::test(Companies::class)
            ->call('edit', 1)
            ->set('model.name', 'Test nouveau nom')
            ->set('model.description', 'Test de description')

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $model = Company::find(1);
            $this->assertSame('Test nouveau nom', $model->name);
            $this->assertSame('Test de description', $model->description);
    }

    public function test_delete_selected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Companies::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertEmitted('alert')
            ->assertSeeHtml('<b>1</b> entreprise(s) ont été supprimée(s) avec succès !')
            ->assertHasNoErrors();
    }

    public function test_with_search_with_result()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['s' => 'afce'])
            ->test(Companies::class)
            ->assertSet('search', 'afce')
            ->assertDontSee('Aucune entreprise trouvé');
    }

    public function test_with_search_no_rows()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['s' => 'xxzz'])
            ->test(Companies::class)
            ->assertSet('search', 'xxzz')
            ->assertSee('Aucune entreprise trouvé');
    }

    public function test_with_sort_field_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Companies::class)
            ->set('sortField', 'name')
            ->assertSet('sortField', 'name');
    }

    public function test_with_sort_field_not_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Companies::class)
            ->set('sortField', 'notallowed')
            ->assertSet('sortField', 'created_at');
    }

    public function test_with_sort_field_not_allowed_on_mount()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['f' => 'notallowed'])
            ->test(Companies::class)
            ->assertSet('sortField', 'created_at');
    }
}
