<?php

namespace BDS\Livewire\Traits;

use Masmerise\Toaster\Toastable;

trait WithToast
{
    use Toastable;

    /**
     * Display a toast message regarding the action that fire it and the type of the message.
     *
     * @param string $action The action that fire the flash message. Use `custom` for using custom message.
     * @param string $type The type of the message, success or danger.
     * @param string $message The custom message for the flash message.
     * @param array $replaces The values to replace in the flash message.
     *
     * @return void
     */
    public function fireToast(string $action, string $type, string $message = '', array $replaces = []): void
    {
        if (array_key_exists($action, $this->flashMessages)) {
            $this->{$type}(empty($replaces) ? $this->flashMessages[$action][$type] : vsprintf($this->flashMessages[$action][$type], $replaces));
        } else {
            $this->{$type}($message, $replaces);
        }
    }
}
