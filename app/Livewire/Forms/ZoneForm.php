<?php

namespace BDS\Livewire\Forms;

use Livewire\Form;
use BDS\Models\Zone;

class ZoneForm extends Form
{
    public ?Zone $zone = null;

    public ?string $name = null;

    public ?int $site_id = null;

    public function setZone(Zone $zone): void
    {
        $this->fill([
            'name' => $zone->name
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
            'name'
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
            'name'
        ]));
    }
}
