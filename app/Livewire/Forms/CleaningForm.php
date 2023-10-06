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

    public function setCleaning(Cleaning $cleaning)
    {
        $this->cleaning = $cleaning;

        $this->material_id = $cleaning->material_id;
        $this->description = $cleaning->description;
        $this->type = $cleaning->type;
    }

    public function store()
    {
        return Cleaning::create($this->only([
            'material_id',
            'description',
            'type'
        ]));
    }

    public function update()
    {
        return tap($this->cleaning)->update($this->only([
            'material_id',
            'description',
            'type'
        ]));
    }
}
