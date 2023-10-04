<?php

namespace BDS\Livewire\Traits;

trait WithFlash
{
    /**
     * Display a flash message regarding the action that fire it and the type of the message, then emit an
     * `alert ` event.
     *
     * @param string $action The action that fire the flash message. Use `custom` for using custom message.
     * @param string $type The type of the message, success or danger.
     * @param string $message The custom message for the flash message.
     * @param array $replaces The values to replace in the flash message.
     *
     * @return void
     */
    public function fireFlash(string $action, string $type, string $message = '', array $replaces = []): void
    {
        if (array_key_exists($action, $this->flashMessages)) {
            session()->flash($type, empty($replaces) ? $this->flashMessages[$action][$type] : vsprintf($this->flashMessages[$action][$type], $replaces));
        } else {
            session()->flash($type, vsprintf($message, $replaces));
        }

        // Emit the alert event to the front so the Dismiss can trigger the flash message.
        $this->dispatch('alert');
    }
}
