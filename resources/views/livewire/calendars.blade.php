<div>
    <div>
        <div class="grid grid-cols-12 gap-6 overflow-x-auto" id='calendar-container' wire:ignore>
            <div class="col-span-12 max-h-[900px]" id='calendar'></div>
        </div>
    </div>

    <div>
        <!-- Create Modal -->
        <x-modal wire:model="showModal" title="Créer un Évènement">
            <x-input wire:model="title" name="title" label="Titre" placeholder="Titre de l'évènement..." type="text" />

            @php $message = "Sélectionner le type d'évènement.";@endphp
            <x-select
                :options="$calendarEvents"
                icon="fas-flag"
                class="select-primary"
                wire:model="calendar_event_id"
                name="calendar_event_id"
                label="Type d'évènement"
                :label-info="$message"
                placeholder="Sélectionnez le type"
            />

            <x-checkbox wire:model.live="allDay" name="allDay" label="Toute la journée ?" text="Cochez si l'évènement dure toute la journée" />

            @if (!$allDay)
                @php $message = "Date et heure de commencement de l'évènement.";@endphp
                <x-date-picker wire:model="started_at" name="started_at" icon="fas-calendar" icon-class="h-4 w-4" label="Début de l'évènement" placeholder="Début.." />
                <x-date-picker wire:model="ended_at" name="ended_at" icon="fas-calendar" icon-class="h-4 w-4" label="Fin de l'évènement" placeholder="Début.." />
            @endif
            <x-slot:actions>
                <x-button class="btn btn-success gap-2" type="button" wire:click="save" spinner>
                    <x-icon name="fas-plus" class="h-5 w-5"></x-icon> Créer
                </x-button>
                <x-button @click="$wire.showModal = false" class="btn btn-neutral">
                    Fermer
                </x-button>
            </x-slot:actions>
        </x-modal>

        <!-- Option Modal -->
        <x-modal wire:model="showOptionModal" title="Gérer l'Évènement">
            <div class="border-l-[6px] pl-4" style="{{  isset($deleteInfo['backgroundColor']) ? 'border-color:' . $deleteInfo['backgroundColor'] : '' }}">
                <h2 class="font-bold text-2xl">
                    {{  isset($deleteInfo['title']) ? $deleteInfo['title'] : '' }}
                </h2>
                <div>
                    <span class="font-bold">
                        {{ isset($deleteInfo['start']) ? \Carbon\Carbon::parse($deleteInfo['start'])->format('d-m-Y H:i') : '' }}
                    </span>
                    <span class="font-bold">
                      {{ isset($deleteInfo['end']) ? ' - ' . \Carbon\Carbon::parse($deleteInfo['end'])->format('d-m-Y H:i') : '' }}
                    </span>
                </div>
                @if(isset($deleteInfo['allDay']) && $deleteInfo['allDay'] == true)
                    <div class="flex items-center">
                        <x-icon class="w-5 h-5 inline mr-2" name="fas-calendar-alt"></x-icon> Toute la journée
                    </div>
                @endif

                @if(isset($deleteInfo['extendedProps']) && isset($deleteInfo['extendedProps']['eventName']))
                    <sapn class="flex items-center font-bold tooltip tooltip-top" data-tip="Type de l'évènement">
                        <x-icon class="w-5 h-5 inline mr-2" name="fas-flag"></x-icon> {{  $deleteInfo['extendedProps']['eventName'] }}
                    </sapn>
                @endif

                @if(isset($deleteInfo['extendedProps']) && isset($deleteInfo['extendedProps']['status']))
                    @php
                        $status = collect(\BDS\Models\Calendar::STATUS)->sole('id', $deleteInfo['extendedProps']['status']);
                    @endphp

                    <span class="font-bold flex items-center tooltip tooltip-top" data-tip="Statut de l'évènement" style="color: {{ $status['color'] }}">{!! $status['icon'] !!}  {{ $status['name'] }}</span>
                @endif

            </div>

            <x-slot:actions>
                <x-button class="btn btn-success gap-2" type="button" wire:click="markAsDone" spinner>
                    <x-icon name="fas-check" class="h-5 w-5"></x-icon>
                    Maquer comme fait
                </x-button>
                <x-button class="btn btn-error gap-2" type="button" wire:click="destroy" spinner>
                    <x-icon name="fas-trash-can" class="h-5 w-5"></x-icon>
                    Supprimer
                </x-button>
                <x-button @click="$wire.showOptionModal = false" class="btn btn-neutral">
                    Fermer
                </x-button>
            </x-slot:actions>
        </x-modal>
    </div>


</div>

@push('scripts')
    @script
    <script>
        document.addEventListener('livewire:navigated', function () {
            console.log({!! $events !!});
            const calendarEl = document.getElementById('calendar');
            const calendar = new Calendar(calendarEl, {
                    plugins: [ interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin ],
                    locales: [frLocale],
                    timeZone: 'Europe/Paris',
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listWeek'
                    },
                    locale: '{{ config('app.locale') }}',
                    events: {!! $events !!},

                // Create Event
                selectable: @js(Auth::user()->can('create', \BDS\Models\Calendar::class)),
                select: arg => {
                    Livewire.dispatch('event-create', { event: arg });
                },

                // Move/Resize Event
                editable: @js(Auth::user()->can('update', \BDS\Models\Calendar::class)),
                eventResize: info => {
                    Livewire.dispatch('event-change', { event: info.event });
                },
                eventDrop: info => {
                    Livewire.dispatch('event-change', { event: info.event });
                },

                // Delete Event
                eventClick: info => {
                    if (@js(Auth::user()->can('delete', \BDS\Models\Calendar::class))) {
                        Livewire.dispatch('event-destroy', { event: info.event });
                    }
                },

                // Runa after each event has been set
                eventDidMount: function(info) {
                    // DayGridMonth
                    const titleEl = info.el.getElementsByClassName('fc-list-event-title')[0];
                    //ListGrid
                    const titleEl2 = info.el.getElementsByClassName('fc-event-title')[0];
                    titleEl2.innerHTML = info.event.title + "<br>" + info.event.extendedProps.eventName;

                    if (info.event.extendedProps.status === 'done') {

                        // Change background color of row.
                        info.el.style.backgroundColor = '#00b900';
                        info.el.style.borderColor = '#00b900';

                        // Add a check in the title in ListGrid.
                        const titleEl = info.el.getElementsByClassName('fc-list-event-title')[0];
                        if (titleEl) {
                            titleEl.innerHTML = "✅" + info.event.title;
                        }

                        // Add a check in the title in DayGridMonth.
                        if (titleEl2) {
                            titleEl2.innerHTML = "✅" + info.event.title + "<br>" + info.event.extendedProps.eventName;
                        }
                    }
                }
            });
            calendar.render();

            Livewire.on('even-add-success', events =>  {
                calendar.addEvent({
                    id: events[0].id,
                    title: events[0].title,
                    start: events[0].started,
                    end: events[0].ended,
                    color: events[0].color,
                    allDay: events[0].allDay
                });
            });

            Livewire.on('even-destroy-success', id =>  {
                let event = calendar.getEventById(id)
                event.remove();
            });
        });
    </script>
    @endscript
@endpush
