<?php

namespace BDS\Livewire\Forms;

use BDS\Models\CalendarEvent;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CalendarEventForm extends Form
{
    public ?CalendarEvent $calendarEvent;

    public ?string $name = null;

    public ?string $color = null;

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
                "min:1",
                "max:150",
                Rule::unique('calendar_events')->where(fn ($query) => $query->where('site_id', getPermissionsTeamId())),
            ],
            'color' => 'required|min:7|max:7',
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
            'color' => 'couleur'
        ];
    }

    /**
     * Set the model and all his fields.
     *
     * @param CalendarEvent $calendarEvent
     *
     * @return void
     */
    public function setForm(CalendarEvent $calendarEvent): void
    {
        $this->fill([
            'calendarEvent' => $calendarEvent,
            'name' => $calendarEvent->name,
            'color' => $calendarEvent->color
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return CalendarEvent
     */
    public function store(): CalendarEvent
    {
        return CalendarEvent::create($this->only([
            'name',
            'color'
        ]));
    }

    /**
     * Function to update the model and return it after.
     *
     * @return CalendarEvent
     */
    public function update(): CalendarEvent
    {
        return tap($this->calendarEvent)->update($this->only([
            'name',
            'color'
        ]));
    }
}
