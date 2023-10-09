<?php
namespace Tests\Feature\Livewire;

use BDS\Livewire\Users;
use BDS\Models\User;
use BDS\Notifications\Auth\RegisteredNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function setUp(): void
    {
        parent::setUp();

        $this->session(['current_site_id' => 1]);

        $this->actingAs(User::find(1));
        setPermissionsTeamId(1);
    }

    public function test_page_contains_livewire_component()
    {
        $this->get('/users')->assertSeeLivewire(Users::class);
    }

    public function test_create_modal()
    {
        Livewire::test(Users::class)
            ->call('create')
            ->assertSet('isCreating', true)
            ->assertSet('showModal', true)
            ;
    }

    public function test_create_modal_with_edit_model_before()
    {
        $model = User::find(2);

        Livewire::test(Users::class)
            ->call('edit', $model)
            ->assertSet('form.username', $model->username)
            ->assertSet('form.first_name', $model->first_name)
            ->assertSet('form.last_name', $model->last_name)
            ->assertSet('form.email', $model->email)
            ->assertSet('form.office_phone', $model->office_phone)
            ->assertSet('form.cell_phone', $model->cell_phone)
            ->assertSet('form.end_employment_contract', $model->end_employment_contract)
            ->assertSet('form.rolesSelected', $model->roles()->pluck('id')->toArray())

            ->call('create')
            ->assertSet('form.username', '')
            ->assertSet('form.first_name', '')
            ->assertSet('form.last_name', '')
            ->assertSet('form.email', '')
            ->assertSet('form.office_phone', '')
            ->assertSet('form.cell_phone', '')
            ->assertSet('form.end_employment_contract', '')
            ->assertSet('form.rolesSelected', [])
            ;
    }

    public function test_edit_modal()
    {
        $model = User::find(2);

        Livewire::test(Users::class)
            ->call('create')
            ->assertSet('form.username', '')
            ->assertSet('form.first_name', '')
            ->assertSet('form.last_name', '')
            ->assertSet('form.email', '')
            ->assertSet('form.office_phone', '')
            ->assertSet('form.cell_phone', '')
            ->assertSet('form.end_employment_contract', '')
            ->assertSet('form.rolesSelected', [])

            ->call('edit', $model)
            ->assertSet('form.username', $model->username)
            ->assertSet('form.first_name', $model->first_name)
            ->assertSet('form.last_name', $model->last_name)
            ->assertSet('form.email', $model->email)
            ->assertSet('form.office_phone', $model->office_phone)
            ->assertSet('form.cell_phone', $model->cell_phone)
            ->assertSet('form.end_employment_contract', $model->end_employment_contract)
            ->assertSet('form.rolesSelected', $model->roles()->pluck('id')->toArray());
    }

    public function test_save_new_model()
    {
        Notification::fake();

        Livewire::test(Users::class)
            ->call('create')
            ->set('form.username', 'JeanClaude.T')
            ->set('form.first_name', 'JeanClaude')
            ->set('form.last_name', 'Test')
            ->set('form.email', 'jeanclaude@gmail2.com')
            ->set('form.office_phone', '0612345678')
            ->set('form.cell_phone', '0712345678')
            ->set('form.end_employment_contract', '08-10-2023 22:10')
            ->set('form.rolesSelected', [1, 2])

            ->call('save')
            ->assertSet('showModal', false)
            ->assertDispatched('alert')
            ->assertHasNoErrors();

        $last = User::orderBy('id', 'desc')->first();
        $this->assertSame('JeanClaude.T', $last->username);
        $this->assertSame('JeanClaude', $last->first_name);
        $this->assertSame('Test', $last->last_name);
        $this->assertSame('jeanclaude@gmail2.com', $last->email);
        $this->assertSame('0612345678', $last->office_phone);
        $this->assertSame('0712345678', $last->cell_phone);
        $this->assertSame('08-10-2023 22:10', $last->end_employment_contract->format('d-m-Y H:i'));
        $this->assertSame([1, 2], $last->roles()->pluck('id')->toArray());
        $this->assertFalse($last->hasSetupPassword());
        $this->assertSame([1], $last->sites()->pluck('site_id')->toArray());

        Notification::assertSentTo($last, RegisteredNotification::class);
    }

    public function test_delete_selected()
    {
        Livewire::test(Users::class)
            ->set('selected', [2])
            ->call('deleteSelected')
            ->assertDispatched('alert')
            ->assertSeeHtml('<b>1</b> utilisateur(s) ont été supprimé(s) avec succès !')
            ->assertHasNoErrors();
    }

    public function test_restore_selected()
    {
        Livewire::test(Users::class)
            ->set('selected', [2])
            ->call('deleteSelected')

            ->call('edit', 2)
            ->call('restore')
            ->assertDispatched('alert')
            ->assertSeeHtml("L'utilisateur <b>Franck.L</b> a été restauré avec succès !")
            ->assertHasNoErrors();
    }

    public function test_with_search_with_result()
    {
        Livewire::test(Users::class)
            ->set('filters.username', 'emeric')
            ->assertDontSee('Aucun utilisateur trouvé');
    }

    public function test_with_search_no_rows()
    {
        Livewire::test(Users::class)
            ->set('filters.username', 'xxzzyy')
            ->assertSee('Aucun utilisateur trouvé');
    }

    public function test_with_sort_field_allowed()
    {
        Livewire::test(Users::class)
            ->set('sortField', 'username')
            ->assertSet('sortField', 'username');
    }

    public function test_with_sort_field_not_allowed()
    {
        Livewire::test(Users::class)
            ->set('sortField', 'notallowed')
            ->assertSet('sortField', 'created_at');
    }

    public function test_with_sort_field_not_allowed_on_mount()
    {
        Livewire::withQueryParams(['f' => 'notallowed'])
            ->test(Users::class)
            ->assertSet('sortField', 'created_at');
    }
}
