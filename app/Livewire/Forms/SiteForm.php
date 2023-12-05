<?php

namespace BDS\Livewire\Forms;

use Livewire\Form;
use BDS\Models\Site;

class SiteForm extends Form
{
    public ?Site $site = null;

    public ?string $name = null;

    public array $managers = [];

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|min:2|max:150|unique:sites,name,' . $this->site?->id
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
            'managers' => 'responsables'
        ];
    }

    public function setSite(Site $site, array $managers): void
    {
        $this->fill([
            'site' => $site,
            'managers' => $managers,
            'name' => $site->name
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return Site
     */
    public function store(): Site
    {
        return Site::create($this->only([
            'name'
        ]));
    }

    /**
     * Function to update the model.
     *
     * @return Site
     */
    public function update(): Site
    {
        $site = tap($this->site)->update($this->only([
            'name'
        ]));

        $collect =  $site->managers()->allRelatedIds();
        $diff = $collect->diff($this->managers);

        $site->managers()->updateExistingPivot($diff, ['manager' => false]);
        $site->managers()->updateExistingPivot($this->managers, ['manager' => true]);

        return $site;
    }
}
