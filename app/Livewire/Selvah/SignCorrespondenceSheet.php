<?php

namespace BDS\Livewire\Selvah;

use BDS\Livewire\Traits\WithToast;
use BDS\Models\Selvah\CorrespondenceSheet;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class SignCorrespondenceSheet extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use WithToast;

    /**
     * Used to update in URL the query string.
     *
     * @var string[]
     */
    protected $queryString = [
        'signing',
    ];

    /**
     * Whatever the Signing url param is set or not.
     *
     * @var bool
     */
    public bool $signing;

    /**
     * Used to show the sign modal.
     *
     * @var bool
     */
    public bool $showSignModal = false;

    public ?string $responsable_commentaire = null;

    public ?CorrespondenceSheet $sheet;

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'responsable_commentaire'  => 'nullable'
        ];
    }

    /**
     * Translated attribute used in failed messages.
     *
     * @return array
     */
    public function validationAttributes(): array
    {
        return [
            'responsable_commentaire' => 'remarques éventuelles'
        ];
    }

    public function mount($sheet = null): void
    {
        $this->sheet = $sheet;

        // Check if the edit option are set into the url, and if yes, open the Edit Modal if the user has the permissions.
        if ($this->signing === true && auth()->user()->can('sign', $sheet)) {
            $this->create();
        }
    }

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.selvah.sign-correspondence-sheet');
    }

    /**
     * Create a blank model and assign it to the model. (Used in create modal)
     *
     * @return void
     */
    public function create(): void
    {
        $this->authorize('sign', CorrespondenceSheet::class);

        $this->showSignModal = true;
    }


    /**
     * Validate and save the model.
     *
     * @return void
     */
    public function signSheet(): void
    {
        $this->authorize('sign', CorrespondenceSheet::class);

        $this->validate();

        $this->sheet->update([
            'responsable_commentaire' => $this->responsable_commentaire,
            'responsable_signature_id' => auth()->user()->id
        ]);

        $this->showSignModal = false;
    }

}
