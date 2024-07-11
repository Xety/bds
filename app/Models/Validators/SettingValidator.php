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
            // Zone
            'zone_manage_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'zone_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],

            // Material
            'material_manage_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'material_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],

            // Incident
            'incident_manage_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'incident_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],

            // Maintenance
            'maintenance_manage_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'maintenance_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],

            // Cleaning
            'cleaning_manage_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'cleaning_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],

            // Part
            'part_manage_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'part_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],

            //Part Entry
            'part_entry_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            //Part Exit
            'part_exit_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],

            // User
            'user_manage_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'user_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],

            // Supplier
            'supplier_manage_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'supplier_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],

            // Company
            'company_manage_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'company_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],

            // Calendar
            'calendar_manage_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'calendar_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],

            // Calendar Event
            'calendar_event_manage_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'calendar_event_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
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

            // Site
            'site_manage_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'site_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],

            // Role
            'role_manage_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'role_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],

            // Permission
            'permission_manage_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],
            'permission_create_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ],

            // Selvah Correspondance Sheets
            'selvah_correspondence_sheet_manage_enabled' => [
                Rule::in([0, 1, "0", "1", true, false, "on", "true", "false", null]),
            ]
        ];

        return FacadeValidator::make($data, $rules);
    }
}
