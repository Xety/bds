<?php

namespace BDS\Livewire\Forms;

use BDS\Models\Incident;
use BDS\Models\Material;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Form;

class IncidentForm extends Form
{
    public ?Incident $incident;

    public ?int $material_id = null;

    public ?int $maintenance_id = null;

    public ?string $description = null;

    public ?string $started_at = null;

    public ?string $impact = null;

    public ?bool $is_finished = null;

    public ?string $finished_at = null;


    // Options list
    public Collection|array $maintenancesSearchable = [];

    public Collection|array $materialsSearchable = [];

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'material_id' => 'required|exists:materials,id',
            'description' => 'nullable',
            'impact' => 'required|in:' . collect(Incident::IMPACT)->map(function ($item) {
                    return $item['id'];
                })->sort()->values()->implode(','),
            'is_finished' => 'required|boolean',
            'started_at' => 'required|date_format:"d-m-Y H:i"',
            'finished_at' => 'exclude_if:is_finished,false|date_format:"d-m-Y H:i"|required',
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
            'material_id' => 'matériel',
            'description' => 'description',
            'started_at' => 'survenu le',
            'finished_at' => 'résolu le'
        ];
    }

    /**
     * Set the model and all his fields.
     *
     * @param Incident $incident
     *
     * @return void
     */
    public function setForm(Incident $incident): void
    {
        $this->fill([
            'cleaning' => $incident,
            'material_id' => $incident->material_id,
            'maintenance_id' => $incident->maintenance_id,
            'description' => $incident->description,
            'started_at' => $incident->started_at,
            'is_finished' => $incident->is_finished,
            'finished_at' => $incident->finished_at,
            'impact' => $incident->impact
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return Incident
     */
    public function store(): Incident
    {
        return Incident::create($this->only([
            'material_id',
            'maintenance_id',
            'description',
            'started_at',
            'is_finished',
            'finished_at',
            'impact'
        ]));
    }

    /**
     * Function to update the model and return it after.
     *
     * @return Incident
     */
    public function update(): Incident
    {
        return tap($this->incident)->update($this->only([
            'material_id',
            'maintenance_id',
            'description',
            'started_at',
            'is_finished',
            'finished_at',
            'impact'
        ]));
    }
}
