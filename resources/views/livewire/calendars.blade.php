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
                    {{  isset($eventInfo['title']) ? $eventInfo['title'] : '' }}
                </h2>
                <div>
                    <span class="font-bold">
                        {{ isset($eventInfo['start']) ? \Carbon\Carbon::parse($eventInfo['start'])->format('d-m-Y H:i') : '' }}
                    </span>
                    <span class="font-bold">
                      {{ isset($eventInfo['end']) ? ' - ' . \Carbon\Carbon::parse($eventInfo['end'])->format('d-m-Y H:i') : '' }}
                    </span>
                </div>
                @if(isset($eventInfo['allDay']) && $eventInfo['allDay'] == true)
                    <div class="flex items-center">
                        <x-icon class="w-5 h-5 inline mr-2" name="fas-calendar-alt"></x-icon> Toute la journée
                    </div>
                @endif

                @if(isset($eventInfo['extendedProps']) && isset($eventInfo['extendedProps']['eventName']))
                    <sapn class="flex items-center font-bold tooltip tooltip-top" data-tip="Type de l'évènement">
                        <x-icon class="w-5 h-5 inline mr-2" name="fas-flag"></x-icon> {{  $eventInfo['extendedProps']['eventName'] }}
                    </sapn>
                @endif

                @if(isset($eventInfo['extendedProps']) && isset($eventInfo['extendedProps']['status']))
                    @php
                        $status = collect(\BDS\Models\Calendar::STATUS)->sole('id', $eventInfo['extendedProps']['status']);
                    @endphp

                    <span class="font-bold flex items-center tooltip tooltip-top" data-tip="Statut de l'évènement" style="color: {{ $status['color'] }}">{!! $status['icon'] !!}  {{ $status['name'] }}</span>
                @endif
            </div>


            @can('update', \BDS\Models\Calendar::class)
                <div class="divider text-base-content text-opacity-70 uppercase">CHANGER LE STATUT</div>
                <div class="grid grid-cols-2 gap-2">
                    @if(isset($eventInfo['extendedProps']) && isset($eventInfo['extendedProps']['status']))
                        @foreach(collect(\BDS\Models\Calendar::STATUS) as $status)
                                @if($status['id'] == $eventInfo['extendedProps']['status'])
                                    @continue
                                @endif
                                <div class="col-span-1 flex justify-center">
                                    <x-button class="btn gap-2" type="button" wire:click="changeStatus('{{ $status['id'] }}')" spinner>
                                        {!! $status['icon'] !!}
                                        {{ $status['name'] }}
                                    </x-button>
                                </div>
                        @endforeach
                    @endif
                </div>
            @endcan

            <x-slot:actions>
                @can('delete', \BDS\Models\Calendar::class)
                    <x-button class="btn btn-error gap-2" type="button" wire:click="destroy" spinner>
                        <x-icon name="fas-trash-can" class="h-5 w-5"></x-icon>
                        Supprimer
                    </x-button>
                @endcan
                <x-button @click="$wire.showOptionModal = false" class="btn btn-neutral">
                    Fermer
                </x-button>
            </x-slot:actions>
        </x-modal>
    </div>
</div>

@push('scripts')
    @assets
        @vite('resources/js/calendars.js')
    @endassets

    @script
    <script>
        document.addEventListener('livewire:navigated', function () {
            const calendarEl = document.getElementById('calendar');
            if (calendarEl) {
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
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit'
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

                    // Option Event
                    eventClick: info => {
                        Livewire.dispatch('event-option', { event: info.event });
                    },

                    eventContent: function(info) {
                        /*if (info.view.type === "dayGridMonth" || info.view.type === "timeGridWeek") {
                            let divElContainer = document.createElement('div');
                            divElContainer.setAttribute('class', 'flex items-center');
                            divElContainer.innerHTML = info.event.extendedProps.icon;

                            // If it's allDay add the start time.
                            if (info.event.allDay === false) {
                                let divElTime = document.createElement('div');
                                divElTime.setAttribute('class', 'fc-event-time');
                                divElTime.innerHTML = info.timeText;
                                divElContainer.appendChild(divElTime);
                            }

                            // Add title
                            let divElTitle = document.createElement('div');
                            divElTitle.setAttribute('class', 'fc-event-title !font-medium');


                            let spanElTitle = document.createElement('span');
                            spanElTitle.setAttribute('class', 'block');
                            spanElTitle.innerHTML = info.event.title;
                            divElTitle.appendChild(spanElTitle);

                            // Add Event Type
                            let spanElEventName = document.createElement('span');
                            spanElEventName.setAttribute('class', 'block');
                            spanElEventName.innerHTML = info.event.extendedProps.eventName;
                            divElTitle.appendChild(spanElEventName);

                            divElContainer.appendChild(divElTitle);

                            let arrayOfDomNodes = [ divElContainer ];
                            return { domNodes: arrayOfDomNodes };
                        }*/

                        // Create container with status icon.
                        let divElContainer = document.createElement('div');
                        divElContainer.setAttribute('class', 'flex items-center');
                        divElContainer.innerHTML = info.event.extendedProps.icon;

                        // If it's allDay add the start time and only on `dayGridMonth` & `timeGridWeek` views.
                        if (info.event.allDay === false && (info.view.type === "dayGridMonth" || info.view.type === "timeGridWeek")) {
                            let divElTime = document.createElement('div');
                            divElTime.setAttribute('class', 'fc-event-time !mr-2');
                            divElTime.innerHTML = info.timeText;
                            divElContainer.appendChild(divElTime);
                        }

                        // Create title/event type container.
                        let divElTitle = document.createElement('div');
                        divElTitle.setAttribute('class', 'fc-event-title !font-medium');

                        // Add title.
                        let spanElTitle = document.createElement('span');
                        spanElTitle.setAttribute('class', 'block');
                        spanElTitle.innerHTML = info.event.title;
                        divElTitle.appendChild(spanElTitle);

                        // Add Event Type.
                        let spanElEventName = document.createElement('span');
                        spanElEventName.setAttribute('class', 'block');
                        spanElEventName.innerHTML = info.event.extendedProps.eventName;
                        divElTitle.appendChild(spanElEventName);

                        divElContainer.appendChild(divElTitle);

                        let arrayOfDomNodes = [ divElContainer ];
                        return { domNodes: arrayOfDomNodes };

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
                        allDay: events[0].allDay,
                        extendedProps: {
                            status: events[0].status,
                            eventName: events[0].eventName,
                            icon: events[0].icon
                        }
                    });
                });

                Livewire.on('even-destroy-success', id =>  {
                    let event = calendar.getEventById(id);
                    event.remove();
                });

                Livewire.on('even-change-status-success', events =>  {
                    let event = calendar.getEventById(events[0].id);
                    event.remove();

                    calendar.addEvent({
                        id: events[0].id,
                        title: events[0].title,
                        start: events[0].started,
                        end: events[0].ended,
                        color: events[0].color,
                        allDay: events[0].allDay,
                        extendedProps: {
                            status: events[0].status,
                            eventName: events[0].eventName,
                            icon: events[0].icon
                        }
                    });
                });
            }
        });
    </script>
    @endscript
@endpush
