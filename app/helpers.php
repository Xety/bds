<?php

use BDS\Settings\Settings;
use Eloquence\Database\Model;

if (! function_exists('settings')) {
    function settings($key = null, $siteId = null, $context = null)
    {
        $settings = app(Settings::class);

        // If nothing is passed in to the function, simply return the settings instance.
        if ($key === null) {
            return $settings;
        }

        // Set the siteId
        $settings->setSiteId($siteId);

        if ($siteId === true) {
            $settings->setSiteId(session('current_site_id'));
        }

        // We must reset the context to the default value.
        $settings->setContext([
            'model_type' => null,
            'model_id' => null
        ]);

        // If context is not null, set it.
        if ($context instanceof Model || is_array($context)) {
            $settings->setContext($context);
        }

        return $settings->get(key: $key);
    }
}
