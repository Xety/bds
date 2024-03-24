<?php

namespace BDS\Livewire\Forms;

use Livewire\Form;
use BDS\Models\Site;

class SiteForm extends Form
{
    public ?Site $site = null;

    public ?string $name = null;

    public ?string $email = null;

    public ?string $office_phone = null;

    public ?string $cell_phone = null;

    public ?string $address = null;

    public ?string $zip_code = null;

    public ?string $city = null;

    public array $managers = [];

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|min:2|max:150|unique:sites,name,' . $this->site?->id,
            'email' => 'nullable|email',
            'office_phone' => 'nullable',
            'cell_phone' => 'nullable',
            'address' => 'nullable',
            'zip_code' => 'nullable|numeric',
            'city' => 'nullable',
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
            'email' => 'email',
            'office_phone' => 'téléphone bureau',
            'cell_phone' => 'téléphone portable',
            'address' => 'adresse',
            'zip_code' => 'code postal',
            'city' => 'ville',
            'managers' => 'responsables'
        ];
    }

    public function setSite(Site $site, array $managers): void
    {
        $this->fill([
            'site' => $site,
            'managers' => $managers,
            'name' => $site->name,
            'email' => $site->email,
            'office_phone' => $site->office_phone,
            'cell_phone' => $site->cell_phone,
            'address' => $site->address,
            'zip_code' => $site->zip_code,
            'city' => $site->city,
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return Site
     */
    public function store(): Site
    {
        $site = Site::create($this->only([
            'name',
            'email',
            'office_phone',
            'cell_phone',
            'address',
            'zip_code',
            'city'
        ]));

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($site)
                ->event('created')
                ->withProperties(['attributes' => $site->toArray()])
                ->log('L\'utilisateur :causer.full_name à créé le site :subject.name.');
        }

        return $site;
    }

    /**
     * Function to update the model.
     *
     * @return Site
     */
    public function update(): Site
    {
        // Get the old data before tap it.
        $activityLog['old'] = $this->site->toArray();

        $site = tap($this->site)->update($this->only([
            'name',
            'email',
            'office_phone',
            'cell_phone',
            'address',
            'zip_code',
            'city'
        ]));

        $collect =  $site->managers()->allRelatedIds();
        $diff = $collect->diff($this->managers);

        $site->managers()->updateExistingPivot($diff, ['manager' => false]);
        $site->managers()->updateExistingPivot($this->managers, ['manager' => true]);

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($site)
                ->event('updated')
                ->withProperties(['old' => $activityLog['old'], 'attributes' => $site->toArray()])
                ->log('L\'utilisateur :causer.full_name à mis à jour le site :subject.name.');
        }

        return $site;
    }
}
