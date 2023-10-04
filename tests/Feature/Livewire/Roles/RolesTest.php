<?php
namespace Tests\Feature\Livewire\Roles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Selvah\Http\Livewire\Roles\Roles;
use Selvah\Models\User;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolesTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $user = User::find(1);

        $this->actingAs($user);
        $this->get('/roles/roles')->assertSeeLivewire(Roles::class);
    }

    public function test_create_modal()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Roles::class)
            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true);
    }

    public function test_create_modal_with_edit_model_before()
    {
        $this->actingAs(User::find(1));
        $model = Role::find(1);

        Livewire::test(Roles::class)
            ->call('edit', 1)
            ->assertSet('model.name', $model->name)
            ->assertSet('model.description', $model->description)
            ->assertSet('model.css', $model->css)
            ->assertSet('permissionsSelected', $model->permissions->pluck('id')->toArray())

            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ->assertSet('model.name', '')
            ->assertSet('model.description', '')
            ->assertSet('model.css', '')
            ->assertSet('permissionsSelected', [])
            ->assertSet('model', Role::make());
    }

    public function test_edit_modal()
    {
        $this->actingAs(User::find(1));
        $model = Role::find(1);

        Livewire::test(Roles::class)
            ->assertSet('model.name', '')
            ->assertSet('model.description', '')
            ->assertSet('model.css', '')
            ->assertSet('permissionsSelected', [])
            ->assertSet('model', Role::make())

            ->call('edit', 1)
            ->assertSet('isCreating', false)
            ->assertSet('showModal', true)
            ->assertSet('model.name', $model->name)
            ->assertSet('model.description', $model->description)
            ->assertSet('model.css', $model->css)
            ->assertSet('permissionsSelected', $model->permissions->pluck('id')->toArray())
            ->assertSet('model', $model);
    }

    public function test_save_new_model()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Roles::class)
            ->call('create')
            ->set('model.name', 'Test Role')
            ->set('model.description', 'Test de description')
            ->set('model.css', 'color: #ffffff;')
            ->set('permissionsSelected', [1, 5, 8, 10])

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $last = Role::orderBy('id', 'desc')->first();
            $this->assertSame('Test Role', $last->name);
            $this->assertSame('Test de description', $last->description);
            $this->assertSame('color: #ffffff;', $last->css);
            $this->assertSame([1, 5, 8, 10], $last->permissions->pluck('id')->toArray());
    }

    public function test_save_edit()
    {
        $this->actingAs(User::find(1));
        $model = Role::find(1);

        Livewire::test(Roles::class)
            ->call('edit', 1)
            ->set('model.name', 'Test nouveau nom')
            ->set('model.description', 'Test de description')
            ->set('model.css', 'color: #ffffff;')
            ->set('permissionsSelected', [1, 5, 8, 10])

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

            $model = Role::find(1);
            $this->assertSame('Test nouveau nom', $model->name);
            $this->assertSame('Test de description', $model->description);
            $this->assertSame('color: #ffffff;', $model->css);
            $this->assertEqualsCanonicalizing([1, 5, 8, 10], $model->permissions()->pluck('id')->toArray());
    }

    public function test_delete_selected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Roles::class)
            ->set('selected', [1])
            ->call('deleteSelected')
            ->assertEmitted('alert')
            ->assertSeeHtml('<b>1</b> rôle(s) ont été supprimé(s) avec succès !')
            ->assertHasNoErrors();
    }

    public function test_with_search_with_result()
    {
        Livewire::withQueryParams(['s' => 'prod'])
            ->test(Roles::class)
            ->assertSet('search', 'prod')
            ->assertDontSee('Aucun rôle trouvé');
    }

    public function test_with_search_no_rows()
    {
        Livewire::withQueryParams(['s' => 'xxzz'])
            ->test(Roles::class)
            ->assertSet('search', 'xxzz')
            ->assertSee('Aucun rôle trouvé');
    }

    public function test_with_sort_field_allowed()
    {
        Livewire::test(Roles::class)
            ->set('sortField', 'name')
            ->assertSet('sortField', 'name');
    }

    public function test_with_sort_field_not_allowed()
    {
        Livewire::test(Roles::class)
            ->set('sortField', 'notallowed')
            ->assertSet('sortField', 'created_at');
    }

    public function test_with_sort_field_not_allowed_on_mount()
    {
        Livewire::withQueryParams(['f' => 'notallowed'])
            ->test(Roles::class)
            ->assertSet('sortField', 'created_at');
    }
}
