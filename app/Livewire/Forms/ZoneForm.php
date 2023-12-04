<?php

namespace BDS\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;
use BDS\Models\Zone;

class ZoneForm extends Form
{
    public ?Zone $zone = null;

    public ?string $name = null;

    public ?int $site_id = null;

    public ?int $parent_id = null;

    public ?bool $allow_material = false;

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'  => [
                "required",
                "min:2",
                "max:150",
                Rule::unique('zones')->where(fn ($query) => $query->where('site_id', getPermissionsTeamId())),
            ],
            'parent_id' => 'nullable|exists:zones,id|different:' . $this->zone?->id,
            'allow_material' => 'required|boolean',
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
            'name' => 'nom',
            'parent_id' => 'zone parent',
        ];
    }

    public function setZone(Zone $zone): void
    {
        $this->fill([
            'zone' => $zone,
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
            'parent_id',
            'allow_material'
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
            'parent_id',
            'allow_material'
        ]));
    }
}
