<?php

namespace BDS\Livewire\Forms;

use BDS\Models\Material;
use BDS\Models\Part;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Form;

class PartForm extends Form
{
    public ?Part $part = null;

    public ?string $name = null;

    public ?string $description = null;

    public ?string $reference = null;

    public ?int $supplier_id = null;

    public ?float $price = 0.00;

    public ?bool $number_warning_enabled = false;

    public ?int $number_warning_minimum = 0;

    public ?bool $number_critical_enabled = false;

    public ?int $number_critical_minimum = 0;

    // Options list
    public Collection|array $materialsMultiSearchable = [];

    public Collection|array $recipientsMultiSearchable = [];

    /**
     * Selected materials ids
     *
     * @var array
     */
    public array $materials = [];

    /**
     * Selected recipients ids
     *
     * @var array
     */
    public array $recipients = [];

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
                Rule::unique('parts')->ignore($this->part?->id)->where(fn ($query) => $query->where('site_id', getPermissionsTeamId()))
            ],
            'description' => 'required|min:3',
            'reference' => [
                'min:1',
                'max:30',
                Rule::unique('parts')->ignore($this->part?->id)->where(fn ($query) => $query->where('site_id', getPermissionsTeamId()))
            ],
            'supplier_id' => [
                'required',
                'numeric',
                Rule::exists('suppliers', 'id')->where(fn ($query) => $query->where('site_id', getPermissionsTeamId()))
            ],
            'materials' => [
                'required',
                'nullable',
                Rule::exists('materials', 'id')
            ],
            'recipients' => [
                Rule::excludeIf(function () {
                    return !($this->number_warning_enabled || $this->number_critical_enabled);
                }),
                'required',
                Rule::exists('users', 'id')
            ],
            'price' => 'required|min:0|numeric',
            'number_warning_enabled' => 'required|boolean',
            'number_warning_minimum' => 'exclude_if:number_warning_enabled,false|required|numeric',
            'number_critical_enabled' => 'required|boolean',
            'number_critical_minimum' => 'exclude_if:number_critical_enabled,false|required|numeric',
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
            'description' => 'description',
            'reference' => 'référence',
            'supplier_id' => 'fournisseur',
            'materials' => 'matériels',
            'recipients' => 'destinataires',
            'price' => 'prix',
            'number_warning_enabled' => 'alerte de stock',
            'number_warning_minimum' => 'quantité pour l\'alerte',
            'number_critical_enabled' => 'alerte de stock critique',
            'number_critical_minimum' => 'quantité pour l\'alerte critique',
        ];
    }

    public function setPart(Part $part, array $materials, array $recipients): void
    {
        $this->fill([
            'part' => $part,
            'materials' => $materials,
            'recipients' => $recipients,
            'name' => $part->name,
            'description' => $part->description,
            'reference' => $part->reference,
            'supplier_id' => $part->supplier_id,
            'price' => $part->price,
            'number_warning_enabled' => $part->number_warning_enabled,
            'number_warning_minimum' => $part->number_warning_minimum,
            'number_critical_enabled' => $part->number_critical_enabled,
            'number_critical_minimum' => $part->number_critical_minimum
        ]);
    }

    /**
     *
     * Function to store the model.
     *
     * @return Part
     */
    public function store(): Part
    {
        $part = Part::create($this->only([
            'name',
            'description',
            'reference',
            'supplier_id',
            'price',
            'number_warning_enabled',
            'number_warning_minimum',
            'number_critical_enabled',
            'number_critical_minimum',
        ]));

        $part->materials()->sync($this->materials);
        $part->recipients()->sync($this->recipients);

        return $part;
    }

    /**
     * Function to update the model.
     *
     * @return Part
     */
    public function update(): Part
    {
        $part = tap($this->part)->update($this->only([
            'name',
            'description',
            'reference',
            'supplier_id',
            'price',
            'number_warning_enabled',
            'number_warning_minimum',
            'number_critical_enabled',
            'number_critical_minimum',
        ]));

        $part->materials()->sync($this->materials);
        $part->recipients()->sync($this->recipients);

        return $part;
    }
}
