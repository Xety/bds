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
     * The type of the scanned QR Code with their permissions and views keys.
     *
     * @var array
     */
    public array $types = [
        'material' => [
            'permission' => [],
            'view' => []
        ],
        'part' => [
            'permission' => [],
            'view' => []
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
            'action' => 'required|in:' . collect($this->types[$this->type]['permission'])->keys()->implode(','),
        ];
    }

    /**
     * The Livewire Component constructor.
     *
     * @return void
     */
    public function mount(): void
    {
        if ($this->qrcode === true && array_key_exists($this->type, $this->types) && $this->qrcodeId !== null) {
            if ($this->type == 'material' && Gate::allows('scanQrCode', Material::class)) {
                $this->model = Material::with(['zone', 'zone.site'])->find($this->qrcodeId);
            }

            if ($this->type == 'part' && Gate::allows('scanQrCode', Part::class)) {
                $this->model = Part::with(['site'])->find($this->qrcodeId);
            }

            if ($this->model !== null) {
                // We need to check the permission of the user for each permissions regarding
                // the site where the material/part belongs to.

                // Get the siteId where the material/part belongs to.
                $siteId = null;
                if ($this->type === 'material') {
                    $siteId = $this->model->zone->site->id;
                } elseif ($this->type === 'part') {
                    $siteId = $this->model->site->id;
                }
                $teamId = getPermissionsTeamId();

                // Set the teamId to the siteId where the material/part belongs to
                // and remove cached roles/permissions for the user.
                setPermissionsTeamId($siteId);
                $user = Auth::user();
                $user
                    ->unsetRelation('roles')
                    ->unsetRelation('permissions');

                // Check the permission for each action.
                // Material types
                if ($user->can('create', Incident::class)) {
                    $this->types['material']['permission']['incident'] = 'Incident';
                    $this->types['material']['view']['incident'] = 'incidents';
                }
                if ($user->can('create', Maintenance::class)) {
                    $this->types['material']['permission']['maintenance'] = 'Maintenance';
                    $this->types['material']['view']['maintenance'] = 'maintenances';
                }
                if ($user->can('create', Cleaning::class)) {
                    $this->types['material']['permission']['cleaning'] = 'Nettoyage';
                    $this->types['material']['view']['cleaning'] = 'cleanings';
                }

                //  Part types
                if ($user->can('create', PartEntry::class)) {
                    $this->types['part']['permission']['part-entry'] = 'Entrée de pièce';
                    $this->types['part']['view']['part-entry'] = 'part-entries';
                }
                if ($user->can('create', PartExit::class)) {
                    $this->types['part']['permission']['part-exit'] = 'Sortie de pièce';
                    $this->types['part']['view']['part-exit'] = 'part-exits';
                }

                // Set back the teamId and remove the relations again.
                setPermissionsTeamId($teamId);
                $user
                    ->unsetRelation('roles')
                    ->unsetRelation('permissions');

                // If the user does not have any permission, don't show the modal.
                if (empty($this->types['part']['permission']) && empty($this->types['material']['permission'])) {
                    return;
                }


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

        if (in_array($this->action, array_keys($this->types[$this->type]['permission']))) {
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

            $permission = $user->hasPermissionTo('viewAny ' . $this->action);

            if (!$permission) {
                setPermissionsTeamId($teamId);
                $user
                    ->unsetRelation('roles')
                    ->unsetRelation('permissions');
            }
            session()->put([
                'current_site_id' => $permission ? $siteId : $teamId
            ]);

            // Increment the QR Code counter.
            $user->current_site_id = $permission ? $siteId : $teamId;
            $user->save();

            return redirect()
                ->route($this->types[$this->type]['view'][$this->action] . '.index', $params);
        }

        $this->showQrCodeModal = false;
    }
}
