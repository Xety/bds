<?php

namespace BDS\Livewire\Forms;

use BDS\Models\Company;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CompanyForm extends Form
{
    public ?Company $company;

    public ?string $name = null;

    public ?string $description = null;

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
                "min:1",
                "max:150",
                Rule::unique('companies')->where(fn ($query) => $query->where('site_id', getPermissionsTeamId())),
            ],
            'description' => 'nullable',
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
            'description' => 'description'
        ];
    }

    /**
     * Set the model and all his fields.
     *
     * @param Company $company
     *
     * @return void
     */
    public function setForm(Company $company): void
    {
        $this->fill([
            'company' => $company,
            'name' => $company->name,
            'description' => $company->description
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return Company
     */
    public function store(): Company
    {
        return Company::create($this->only([
            'name',
            'description'
        ]));
    }

    /**
     * Function to update the model and return it after.
     *
     * @return Company
     */
    public function update(): Company
    {
        return tap($this->company)->update($this->only([
            'name',
            'description'
        ]));
    }
}
