<?php

namespace BDS\Livewire\Selvah;

use BDS\Livewire\Traits\WithToast;
use BDS\Models\Selvah\CorrespondenceSheet;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CreateCorrespondenceSheet extends Component
{
    use AuthorizesRequests;
    use WithToast;


    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.selvah.create-correspondence-sheet');
    }

}
