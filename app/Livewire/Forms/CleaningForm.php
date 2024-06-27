<?php

namespace BDS\Livewire\Forms;

use BDS\Enums\Frequences;
use BDS\Models\Cleaning;
use BDS\Models\Material;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CleaningForm extends Form
{
    public ?Cleaning $cleaning;

    public ?int $material_id = null;

    public ?string $description = null;

    public ?float $selvah_ph_test_water = null;

    public ?float $selvah_ph_test_water_after_cleaning = null;

    public ?string $type = null;

    // Options list
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
            'type' => ['required', Rule::enum(Frequences::class)],
            'selvah_ph_test_water' => [
                Rule::requiredIf(function () {
                    $material = Material::find($this->material_id);

                    return $this->type == 'weekly' &&
                        !is_null($material) && $material->selvah_cleaning_test_ph_enabled;
                }),
                'numeric',
                'between:0,14',
                'nullable'
            ],
            'selvah_ph_test_water_after_cleaning' => [
                Rule::requiredIf(function () {
                    $material = Material::find($this->material_id);

                    return $this->type == 'weekly' &&
                        !is_null($material) && $material->selvah_cleaning_test_ph_enabled;
                }),
                'numeric',
                'between:0,14',
                'nullable'
            ],
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
            'selvah_ph_test_water' => 'PH de l\'eau',
            'selvah_ph_test_water_after_cleaning' => 'PH de l\'eau après nettoyage',
            'type' => 'type'
        ];
    }

    /**
     * Set the model and all his fields.
     *
     * @param Cleaning $cleaning
     *
     * @return void
     */
    public function setCleaning(Cleaning $cleaning): void
    {
        $this->fill([
            'cleaning' => $cleaning,
            'material_id' => $cleaning->material_id,
            'description' => $cleaning->description,
            'selvah_ph_test_water' => $cleaning->selvah_ph_test_water,
            'selvah_ph_test_water_after_cleaning' => $cleaning->selvah_ph_test_water_after_cleaning,
            'type' => $cleaning->type->value
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return Cleaning
     */
    public function store(): Cleaning
    {
        $cleaning = Cleaning::create($this->only([
            'material_id',
            'description',
            'selvah_ph_test_water',
            'selvah_ph_test_water_after_cleaning',
            'type'
        ]));

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($cleaning)
                ->event('created')
                ->withProperties(['attributes' => $cleaning->toArray()])
                ->log('L\'utilisateur :causer.full_name à créé le nettoyage N°:subject.id pour le matériel ' . $cleaning->material->name . '.');
        }

        return $cleaning;
    }

    /**
     * Function to update the model and return it after.
     *
     * @return Cleaning
     */
    public function update(): Cleaning
    {
        // Get the old data before tap it.
        $activityLog['old'] = $this->cleaning->toArray();

        $cleaning = tap($this->cleaning)->update($this->only([
            'material_id',
            'description',
            'selvah_ph_test_water',
            'selvah_ph_test_water_after_cleaning',
            'type'
        ]));

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($cleaning)
                ->event('updated')
                ->withProperties(['old' => $activityLog['old'], 'attributes' => $cleaning->toArray()])
                ->log('L\'utilisateur :causer.full_name à mis à jour le nettoyage N°:subject.id pour le matériel ' . $cleaning->material->name . '.');
        }

        return $cleaning;
    }
}
