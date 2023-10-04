<?php
namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Selvah\Http\Livewire\Users;
use Selvah\Models\User;
use Selvah\Notifications\Auth\RegisteredNotification;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));

        $this->get('/users')->assertSeeLivewire(Users::class);
    }

    public function test_create_modal()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Users::class)
            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ;
    }

    public function test_create_modal_with_edit_model_before()
    {
        $this->actingAs(User::find(1));
        $model = User::find(2);

        Livewire::test(Users::class)
            ->call('edit', 2)
            ->assertSet('model.username', $model->username)
            ->assertSet('model.first_name', $model->first_name)
            ->assertSet('model.last_name', $model->last_name)
            ->assertSet('model.email', $model->email)
            ->assertSet('rolesSelected', $model->roles()->pluck('id')->toArray())

            ->call('create')
            ->assertSet('model.username', '')
            ->assertSet('model.first_name', '')
            ->assertSet('model.last_name', '')
            ->assertSet('model.email', '')
            ->assertSet('rolesSelected', [])
            ->assertSet('model', User::make())
            ;
    }

    public function test_edit_modal()
    {
        $this->actingAs(User::find(1));
        $model = User::find(2);

        Livewire::test(Users::class)
            ->assertSet('model.username', '')
            ->assertSet('model.first_name', '')
            ->assertSet('model.last_name', '')
            ->assertSet('model.email', '')
            ->assertSet('rolesSelected', [])
            ->assertSet('model', User::make())

            ->call('edit', 2)
            ->assertSet('model.username', $model->username)
            ->assertSet('model.first_name', $model->first_name)
            ->assertSet('model.last_name', $model->last_name)
            ->assertSet('model.email', $model->email)
            ->assertSet('rolesSelected', $model->roles()->pluck('id')->toArray());
    }

    public function test_save_new_model()
    {
        Notification::fake();

        $this->actingAs(User::find(1));

        Livewire::test(Users::class)
            ->call('create')
            ->set('model.username', 'JeanClaude.T')
            ->set('model.first_name', 'JeanClaude')
            ->set('model.last_name', 'Test')
            ->set('model.email', 'jeanclaude@gmail2.com')
            ->set('rolesSelected', [1, 2])

            ->call('save')
            ->assertSet('showModal', false)
            ->assertEmitted('alert')
            ->assertHasNoErrors();

        $last = User::orderBy('id', 'desc')->first();
        $this->assertSame('JeanClaude.T', $last->username);
        $this->assertSame('JeanClaude', $last->first_name);
        $this->assertSame('Test', $last->last_name);
        $this->assertSame('jeanclaude@gmail2.com', $last->email);
        $this->assertSame([1, 2], $last->roles()->pluck('id')->toArray());
        $this->assertFalse($last->hasSetupPassword());

        Notification::assertSentTo($last, RegisteredNotification::class);
    }

    public function test_delete_selected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Users::class)
            ->set('selected', [2])
            ->call('deleteSelected')
            ->assertEmitted('alert')
            ->assertSeeHtml('<b>1</b> utilisateur(s) ont été supprimé(s) avec succès !')
            ->assertHasNoErrors();
    }

    public function test_restore_selected()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Users::class)
            ->set('selected', [2])
            ->call('deleteSelected')

            ->call('edit', 2)
            ->call('restore')
            ->assertEmitted('alert')
            ->assertSeeHtml("L'utilisateur <b>Franck.L</b> a été restauré avec succès !")
            ->assertHasNoErrors();
    }

    public function test_with_search_with_result()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['s' => 'emeric'])
            ->test(Users::class)
            ->assertSet('search', 'emeric')
            ->assertDontSee('Aucun utilisateur trouvé');
    }

    public function test_with_search_no_rows()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['s' => 'xx'])
            ->test(Users::class)
            ->assertSet('search', 'xx')
            ->assertSee('Aucun utilisateur trouvé');
    }

    public function test_with_sort_field_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Users::class)
            ->set('sortField', 'username')
            ->assertSet('sortField', 'username');
    }

    public function test_with_sort_field_not_allowed()
    {
        $this->actingAs(User::find(1));

        Livewire::test(Users::class)
            ->set('sortField', 'notallowed')
            ->assertSet('sortField', 'created_at');
    }

    public function test_with_sort_field_not_allowed_on_mount()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['f' => 'notallowed'])
            ->test(Users::class)
            ->assertSet('sortField', 'created_at');
    }
}
