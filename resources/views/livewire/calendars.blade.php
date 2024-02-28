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

        <!-- Delete Modal -->
        <x-modal wire:model="showDeleteModal" title="Supprimer un Évènement">
            <div>
                <p class="my-7 prose">
                    Voulez-vous supprimer l'évènement <code class="bg-[color:var(--tw-prose-pre-bg)] font-bold rounded-sm" style="color:{{ isset($deleteInfo['backgroundColor']) ? $deleteInfo['backgroundColor'] : '' }}">{{ isset($deleteInfo['title']) ? $deleteInfo['title'] : '' }}</code> commençant le <span class="font-bold">{{ isset($deleteInfo['start']) ? \Carbon\Carbon::parse($deleteInfo['start'])->format('d-m-Y H:i') : '' }}</span> ?
                </p>
            </div>

            <x-slot:actions>
                <x-button class="btn btn-error gap-2" type="button" wire:click="deleteSelected" spinner>
                    <x-icon name="fas-trash-can" class="h-5 w-5"></x-icon>
                    Supprimer
                </x-button>
                <x-button @click="$wire.showDeleteModal = false" class="btn btn-neutral">
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
            const calendarEl = document.getElementById('calendar');
            const calendar = new Calendar(calendarEl, {
                    plugins: [ interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin ],
                    locales: [frLocale],
                    timeZone: 'Europe/Paris',
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listMonth'
                    },
                    locale: '{{ config('app.locale') }}',
                    events: {!! $events !!},

                // Create Event
                selectable: @js(Auth::user()->can('create', \BDS\Models\Calendar::class)),
                select: arg => {
                    @this.eventAdd(arg)
                },

                // Move/Resize Event
                editable: @js(Auth::user()->can('update', \BDS\Models\Calendar::class)),
                eventResize: info => @this.eventChange(info.event),
                eventDrop: info => @this.eventChange(info.event),

                // Delete Event
                eventClick: info => {
                    if (@js(Auth::user()->can('delete', \BDS\Models\Calendar::class))) {
                        @this.eventDestroy(info.event)
                    }
                }
            });
            calendar.render();

            $wire.on('evenAddSuccess', event =>  {
                console.log(event);
                calendar.addEvent({
                    id: event.id,
                    title: event.title,
                    start: event.started,
                    end: event.ended,
                    color: event.color,
                    allDay: event.allDay
                });
            });

            Livewire.on('evenAddSuccess', event =>  {
                console.log(event);
                calendar.addEvent({
                    id: event.id,
                    title: event.title,
                    start: event.started,
                    end: event.ended,
                    color: event.color,
                    allDay: event.allDay
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
