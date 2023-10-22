<?php

namespace BDS\Models\Repositories;

use BDS\Models\Session;
use BDS\Models\Setting;

class SettingRepository
{
    /**
     * Update the user's email after a valid email update.
     *
     * @param array $settings The user to update.
     *
     * @return bool
     */
    public static function update(array $settings, string $type): bool
    {
        if (empty($settings)) {
            return true;
        }

        foreach ($settings as $key => $value) {
            if ($type === "sites") {
                $setting = Setting::where('key', $key)
                    ->where('site_id', session('current_site_id'))
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

            if (is_bool($setting->value)) {
                $value = (bool)$value;
            } elseif (is_int($setting->value)) {
                $value = (int)$value;
            } elseif (is_float($setting->value)) {
                $value = (float)$value;
            } else {
                $value = (string)$value;
            }

            $setting->value = $value;
            $saved = $setting->save();

            if ($saved === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Update the user's email after a valid email update.
     *
     * @param array $data The data used to update the user.
     * @param array $settings The user to update.
     *
     * @return bool
     */
    public static function updateGenerals(array $data, $settings): bool
    {
        $user->email = $data['email'];

        return $user->save();
    }
}
