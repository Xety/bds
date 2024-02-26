<?php

namespace BDS\Livewire;

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

    /**
     * The events listeners fo Livewire.
     *
     * @var string[]
     */
    protected $listeners = [
        'eventAdd' => 'eventAdd',
        'eventDestroy' => 'eventDestroy'
    ];

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
     * The model used in the component.
     *
     * @var Calendar
     */
    public Calendar $model;

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
            'model.title' => 'required',
            'model.allDay' => 'required|boolean',
            'type' => 'required|in:' . collect(Calendar::EVENTS_TYPES)->keys()->implode(','),
            'started_at' => 'exclude_if:model.allDay,true|date_format:"d-m-Y H:i"|required',
            'ended_at' => 'exclude_if:model.allDay,true|date_format:"d-m-Y H:i"|required',
        ];
    }

    /**
     * Create a blank model and return it.
     *
     * @return Calendar
     */
    public function makeBlankModel(): Calendar
    {
        return Calendar::make();
    }

    /**
     * The Livewire Component constructor.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->model = $this->makeBlankModel();
    }

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        $events = Calendar::all()->map(function ($array) {
            if ($array['allDay']) {
                $array['start'] = Carbon::parse($array['started'])->format('Y-m-d');
                $array['end'] = is_null($array['ended']) ? null : Carbon::parse($array['ended'])->format('Y-m-d');
            } else {
                $array['start'] = Carbon::parse($array['started'])->toIso8601String();
                $array['end'] = Carbon::parse($array['ended'])->toIso8601String();
            }
            unset($array['started']);
            unset($array['ended']);
            unset($array['user_id']);

            return $array;
        });

        $this->events = json_encode($events);

        return view('livewire.calendars');
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
        $this->authorize('delete', Calendar::class);

        Calendar::destroy($this->deleteInfo['id']);
        $this->showDeleteModal = false;
        $this->emit('evenDestroySuccess', $this->deleteInfo['id']);
        $this->deleteInfo = [];
        session()->flash('success', "Cet évènement a été supprimé avec succès !");
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
        $this->model->allDay = true;

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

        $this->model->id = Str::uuid();
        $this->model->started = Carbon::createFromFormat('d-m-Y H:i', $this->started_at);
        $this->model->ended = Carbon::createFromFormat('d-m-Y H:i', $this->ended_at);
        $this->model->color = Calendar::EVENTS_TYPES[$this->type]['color'];

        if ($this->model->save()) {
            $array = $this->model->toArray();

            if ($array['allDay']) {
                $array['started'] = $this->model->started->format('Y-m-d');
                $array['ended'] = $this->model->ended->format('Y-m-d');
            } else {
                $array['started'] = $this->model->started->toIso8601String();
                $array['ended'] = $this->model->ended->toIso8601String();
            }
            $this->emit('evenAddSuccess', $array);

            $this->model = $this->makeBlankModel();
            session()->flash('success', "Cet évènement a été créée avec succès !");
        } else {
            session()->flash('danger', "Une erreur s'est produite lors de la création de l'évènement !");
        }
        $this->showModal = false;
    }
}
