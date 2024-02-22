<?php

namespace BDS\Livewire\Forms;

use BDS\Models\Maintenance;
use Illuminate\Support\Collection;
use Livewire\Form;

class MaintenanceForm extends Form
{
    public ?Maintenance $maintenance;

    public ?int $gmao_id = null;

    public ?int $material_id = null;

    public ?string $description = null;

    public ?string $reason = null;

    public ?string $type = null;

    public ?string $realization = null;

    public ?string $started_at = null;

    public ?string $finished_at = null;

    public ?bool $is_finished = false;

    public array $incidents = [];

    public array $operators = [];

    public array $companies = [];

    public Collection|array $parts = [];

    // Options list
    public Collection|array $materialsSearchable = [];

    public Collection|array $incidentsSearchable = [];

    public Collection|array $operatorsSearchable = [];

    public Collection|array $companiesSearchable = [];

    public Collection|array $partsSearchable = [];

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'gmao_id' => 'nullable|min:2|max:30',
            'material_id' => 'present|numeric|exists:materials,id|nullable',
            'description' => 'required',
            'reason' => 'required',
            'type' => 'required|in:' . collect(Maintenance::TYPES)->map(function ($item) {
                    return $item['id'];
                })->sort()->values()->implode(','),
            'realization' => 'required|in:' . collect(Maintenance::REALIZATIONS)->map(function ($item) {
                    return $item['id'];
                })->sort()->values()->implode(','),
            'operators' => 'required_if:realization,internal,both',
            'companies' => 'required_if:realization,external,both',
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
            'reason' => 'raison',
            'type' => 'entreprises',
            'realization' => 'réalisation',
            'operators' => 'opérateurs',
            'companies' => 'entreprises',
            'started_at' => 'commencée le',
            'finished_at' => 'finie le'
        ];
    }

    /**
     * Set the model and all his fields.
     *
     * @param Maintenance $maintenance
     *
     * @return void
     */
    public function setForm(Maintenance $maintenance): void
    {
        $this->fill([
            'maintenance' => $maintenance,
            'gmao_id' => $maintenance->gmao_id,
            'material_id' => $maintenance->material_id,
            'description' => $maintenance->description,
            'reason' => $maintenance->reason,
            'type' => $maintenance->type,
            'realization' => $maintenance->realization,
            'incidents' => $maintenance->incidents()->pluck('id')->toArray(),
            'operators' => $maintenance->operators()->pluck('id')->toArray(),
            'companies' => $maintenance->companies()->pluck('id')->toArray(),
            'started_at' => $maintenance->started_at->format('d-m-Y H:i'),
            'is_finished' => $maintenance->is_finished,
            'finished_at' => $maintenance->finished_at?->format('d-m-Y H:i'),
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return Maintenance
     */
    public function store(): Maintenance
    {
        $maintenance = Maintenance::create($this->only([
            'gmao_id',
            'material_id',
            'description',
            'reason',
            'type',
            'realization',
            'started_at',
            'is_finished',
            'finished_at',
        ]));

        //$maintenance->incidents()->sync($this->incidents);
        $maintenance->operators()->sync($this->operators);
        $maintenance->companies()->sync($this->companies);

        return $maintenance;
    }

    /**
     * Function to update the model and return it after.
     *
     * @return Maintenance
     */
    public function update(): Maintenance
    {
        $maintenance = tap($this->maintenance)->update($this->only([
            'gmao_id',
            'material_id',
            'description',
            'reason',
            'type',
            'realization',
            'started_at',
            'is_finished',
            'finished_at',
        ]));

        //$maintenance->incidents()->sync($this->incidents);
        $maintenance->operators()->sync($this->operators);
        $maintenance->companies()->sync($this->companies);

        return $maintenance;
    }
}
