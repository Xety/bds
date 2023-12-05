<?php

namespace BDS\Livewire\Forms;

use BDS\Models\Cleaning;
use BDS\Models\Material;
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
            'type' => 'required|in:' . collect(Cleaning::TYPES)->map(function ($item) {
                    return $item['id'];
                })->sort()->values()->implode(','),
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
            'type' => $cleaning->type
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return Cleaning
     */
    public function store(): Cleaning
    {
        return Cleaning::create($this->only([
            'material_id',
            'description',
            'selvah_ph_test_water',
            'selvah_ph_test_water_after_cleaning',
            'type'
        ]));
    }

    /**
     * Function to update the model and return it after.
     *
     * @return Cleaning
     */
    public function update(): Cleaning
    {
        return tap($this->cleaning)->update($this->only([
            'material_id',
            'description',
            'selvah_ph_test_water',
            'selvah_ph_test_water_after_cleaning',
            'type'
        ]));
    }
}
