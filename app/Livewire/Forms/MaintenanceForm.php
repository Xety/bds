<?php

namespace BDS\Livewire\Forms;

use BDS\Enums\Maintenance\Realizations;
use BDS\Enums\Maintenance\Types;
use BDS\Events\Part\AlertEvent;
use BDS\Events\Part\CriticalAlertEvent;
use BDS\Models\Incident;
use BDS\Models\Maintenance;
use BDS\Models\Part;
use BDS\Models\PartExit;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Form;

class MaintenanceForm extends Form
{
    public ?Maintenance $maintenance;

    public ?string $gmao_id = null;

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
            'type' => ['required', Rule::enum(Types::class)],
            'realization' => ['required', Rule::enum(Realizations::class)],
            'operators' => 'required_if:realization,internal,both',
            'companies' => 'required_if:realization,external,both',
            'is_finished' => 'required|boolean',
            'started_at' => 'required|date_format:"d-m-Y H:i"',
            'finished_at' => 'exclude_if:is_finished,false|date_format:"d-m-Y H:i"|required',
            'parts.*.part_id' => 'required|distinct|numeric|exists:parts,id',
            'parts.*.number' => 'required|numeric|min:1|max:1000000',
            'parts.*' => [
                function ($attribute, $value, $fail) {
                    // Check we stock related to the number the user want to exit.
                    $part = Part::select('part_entry_total', 'part_exit_total')
                        ->where('id', $value['part_id'])->first();

                    // Need to handle the null value because all rules are validated before rendered.
                    if ($part === null || !isset($value['number'])) {
                        return $fail("");
                    }

                    if ($part->stock_total < $value['number']) {
                        return $fail("Pas assez de quantité en stock. (Actuellement {$part->stock_total} en stock)");
                    }
                }
            ]
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
            'finished_at' => 'terminée le',
            'parts.*.part_id' => 'pièce détachée',
            'parts.*.number' => 'nombre'
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
            'type' => $maintenance->type->value,
            'realization' => $maintenance->realization->value,
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
        $maintenance->operators()->sync($this->operators);
        $maintenance->companies()->sync($this->companies);

        // Incidents
        if(!empty($this->incidents)) {
            foreach ($this->incidents as $id) {
                $incident = Incident::whereId($id)->first();
                $incident->maintenance_id = $maintenance->getKey();
                $incident->save();
            }
        }

        // PartExits
        if (!empty($this->parts)) {
            foreach ($this->parts as $part) {
                $partExit = PartExit::create([
                    'maintenance_id' => $maintenance->getKey(),
                    'part_id' => $part['part_id'],
                    'number' => (int)$part['number']
                ]);

                if ($partExit->part->number_warning_enabled) {
                    event(new AlertEvent($partExit));
                }

                if ($partExit->part->number_critical_enabled) {
                    event(new CriticalAlertEvent($partExit));
                }
            }
        }

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($maintenance)
                ->event('created')
                ->withProperties(['attributes' => $maintenance->toArray()])
                ->log('L\'utilisateur :causer.full_name à créé la maintenance N°:subject.id pour le matériel ' . $maintenance->material->name .'.');
        }

        return $maintenance;
    }

    /**
     * Function to update the model and return it after.
     *
     * @return Maintenance
     */
    public function update(): Maintenance
    {
        // Set the finished date to null if the is_finished is false.
        if (!$this->is_finished) {
            $this->finished_at = null;
        }

        // Get the old incident before tap it.
        $activityLog['old'] = $this->maintenance->toArray();

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

        $maintenance->operators()->sync($this->operators);
        $maintenance->companies()->sync($this->companies);

        // Incidents
        if(!empty($this->incidents)) {
            $existingIds = $this->maintenance->incidents()->pluck('id')->toArray();

            $idsToDelete = array_diff($existingIds, $this->incidents);

            Incident::whereIn('id', $idsToDelete)->update(['maintenance_id' => null]);
            Incident::whereIn('id', $this->incidents)->update(['maintenance_id' => $this->maintenance->getKey()]);
        }

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($maintenance)
                ->event('updated')
                ->withProperties(['old' => $activityLog['old'], 'attributes' => $maintenance->toArray()])
                ->log('L\'utilisateur :causer.full_name à mis à jour la maintenance N°:subject.id. pour le matériel ' . $maintenance->material->name .'.');
        }

        return $maintenance;
    }
}
