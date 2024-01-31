<?php

namespace BDS\Livewire;

use BDS\Models\Cleaning;
use BDS\Models\Incident;
use BDS\Models\Maintenance;
use BDS\Models\Material;
use BDS\Models\Part;
use BDS\Models\PartEntry;
use BDS\Models\PartExit;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class QrCodeModal extends Component
{
    use AuthorizesRequests;

    /**
     * Used to update in URL the query string.
     *
     * @var array
     */
    protected array $queryString = [
        'type' => ['except' => ''],
        'qrcode' => ['except' => ''],
        'qrcodeId' => ['except' => '']
    ];

    /**
     * Whatever the QR COde is set or not.
     *
     * @var bool
     */
    public bool|string $qrcode = '';

    /**
     * The QR Code id if set.
     *
     * @var null|int
     */
    public null|int $qrcodeId = null;

    /**
     * Used to show the QR Code modal.
     *
     * @var bool
     */
    public bool $showQrCodeModal = false;

    /**
     * The type of the scanned QR Code with their actions
     *
     * @var array
     */
    public array $types = [
        'material' => [
            'actions' => []
        ],
        'part' => [
            'actions' => []
        ]
    ];

    /**
     * The action to do after the user has scanned the QR Code.
     *
     * @var string
     */
    public string $action = '';

    /**
     * The type of the action.
     *
     * @var string
     */
    public string $type = '';

    /**
     * The model related to the action, part or material.
     *
     * @var Material|Part|null
     */
    public Material|Part|null $model = null;

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'action' => 'required|in:' . collect($this->types[$this->type]['actions'])->keys()->implode(','),
        ];
    }

    /**
     * The Livewire Component constructor.
     *
     * @return void
     */
    public function mount(): void
    {
        // Material types
        if (Auth::user()->can('create', Incident::class)) {
            $this->types['material']['actions']['incidents'] = 'Incident';
        }
        if (Auth::user()->can('create', Maintenance::class)) {
            $this->types['material']['actions']['maintenances'] = 'Maintenance';
        }
        if (Gate::allows('create', Cleaning::class)) {
            $this->types['material']['actions']['cleanings'] = 'Nettoyage';
        }

        //  Part types
        if (Auth::user()->can('create', PartEntry::class)) {
            $this->types['part']['actions']['part-entries'] = 'Entrée de pièce';
        }
        if (Auth::user()->can('create', PartExit::class)) {
            $this->types['part']['actions']['part-exits'] = 'Sortie de pièce';
        }

        if ($this->qrcode === true && array_key_exists($this->type, $this->types) && $this->qrcodeId !== null) {
            if ($this->type == 'material' && Gate::allows('scanQrCode', Material::class)) {
                $this->model = Material::with(['zone', 'zone.site'])->find($this->qrcodeId);
            }

            if ($this->type == 'part' && Gate::allows('scanQrCode', Part::class)) {
                $this->model = Part::with(['site'])->find($this->qrcodeId);
            }

            if ($this->model !== null) {
                // Increment the flash_count for the model.
                $this->model->qrcode_flash_count++;
                $this->model->save();

                $this->select();
            }
        }
    }

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.qr-code-modal');
    }

    /**
     * Function to show the QR Code modal.
     *
     * @return void
     */
    public function select(): void
    {
        $this->showQrCodeModal = true;
    }

    /**
     * Redirect the user regarding his choice.
     *
     * @return RedirectResponse|void
     */
    public function redirection()
    {
        $this->validate();

        if (in_array($this->action, array_keys($this->types[$this->type]['actions']))) {
            $params = [
                'creating' => 'true'
            ];
            $siteId = null;

            if ($this->type === 'material') {
                $params += ['materialId' => $this->qrcodeId];
                $siteId = $this->model->zone->site->id;
            } elseif ($this->type === 'part') {
                $params += ['partId' => $this->qrcodeId];
                $siteId = $this->model->site->id;
            }

            // Before redirecting, we need to check the permission and change if needed his site.
            $teamId = getPermissionsTeamId();

            setPermissionsTeamId($siteId);
            $user = Auth::user();
            $user
                ->unsetRelation('roles')
                ->unsetRelation('permissions');

            $permission = $user->hasPermissionTo('viewAny ' . $this->type);

            if (!$permission) {
                setPermissionsTeamId($teamId);
                $user
                    ->unsetRelation('roles')
                    ->unsetRelation('permissions');
            }
            session()->put([
                'current_site_id' => $permission ? $siteId : $teamId
            ]);

            $user->current_site_id = $permission ? $siteId : $teamId;
            $user->save();

            return redirect()
                ->route($this->action . '.index', $params);
        }

        $this->showQrCodeModal = false;
    }
}
