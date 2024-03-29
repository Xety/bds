<?php

namespace BDS\Livewire\Forms;

use BDS\Models\Material;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Form;

class MaterialForm extends Form
{
    public ?Material $material = null;

    public ?string $name = null;

    public ?string $description = null;

    public ?int $zone_id = null;

    public ?bool $cleaning_alert = false;

    public ?bool $cleaning_alert_email = false;

    public ?int $cleaning_alert_frequency_repeatedly = 1;

    public ?string $cleaning_alert_frequency_type = 'daily';

    public ?bool $selvah_cleaning_test_ph_enabled = false;

    /**
     * Selected recipients ids
     *
     * @var array
     */
    public array $recipients = [];

    // Options list
    public Collection|array $recipientsMultiSearchable = [];

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
                Rule::unique('materials')
                    ->ignore($this->material?->id)
                    ->where(fn ($query) => $query->where('zone_id', $this->zone_id)),
            ],
            'description' => 'required|min:3',
            'zone_id' => 'required|exists:zones,id',
            'recipients' => [
                'exclude_if:cleaning_alert,false',
                'required',
                Rule::exists('users', 'id')
            ],
            'selvah_cleaning_test_ph_enabled' => 'required|boolean',
            'cleaning_alert' => 'required|boolean',
            'cleaning_alert_email' => 'exclude_if:cleaning_alert,false|boolean|required',
            'cleaning_alert_frequency_repeatedly' => 'exclude_if:cleaning_alert,false|numeric|between:1,365|required',
            'cleaning_alert_frequency_type' => 'exclude_if:cleaning_alert,false|in:' . collect(Material::CLEANING_TYPES)->map(function ($item) {
                    return $item['id'];
                })->sort()->values()->implode(',') . '|required',
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
            'zone_id' => 'zone',
            'recipients' => 'destinataires',
            'selvah_cleaning_test_ph_enabled' => 'test de PH',
            'cleaning_alert' => 'alerte de nettoyage',
            'cleaning_alert_email' => 'alerte de nettoyage par email',
            'cleaning_alert_frequency_repeatedly' => 'fréquence de nettoyage',
            'cleaning_alert_frequency_type' => 'type de nettoyage'
        ];
    }

    public function setMaterial(Material $material, array $recipients): void
    {
        $this->fill([
            'material' => $material,
            'recipients' => $recipients,
            'name' => $material->name,
            'description' => $material->description,
            'zone_id' => $material->zone_id,
            'selvah_cleaning_test_ph_enabled' => $material->selvah_cleaning_test_ph_enabled,
            'cleaning_alert' => $material->cleaning_alert,
            'cleaning_alert_email' => $material->cleaning_alert_email,
            'cleaning_alert_frequency_repeatedly' => $material->cleaning_alert_frequency_repeatedly,
            'cleaning_alert_frequency_type' => $material->cleaning_alert_frequency_type
        ]);

        // Selvah
        if (getPermissionsTeamId() == settings('site_id_selvah')) {
            $this->fill([
                'selvah_cleaning_test_ph_enabled' => $material->selvah_cleaning_test_ph_enabled
            ]);
        }
    }

    /**
     *
     * Function to store the model.
     *
     * @return Material
     */
    public function store(): Material
    {
        $data = [
            'name',
            'description',
            'zone_id',
            'cleaning_alert',
            'cleaning_alert_email',
            'cleaning_alert_frequency_repeatedly',
            'cleaning_alert_frequency_type'
        ];

        // Selvah
        if (getPermissionsTeamId() == settings('site_id_selvah')) {
            $data[] = 'selvah_cleaning_test_ph_enabled';
        }

        $material = Material::create($this->only($data));

        $material->recipients()->sync($this->recipients);

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($material)
                ->event('created')
                ->withProperties(['attributes' => $material->toArray()])
                ->log('L\'utilisateur :causer.full_name à créé le matériel :subject.name.');
        }

        return $material;
    }

    /**
     * Function to update the model.
     *
     * @return Material
     */
    public function update(): Material
    {
        // Get the old data before tap it.
        $activityLog['old'] = $this->material->toArray();

        $data = [
            'name',
            'description',
            'zone_id',
            'cleaning_alert',
            'cleaning_alert_email',
            'cleaning_alert_frequency_repeatedly',
            'cleaning_alert_frequency_type'
        ];

        // Selvah
        if (getPermissionsTeamId() == settings('site_id_selvah')) {
            $data[] = 'selvah_cleaning_test_ph_enabled';
        }

        $material = tap($this->material)->update($this->only($data));
        $material->recipients()->sync($this->recipients);

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($material)
                ->event('updated')
                ->withProperties(['old' => $activityLog['old'], 'attributes' => $material->toArray()])
                ->log('L\'utilisateur :causer.full_name à mis à jour le matériel :subject.name.');
        }

        return $material;
    }
}
