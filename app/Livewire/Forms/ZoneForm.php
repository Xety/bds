<?php

namespace BDS\Livewire\Forms;

use Livewire\Form;
use BDS\Models\Zone;

class ZoneForm extends Form
{
    public ?Zone $zone = null;

    public ?int $id = null;

    public ?string $name = null;

    public ?int $site_id = null;

    public ?int $parent_id = null;

    public ?bool $allow_material = false;

    public function setZone(Zone $zone): void
    {
        $this->fill([
            'id' => $zone->id,
            'name' => $zone->name,
            'parent_id' => $zone->parent_id,
            'allow_material' => $zone->allow_material,
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return Zone
     */
    public function store(): Zone
    {
        $this->fill([
            'site_id' => getPermissionsTeamId(),
        ]);

        return Zone::create($this->only([
            'site_id',
            'name',
            'parent_id'
        ]));
    }

    /**
     * Function to update the model.
     *
     * @return Zone
     */
    public function update(): Zone
    {
        return tap($this->zone)->update($this->only([
            'name',
            'parent_id'
        ]));
    }
}
