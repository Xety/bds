@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/fullcalendar_5.6.0_main.css') }}" />
@endpush

<div>
    <div>
        <div class="grid grid-cols-12 gap-6 overflow-x-auto" id='calendar-container' wire:ignore>
            <div class="col-span-12 max-h-[900px]" id='calendar'></div>
        </div>
    </div>


</div>

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/locales-all.min.js"></script>
    <script>
        document.addEventListener('livewire:init', function () {
            const Calendar = FullCalendar.Calendar;
            const calendarEl = document.getElementById('calendar');
            const calendar = new Calendar(calendarEl, {
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
                    Livewire.dispatch('eventAdd', arg);
                },

                // Move/Resize Event
                editable: @js(Auth::user()->can('update', \BDS\Models\Calendar::class)),
                eventResize: info => @this.eventChange(info.event),
                eventDrop: info => @this.eventChange(info.event),

                // Delete Event
                eventClick: info => {
                if (@js(Auth::user()->can('delete', \BDS\Models\Calendar::class))) {
                    Livewire.dispatch('eventDestroy', info.event);
                }
            }
        });
            calendar.render();

            Livewire.on('evenAddSuccess', event =>  {
                calendar.addEvent({
                    id: event.id,
                    title: event.title,
                    start: event.started,
                    end: event.ended,
                    color: event.color,
                    allDay: event.allDay
                });
            });

            Livewire.on('evenDestroySuccess', id =>  {
                event = calendar.getEventById(id)
                event.remove();
            });
        });
    </script>
@endpush
