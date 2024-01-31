<?php

namespace BDS\Livewire\Forms;

use BDS\Models\PartEntry;
use Illuminate\Support\Collection;
use Livewire\Form;

class PartEntryForm extends Form
{
    public ?PartEntry $partEntry = null;

    public ?int $part_id = null;

    public ?int $number = null;

    public ?int $order_id = null;

    public bool $isCreating = false;

    // Options list
    public Collection|array $partsSearchable = [];

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'order_id' => 'nullable',
        ];

        if ($this->isCreating) {
            $rules = array_merge($rules, [
                'part_id' => 'required|numeric|exists:parts,id',
                'number' => 'required|numeric|min:0|max:1000000|not_in:0'
            ]);
        }

        return $rules;
    }

    /**
     * Translated attribute used in failed messages.
     *
     * @return array
     */
    public function validationAttributes(): array
    {
        return [
            'part_id' => 'pièce détachée',
            'number' => 'nombre de pièce',
            'order_id' => 'N° de commande'
        ];
    }

    public function setPartEntry(PartEntry $partEntry): void
    {
        $this->fill([
            'partEntry' => $partEntry,
            'number' => $partEntry->number,
            'order_id' => $partEntry->order_id
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return PartEntry
     */
    public function store(): PartEntry
    {
        return PartEntry::create($this->only([
            'part_id',
            'number',
            'order_id'
        ]));
    }

    /**
     * Function to update the model.
     *
     * @return PartEntry
     */
    public function update(): PartEntry
    {
        return tap($this->partEntry)->update($this->only([
            'order_id'
        ]));
    }
}