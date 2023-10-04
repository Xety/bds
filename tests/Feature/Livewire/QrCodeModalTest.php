<?php
namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Selvah\Http\Livewire\QrCodeModal;
use Selvah\Models\User;
use Tests\TestCase;

class QrCodeModalTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $user = User::find(1);

        $this->actingAs($user);
        $this->get('/')->assertSeeLivewire(QrCodeModal::class);
    }

    public function test_qrcode_open_modal_with_material()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['qrcode' => 'true', 'type' => 'material', 'qrcodeid' => '1'])
            ->test(QrCodeModal::class)
            ->assertSet('type', 'material')
            ->assertSet('showQrCodeModal', true)
            ->assertSee('BMP1');
    }

    public function test_qrcode_open_modal_with_part()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['qrcode' => 'true', 'type' => 'part', 'qrcodeid' => '1'])
            ->test(QrCodeModal::class)
            ->assertSet('type', 'part')
            ->assertSet('showQrCodeModal', true)
            ->assertSee('Ventouse 40mm');
    }

    public function test_qrcode_open_modal_with_unknown()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['qrcode' => 'true', 'type' => 'unknown', 'qrcodeid' => '1'])
            ->test(QrCodeModal::class)
            ->assertSet('showQrCodeModal', false);
    }

    public function test_qrcode_open_modal_with_unknown_part()
    {
        $this->actingAs(User::find(1));

        Livewire::withQueryParams(['qrcode' => 'true', 'type' => 'part', 'qrcodeid' => '99999'])
            ->test(QrCodeModal::class)
            ->assertSet('showQrCodeModal', false);
    }
}
