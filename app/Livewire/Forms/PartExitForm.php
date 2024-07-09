<?php

namespace BDS\Livewire\Forms;

use BDS\Events\Part\AlertEvent;
use BDS\Events\Part\CriticalAlertEvent;
use BDS\Models\Part;
use BDS\Models\PartExit;
use Illuminate\Support\Collection;
use Livewire\Form;

class PartExitForm extends Form
{
    public ?PartExit $partExit = null;

    public ?int $part_id = null;

    public ?int $maintenance_id = null;

    public ?string $description = null;

    public ?int $number = null;

    public bool $isCreating = false;

    // Options list
    public Collection|array $partsSearchable = [];

    public Collection|array $maintenancesSearchable = [];

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'maintenance_id' => 'present|numeric|exists:maintenances,id|nullable',
            'description' => 'nullable',
        ];

        if ($this->isCreating) {
            $rules = array_merge($rules, [
                'part_id' => 'required|numeric|exists:parts,id',
                'number' => [
                    // Exclude the rule if part_id is null else it will cause an error when accessing `$this->part_id`.
                    'exclude_if:part_id,null',
                    'required',
                    'numeric',
                    'min:1',
                    'max:1000000',
                    function ($attribute, $value, $fail) {
                        // Check the stock related to the number the user want to exit.
                        $part = Part::select('part_entry_total', 'part_exit_total')
                            ->where('id', $this->part_id)->first();

                        // Need to handle the null value because all rules are validated before rendered.
                        if ($part === null) {
                            return $fail("");
                        }

                        if ($part->stock_total < $value) {
                            return $fail("Pas assez de quantité en stock. (Actuellement {$part->stock_total} en stock)");
                        }
                    }
                ]
            ]);
        }

        return $rules;
    }

    /**
     * Translated attribute used in failed messages.
     *
     * @return array
     */
    public function validationAttributes(): array
    {
        return [
            'part_id' => 'pièce détachée',
            'number' => 'nombre de pièce',
            'maintenance_id' => 'maintenance'
        ];
    }

    public function setPartExit(PartExit $partExit): void
    {
        $this->fill([
            'partExit' => $partExit,
            'part_id' => $partExit->part_id,
            'maintenance_id' => $partExit->maintenance_id,
            'description' => $partExit->description,
            'number' => $partExit->number
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return PartExit
     */
    public function store(): PartExit
    {
        $partExit = PartExit::create($this->only([
            'maintenance_id',
            'part_id',
            'description',
            'number'
        ]));

        if ($partExit->part->number_warning_enabled) {
            event(new AlertEvent($partExit));
        }

        if ($partExit->part->number_critical_enabled) {
            event(new CriticalAlertEvent($partExit));
        }

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($partExit)
                ->event('created')
                ->withProperties(['attributes' => $partExit->toArray()])
                ->log('L\'utilisateur :causer.full_name à créé une sortie de :subject.number pièce(s) pour la pièce détachée ' . $partExit->part->name . '.');
        }

        return $partExit;
    }

    /**
     * Function to update the model.
     *
     * @return PartExit
     */
    public function update(): PartExit
    {
        // Get the old data before tap it.
        $activityLog['old'] = $this->partExit->toArray();

        $partExit = tap($this->partExit)->update($this->only([
            'maintenance_id',
            'description'
        ]));

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($partExit)
                ->event('updated')
                ->withProperties(['old' => $activityLog['old'], 'attributes' => $partExit->toArray()])
                ->log('L\'utilisateur :causer.full_name à mis à jour la sortie N°:subject.id de la pièce détachée ' . $partExit->part->name . '.');
        }

        return $partExit;
    }
}
