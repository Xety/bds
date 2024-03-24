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
use Livewire\Attributes\On;
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
    public bool $showOptionModal = false;

    /**
     * The information of the event to delete.
     *
     * @var array
     */
    public array $eventInfo = [];

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
            $calendar->eventName = $calendar->calendarEvent->name;
            $calendar->icon = collect(Calendar::STATUS)->sole('id', $calendar->status)['icon'];
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
    #[On('event-change')]
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
    #[On('event-option')]
    public function eventOption(array $event): void
    {
        $this->eventInfo = $event;
        $this->showOptionModal = true;
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
        $event = Calendar::find($this->eventInfo['id']);
        $this->authorize('delete', $event);

        Calendar::destroy($this->eventInfo['id']);
        $this->showOptionModal = false;
        $this->dispatch('even-destroy-success', $this->eventInfo['id']);
        $this->reset('eventInfo');

        $this->success("Cet évènement a été supprimé avec succès !");

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($event)
                ->event('deleted')
                ->withProperties(['attributes' => $event->toArray()])
                ->log('L\'utilisateur :causer.full_name à supprimé l\'évènement :subject.title.');
        }
    }

    /**
     * Function to change the status of an event.
     *
     * @param string $status The new status.
     *
     * @return void
     */
    public function changeStatus(string $status): void
    {
        $this->authorize('update', Calendar::class);

        $calendar = Calendar::with('calendarEvent')->find($this->eventInfo['id']);

        // Get the old data before updating it.
        $activityLog['old'] = $calendar->toArray();

        $calendar->status = $status;
        $calendar->save();

        $this->showOptionModal = false;
        $this->reset('eventInfo');

        $calendar->color = $calendar->calendarEvent->color;
        $calendar->eventName = $calendar->calendarEvent->name;
        $calendar->icon = collect(Calendar::STATUS)->sole('id', $calendar->status)['icon'];

        $array = $calendar->toArray();

        if ($array['allDay']) {
            $array['started'] = $calendar->started->format('Y-m-d');
            $array['ended'] = $calendar->ended->format('Y-m-d');
        } else {
            $array['started'] = $calendar->started->toIso8601String();
            $array['ended'] = $calendar->ended->toIso8601String();
        }

        $this->dispatch('even-change-status-success', $array);

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($calendar)
                ->event('updated')
                ->withProperties(['old' => $activityLog['old'], 'attributes' => $calendar->toArray()])
                ->log('L\'utilisateur :causer.full_name à mis à jour le statut de l\'évènement :subject.title à ' . collect(Calendar::STATUS)->sole('id', $calendar->status)['name'] . '.');
        }
    }

    /**
     * Function triggered when a user clicked on the calendar to add an event.
     *
     * @param array $event The default event information, used to get the start and end date by default.
     *
     * @return void
     */
    #[On('event-create')]
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
        $calendarEvent = CalendarEvent::find($this->calendar_event_id);

        $calendar->id = Str::uuid();
        $calendar->title = $this->title;
        $calendar->calendar_event_id = $this->calendar_event_id;
        $calendar->allDay = $this->allDay;
        $calendar->started = Carbon::createFromFormat('d-m-Y H:i', $this->started_at);
        $calendar->ended = Carbon::createFromFormat('d-m-Y H:i', $this->ended_at);
        $calendar->color = $calendarEvent->color;

        if ($calendar->save()) {
            $calendar->eventName = $calendarEvent->name;
            $calendar->status = 'incoming';
            $calendar->icon = collect(Calendar::STATUS)->sole('id', 'incoming')['icon'];

            $array = $calendar->toArray();

            if ($array['allDay']) {
                $array['started'] = $calendar->started->format('Y-m-d');
                $array['ended'] = $calendar->ended->format('Y-m-d');
            } else {
                $array['started'] = $calendar->started->toIso8601String();
                $array['ended'] = $calendar->ended->toIso8601String();
            }
            $this->dispatch('even-add-success', $array);

            $this->reset('title', 'calendar_event_id', 'allDay', 'started_at', 'ended_at');

            $this->success("Cet évènement a été créé avec succès !");

            // Log Activity
            if (settings('activity_log_enabled', true)) {
                activity()
                    ->performedOn($calendar)
                    ->event('created')
                    ->withProperties(['attributes' => $calendar->toArray()])
                    ->log('L\'utilisateur :causer.full_name à créé l\'évènement :subject.title.');
            }
        } else {
            $this->error("Une erreur s'est produite lors de la création de l'évènement !");
        }
        $this->showModal = false;
    }
}
