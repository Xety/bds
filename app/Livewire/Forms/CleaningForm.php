<?php

namespace BDS\Livewire\Forms;

use BDS\Models\Cleaning;
use Livewire\Form;

class CleaningForm extends Form
{
    public ?Cleaning $cleaning;

    public ?int $material_id = null;

    public ?string $description = null;

    public ?string $type = null;

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
            'type'
        ]));
    }
}
