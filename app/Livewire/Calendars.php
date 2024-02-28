<?php

namespace BDS\Livewire;

use BDS\Livewire\Traits\WithToast;
use BDS\Models\CalendarEvent;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;
use BDS\Models\Calendar;

class Calendars extends Component
{
    use AuthorizesRequests;
    use WithToast;

    public ?int $calendar_event_id = null;

    public ?string $title = null;

    public ?bool $allDay = true;

    public ?string $started = null;

    public ?string $ended = null;


    /**
     * All the events of the calendar.
     *
     * @var string
     */
    public string $events = '';

    /**
     * Used to show the create modal.
     *
     * @var bool
     */
    public bool $showModal = false;

    /**
     * Used to show the delete modal.
     *
     * @var bool
     */
    public bool $showDeleteModal = false;

    /**
     * The information of the event to delete.
     *
     * @var array
     */
    public array $deleteInfo = [];

    /**
     * The date when the event started.
     *
     * @var string
     */
    public string $started_at = '';

    /**
     * The date when the event ended.
     *
     * @var string
     */
    public string $ended_at = '';

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'allDay' => 'required|boolean',
            'calendar_event_id' => 'required|exists:calendar_events,id',
            'started_at' => 'exclude_if:allDay,true|date_format:"d-m-Y H:i"|required',
            'ended_at' => 'exclude_if:allDay,true|date_format:"d-m-Y H:i"|required',
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
            'title' => 'titre',
            'calendar_event_id' => 'type d\'évènement',
            'allDay' => 'toute la journée',
            'started_at' => 'début de l\'évènement',
            'ended_at' => 'fin de l\'évènement'
        ];
    }

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        $events = Calendar::query()
            ->with('calendarEvent')
            ->where('site_id', getPermissionsTeamId())
            ->get()
            ->map(function (Calendar $calendar) {
            if ($calendar->allDay) {
                $calendar->start = Carbon::parse($calendar->started)->format('Y-m-d');
                $calendar->end = is_null($calendar->ended) ? null : Carbon::parse($calendar->ended)->format('Y-m-d');
            } else {
                $calendar->start = Carbon::parse($calendar->started)->toIso8601String();
                $calendar->end = Carbon::parse($calendar->ended)->toIso8601String();
            }
            unset($calendar->started, $calendar->ended, $calendar->user_id);

            // Replace the color by the color event type.
            $calendar->color = $calendar->calendarEvent->color;
            unset($calendar->calendarEvent, $calendar->calendar_event_id);

            return $calendar;
        });

        $this->events = json_encode($events);

        $calendarEvents = CalendarEvent::query()
            ->where('site_id', getPermissionsTeamId())
            ->select(['id', 'name', 'color'])
            ->orderBy('name')
            ->get()
            ->toArray();

        return view('livewire.calendars', compact('calendarEvents'));
    }

    /**
     * Function triggered when an event has been Resize/Drop(Move).
     *
     * @param array $event The event information that has been changed.
     *
     * @return void
     */
    public function eventChange(array $event): void
    {
        $e = Calendar::find($event['id']);
        $e->started = Carbon::parse($event['start'])->format('d-m-Y H:i');

        // The user switch a not allDay with a start date to an allDay event.
        if ($e->started->format('H:i') == '00:00') {
            $e->allDay = true;
        }

        // The user switched an allDay event to as event with a start/end date.
        if ($e->started->format('H:i') != '00:00' && !Arr::exists($event, 'end')) {
            $e->allDay = false;
            $e->ended = $e->started->addHours(1)->format('d-m-Y H:i');
        }

        // The user modified the end date, happened when resize and Event.
        if (Arr::exists($event, 'end')) {
            $e->ended = Carbon::parse($event['end'])->format('d-m-Y H:i');
        }
        $e->save();
    }

    /**
     * Function triggered when a user clicked on an event.
     *
     * @param array $event The event that has been deleted.
     *
     * @return void
     */
    public function eventDestroy(array $event): void
    {
        $this->deleteInfo = $event;
        $this->showDeleteModal = true;
    }

    /**
     * Function to destroy and event after a confirmation.
     *
     * @return void
     *
     * @throws AuthorizationException
     */
    public function destroy(): void
    {
        $event = Calendar::find($this->deleteInfo['id']);
        $this->authorize('delete', $event);

        Calendar::destroy($this->deleteInfo['id']);
        $this->showDeleteModal = false;
        $this->dispatch('even-destroy-success', $this->deleteInfo['id']);
        $this->deleteInfo = [];

        $this->success("Cet évènement a été supprimé avec succès !");
    }

    /**
     * Function triggered when a user clicked on the calendar to add an event.
     *
     * @param array $event The default event information, used to get the start and end date by default.
     *
     * @return void
     */
    public function eventAdd(array $event): void
    {
        $this->started_at = Carbon::parse($event['startStr'])->format('d-m-Y H:i');
        $this->ended_at = isset($event['endStr']) ? Carbon::parse($event['endStr'])->format('d-m-Y H:i') : null;
        $this->allDay = true;

        $this->showModal = true;
    }

    /**
     * Function to create an event.
     *
     * @return void
     *
     * @throws AuthorizationException
     */
    public function save(): void
    {
        $this->authorize('create', Calendar::class);

        $this->validate();

        $calendar = new Calendar;

        $calendar->id = Str::uuid();
        $calendar->title = $this->title;
        $calendar->calendar_event_id = $this->calendar_event_id;
        $calendar->allDay = $this->allDay;
        $calendar->started = Carbon::createFromFormat('d-m-Y H:i', $this->started_at);
        $calendar->ended = Carbon::createFromFormat('d-m-Y H:i', $this->ended_at);

        if ($calendar->save()) {
            $array = $calendar->toArray();

            if ($array['allDay']) {
                $array['started'] = $calendar->started->format('Y-m-d');
                $array['ended'] = $calendar->ended->format('Y-m-d');
            } else {
                $array['started'] = $calendar->started->toIso8601String();
                $array['ended'] = $calendar->ended->toIso8601String();
            }
            $this->dispatch('evenAddSuccess', $array);

            $this->reset('title', 'calendar_event_id', 'allDay', 'started_at', 'ended_at');

            $this->success("Cet évènement a été créée avec succès !");
        } else {
            $this->error("Une erreur s'est produite lors de la création de l'évènement !");
        }
        $this->showModal = false;
    }
}
