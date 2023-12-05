<?php
namespace BDS\Models\Validators;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class SettingValidator
{
    /**
     * Validate the sites for the given request.
     *
     * @param array $data The data to validate.
     *
     * @return Validator
     */
    public static function validateSites(array $data): Validator
    {
        $rules = [
            // All sites
            'zone_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'material_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'incident_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'maintenance_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'cleaning_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'part_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],

            // SELVAH
            'production_objective_delivered' => 'integer',
            'production_objective_todo' => 'integer',
        ];

        return FacadeValidator::make($data, $rules);
    }

    /**
     * Validate the generals for the given request.
     *
     * @param array $data The data to validate.
     *
     * @return Validator
     */
    public static function validateGenerals(array $data): Validator
    {
        $rules = [
            'app_login_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'site_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'zone_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'material_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'incident_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'maintenance_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'cleaning_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'part_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
        ];

        return FacadeValidator::make($data, $rules);
    }
}
