<?php
namespace BDS\Models\Repositories;

use BDS\Models\Setting;
use BDS\Settings\Settings;

class SettingRepository
{
    /**
     * Update the user's email after a valid email update.
     *
     * @param Settings $settingClass
     * @param array $settings The settings to update.
     * @param string $type The type of the setting
     *
     * @return bool
     */
    public static function update(Settings $settingClass, array $settings, string $type): bool
    {
        if (empty($settings)) {
            return true;
        }

        foreach ($settings as $key => $value) {
            if ($type === "sites") {
                $setting = Setting::where('key', $key)
                    ->where('site_id', session('current_site_id'))
                    ->whereNull('model_type')
                    ->whereNull('model_id')
                    ->first();
            } elseif ($type === "generals") {
                $setting = Setting::where('key', $key)
                    ->whereNull('site_id')
                    ->whereNull('model_type')
                    ->whereNull('model_id')
                    ->first();
            } else {
                break;
            }

            if (is_null($setting)) {
                continue;
            }

            // Cast the value the same as the old value to not change the type
            if (is_bool($setting->value)) {
                $value = (bool)$value;
            } elseif (is_int($setting->value)) {
                $value = (int)$value;
            } elseif (is_float($setting->value)) {
                $value = (float)$value;
            } else {
                $value = (string)$value;
            }

            // Assign the new value dans save it.
            $setting->value = $value;
            $saved = $setting->save();

            // If the save fail, return directly.
            if ($saved === false) {
                return false;
            }

            // Delete the cache related to the setting
            if ($type === "sites") {
                $settingClass->setSiteId(session('current_site_id'))
                    ->withoutContext()
                    ->remove($key);
            } elseif ($type === "generals") {
                $settingClass->setSiteId(null)
                    ->withoutContext()
                    ->remove($key);
            }
        }

        return true;
    }
}
