<?php

namespace BDS\Livewire\Forms;

use BDS\Models\Selvah\CorrespondenceSheet;
use Livewire\Form;

class CorrespondenceSheetForm extends Form
{
    public ?CorrespondenceSheet $correspondenceSheet = null;


    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|min:2|max:150|unique:sites,name,',
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
            'name' => 'nom',
        ];
    }

    public function setForm(CorrespondenceSheet $correspondenceSheet): void
    {
        $this->fill([
            'correspondenceSheet' => $correspondenceSheet,
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return CorrespondenceSheet
     */
    public function store(): CorrespondenceSheet
    {
        $correspondenceSheet = CorrespondenceSheet::create($this->only([
            'name'
        ]));

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($correspondenceSheet)
                ->event('created')
                ->withProperties(['attributes' => $correspondenceSheet->toArray()])
                ->log('L\'utilisateur :causer.full_name à créé la fiche de correspondance N°:subject.id.');
        }

        return $correspondenceSheet;
    }

    /**
     * Function to update the model.
     *
     * @return CorrespondenceSheet
     */
    public function update(): CorrespondenceSheet
    {
        // Get the old data before tap it.
        $activityLog['old'] = $this->correspondenceSheet->toArray();

        $correspondenceSheet = tap($this->correspondenceSheet)->update($this->only([
            'name'
        ]));

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($correspondenceSheet)
                ->event('updated')
                ->withProperties(['old' => $activityLog['old'], 'attributes' => $correspondenceSheet->toArray()])
                ->log('L\'utilisateur :causer.full_name à mis à jour la fiche de correspondance N°:subject.id.');
        }

        return $correspondenceSheet;
    }
}
