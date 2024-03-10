@extends('layouts.app')
{!! config(['app.title' => 'Pulse']) !!}

@push('meta')
    <x-meta title="Pulse"/>
@endpush

@push('style')
    {!! Laravel\Pulse\Facades\Pulse::css() !!}
    {!! Laravel\Pulse\Facades\Pulse::js() !!}
@endpush


@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <svg class="h-10 w-10" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.4566 6.75005C15.9683 6.75596 16.4047 7.09621 16.5001 7.56364L18.8747 19.2038L19.999 17.1682C20.1832 16.8347 20.5526 16.625 20.9559 16.625H31.1744C31.7684 16.625 32.25 17.0727 32.25 17.625C32.25 18.1773 31.7684 18.625 31.1744 18.625H21.6127L19.3581 22.7068C19.1483 23.0867 18.7021 23.3008 18.2475 23.2397C17.7928 23.1786 17.4301 22.8559 17.3445 22.4363L15.376 12.7868L13.1334 22.4607C13.0282 22.9146 12.6007 23.2414 12.1013 23.2498C11.6019 23.2582 11.162 22.9458 11.0393 22.4957L9.30552 16.1378L8.19223 18.0929C8.00581 18.4202 7.64002 18.625 7.2416 18.625H1.32563C0.731576 18.625 0.25 18.1773 0.25 17.625C0.25 17.0727 0.731576 16.625 1.32563 16.625H6.59398L8.71114 12.9071C8.9193 12.5415 9.34805 12.3328 9.78979 12.3821C10.2315 12.4313 10.5951 12.7283 10.7044 13.1292L11.9971 17.8695L14.3918 7.53929C14.4996 7.07421 14.9449 6.74414 15.4566 6.75005Z" fill="url(#paint0_linear_4_31)"/>
                    <defs>
                        <linearGradient id="paint0_linear_4_31" x1="16.25" y1="6.74997" x2="16.25" y2="23.25" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#F85A5A"/>
                            <stop offset="0.828125" stop-color="#7A5AF8"/>
                        </linearGradient>
                    </defs>
                </svg>
                <span class="ml-2 text-2xl sm:text-2xl text-gray-700 dark:text-gray-300 font-medium">Pulse</span>
            </div>
            <div class="flex items-center gap-3 sm:gap-6">
                <livewire:pulse.period-selector />
            </div>
        </div>

        <div class="mx-auto grid default:grid-cols-12 default:gap-6">
            <livewire:pulse.servers cols="full" />

            <livewire:pulse.usage cols="4" rows="2" />

            <livewire:pulse.queues cols="4" />

            <livewire:pulse.cache cols="4" />

            <livewire:pulse.slow-queries cols="8" />

            <livewire:pulse.exceptions cols="6" />

            <livewire:pulse.slow-requests cols="6" />

            <livewire:database cols='6' title="Active threads" :values="['Threads_connected', 'Threads_running']" :graphs="[
    'avg' => ['Threads_connected' => '#ffffff', 'Threads_running' => '#3c5dff'],
]" />

            <livewire:database cols='6' title="Connections" :values="['Connections', 'Max_used_connections']" />

            <livewire:database cols='full' title="Innodb" :values="['Innodb_buffer_pool_reads', 'Innodb_buffer_pool_read_requests', 'Innodb_buffer_pool_pages_total']" :graphs="[
    'avg' => ['Innodb_buffer_pool_reads' => '#ffffff', 'Innodb_buffer_pool_read_requests' => '#3c5dff'],
]" />
        </div>
    </section>
@endsection
