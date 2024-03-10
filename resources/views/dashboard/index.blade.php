@extends('layouts.app')
{!! config(['app.title' => 'Tableau de bord']) !!}

@push('meta')
    <x-meta title="Tableau de bord"/>
@endpush

@push('scripts')
        @vite('resources/js/apexcharts.js')

    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            // Incidents / Maintenances
            let settingsIncidentsMaintenancesGraphData = {
                chart: {
                    height: '420px',
                    toolbar: {
                        show: false
                    }
                },
                series: [
                    {
                        name: 'Maintenances',
                        data: {!! json_encode($incidentsMaintenancesGraphData['maintenances']) !!},
                        color: '#fbbd23'
                    },
                    {
                        name: 'Incidents',
                        data: {!! json_encode($incidentsMaintenancesGraphData['incidents']) !!},
                        color: '#f87272'
                    }
                ],
                grid: {
                    show: true,
                    borderColor: '#F3F4F6',
                    strokeDashArray: 1,
                    padding: {
                        left: 35,
                        bottom: 15
                    }
                },
                xaxis: {
                    categories: {!! json_encode($incidentsMaintenancesGraphData['months']) !!},
                    labels: {
                        style: {
                            fontSize: '14px',
                            fontWeight: 500,
                        }
                    }
                },
                yaxis: {
                    stepSize: 1,
                    labels: {
                        style: {
                            fontSize: '14px',
                            fontWeight: 500,
                        },
                        formatter: function (val, index) {
                            return val;
                        }
                    },
                },
                markers: {
                    size: 5,
                    strokeColors: '#ffffff',
                    hover: {
                        size: undefined,
                        sizeOffset: 3
                    }
                },
                legend: {
                    fontSize: '14px',
                    fontWeight: 500,
                    fontFamily: 'Inter, sans-serif',
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value
                        }
                    }
                }
            };

            let incidentsMaintenancesGraphData = new ApexCharts(document.querySelector("#incidents-maintenances-graph"), settingsIncidentsMaintenancesGraphData);
            incidentsMaintenancesGraphData.render();

            // Part Entries / Part Exits
            let settingsPartEntriesPartExitsGraphData = {
                chart: {
                    height: '420px',
                    toolbar: {
                        show: false
                    }
                },
                series: [
                    {
                        name: 'Entrées Totales de Pièces',
                        data: {!! json_encode($partEntriesPartExitsGraphData['parts-entries']) !!},
                        color: '#9333ea'
                    },
                    {
                        name: 'Sorties Totales de Pièces',
                        data: {!! json_encode($partEntriesPartExitsGraphData['parts-exits']) !!},
                        color: '#0ea5e9'
                    }
                ],
                grid: {
                    show: true,
                    borderColor: '#F3F4F6',
                    strokeDashArray: 1,
                    padding: {
                        left: 35,
                        bottom: 15
                    }
                },
                xaxis: {
                    categories: {!! json_encode($partEntriesPartExitsGraphData['months']) !!},
                    labels: {
                        style: {
                            fontSize: '14px',
                            fontWeight: 500,
                        },
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '14px',
                            fontWeight: 500,
                        }
                    },
                },
                markers: {
                    size: 5,
                    strokeColors: '#ffffff',
                    hover: {
                        size: undefined,
                        sizeOffset: 3
                    }
                },
                legend: {
                    fontSize: '14px',
                    fontWeight: 500,
                    fontFamily: 'Inter, sans-serif',
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value
                        }
                    }
                }
            };

            let partEntriesPartExitsGraphData = new ApexCharts(document.querySelector("#part-entries-part-exits-graph"), settingsPartEntriesPartExitsGraphData);
            partEntriesPartExitsGraphData.render();
        });
    </script>
@endpush

@section('content')
<x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

<section class="m-3 lg:m-10">
    <div class="grid grid-cols-12 gap-4 mb-4">

        <div class="col-span-12 lg:col-span-6 2xl:col-span-3">
            <div class="p-6 shadow-md border rounded-lg h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                <div class="flex justify-between">
                    <div class="text-2xl">
                        <span class="uppercase mr-2">Incidents</span>
                        <div class="dropdown dropdown-hover dropdown-bottom dropdown-end">
                            <label tabindex="0" class="hover:cursor-pointer text-info">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </label>
                            <div tabindex="0" class="card compact dropdown-content z-[1] shadow bg-base-100 dark:bg-base-200 rounded-box w-64">
                                <div class="card-body">
                                    <p>
                                        Nombre d'incidents total sur le mois en cours : <span class="capitalize">{{ $lastMonthText }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <x-icon name="fas-triangle-exclamation" class="text-error w-12 h-12"></x-icon>
                    </div>
                </div>
                <div class="font-bold flex items-center">
                    <span class="text-4xl">
                        {{ $lastMonthIncidents }}
                    </span>
                    @if ($percentIncidentsCount < 0)
                        <span class="text-success tooltip text-2xl" data-tip="{{ $percentIncidentsCount }}% d'incidents le mois de {{ $lastMonthText }} par rapport au mois de {{ $last2MonthsText }}.">
                            ({{ $percentIncidentsCount }}%)
                        </span>
                    @else
                        <span class="text-red-500 tooltip text-2xl" data-tip="+{{ $percentIncidentsCount }}% d'incidents le mois de {{ $lastMonthText }} par rapport au mois de {{ $last2MonthsText }}.">
                            +({{ $percentIncidentsCount }}%)
                        </span>
                    @endif
                </div>
                <div class="divider"></div>
                <span class="opacity-70">
                    Le nombre d'incidents sur le mois de <span class="capitalize">{{ $lastMonthText }}</span>.
                </span>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-6 2xl:col-span-3">
            <div class="p-6 shadow-md border rounded-lg h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                <div class="flex justify-between">
                    <div class="text-2xl">
                        <span class="uppercase mr-2">Maintenances</span>
                        <div class="dropdown dropdown-hover dropdown-bottom dropdown-end">
                            <label tabindex="0" class="hover:cursor-pointer text-info">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </label>
                            <div tabindex="0" class="card compact dropdown-content z-[1] shadow bg-base-100 dark:bg-base-200 rounded-box w-64">
                                <div class="card-body">
                                    <p>
                                        Nombre de maintenances total sur le mois en cours : <span class="capitalize">{{ $lastMonthText }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <x-icon name="fas-screwdriver-wrench" class="text-warning w-12 h-12"></x-icon>
                    </div>
                </div>
                <div class="font-bold flex items-center">
                    <span class="text-4xl">
                        {{ $lastMonthMaintenances }}
                    </span>
                    @if ($percentMaintenancesCount < 0)
                        <span class="text-success tooltip text-2xl" data-tip="{{ $percentMaintenancesCount }}% de maintenances le mois de {{ $lastMonthText }} par rapport au mois de {{ $last2MonthsText }}.">
                            ({{ $percentMaintenancesCount }}%)
                        </span>
                    @else
                        <span class="text-red-500 tooltip text-2xl" data-tip="+{{ $percentMaintenancesCount }}% de maintenances le mois de {{ $lastMonthText }} par rapport au mois de {{ $last2MonthsText }}.">
                            +({{ $percentMaintenancesCount }}%)
                        </span>
                    @endif
                </div>
                <div class="divider"></div>
                <span class="opacity-70">
                    Le nombre de maintenance sur le mois de <span class="capitalize">{{ $lastMonthText }}</span>.
                </span>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-6 2xl:col-span-3">
            <div class="p-6 shadow-md border rounded-lg h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                <div class="flex justify-between">
                    <div class="text-2xl">
                        <span class="uppercase mr-2">Pièces Détachées</span>
                        <div class="dropdown dropdown-hover dropdown-bottom dropdown-end">
                            <label tabindex="0" class="hover:cursor-pointer text-info">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </label>
                            <div tabindex="0" class="card compact dropdown-content z-[1] shadow bg-base-100 dark:bg-base-200 rounded-box w-64">
                                <div class="card-body">
                                    <p>
                                        Nombre de pièces détachées en stocks actuellement.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <x-icon name="fas-cubes-stacked" class="text-blue-500 w-12 h-12"></x-icon>
                    </div>
                </div>
                <div class="text-4xl font-bold flex items-center">
                    {{ $partInStock }}
                </div>
                <div class="divider"></div>
                <span class="opacity-70">
                    Le nombre de pièces détachées en stock actuellement.
                </span>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-6 2xl:col-span-3">
            <div class="p-6 shadow-md border rounded-lg h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                <div class="flex justify-between">
                    <div class="text-2xl">
                        <span class="uppercase mr-2">Nettoyages</span>
                        <div class="dropdown dropdown-hover dropdown-bottom dropdown-end">
                            <label tabindex="0" class="hover:cursor-pointer text-info">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </label>
                            <div tabindex="0" class="card compact dropdown-content z-[1] shadow bg-base-100 dark:bg-base-200 rounded-box w-64">
                                <div class="card-body">
                                    <p>
                                        Nombre de nettoyages total sur le mois en cours : <span class="capitalize">{{ $lastMonthText }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <x-icon name="fas-broom" class="text-success w-12 h-12"></x-icon>
                    </div>
                </div>
                <div class="text-4xl font-bold flex items-center">
                    {{ $lastMonthCleanings }}
                </div>
                <div class="divider"></div>
                <span class="opacity-70">
                    Le nombre de nettoyages sur le mois de <span class="capitalize">{{ $lastMonthText }}</span>.
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-4 mb-4">
        <div class="col-span-12">
            <div class="p-6 shadow-md border rounded-lg h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-shrink-0">
                        <span class="text-xl font-bold sm:text-2xl">Activité en cours</span>
                        <h3 class="hidden sm:block text-base font-light text-gray-500 ">Incidents et maintenances non résolus</h3>
                    </div>
                    <div class="flex items-center justify-end">
                        <x-icon name="fas-list-check" class="h-12 w-12 text-purple-600"></x-icon>
                    </div>
                </div>

                <x-tabs selected="incidents">
                    <x-tab name="incidents" label="Incidents" icon="fas-triangle-exclamation">
                        @if ($incidents->isNotEmpty())
                            <x-table.table class="mb-6">
                                <x-slot name="head">
                                    <x-table.heading>#Id</x-table.heading>
                                    <x-table.heading>Matériel</x-table.heading>
                                    <x-table.heading>Zone</x-table.heading>
                                    <x-table.heading>Créateur</x-table.heading>
                                    <x-table.heading>Description</x-table.heading>
                                    <x-table.heading>Incident créé le</x-table.heading>
                                    <x-table.heading>Impact</x-table.heading>
                                    <x-table.heading>Résolu</x-table.heading>
                                </x-slot>

                                <x-slot name="body">
                                    @foreach($incidents as $incident)
                                        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $incident->getKey() }}" @class([
                                            'bg-opacity-25',
                                            'bg-yellow-500' => $incident->impact == 'mineur',
                                            'bg-orange-500' => $incident->impact == 'moyen',
                                            'bg-red-500' => $incident->impact == 'critique'
                                        ])>
                                            <x-table.cell>{{ $incident->getKey() }}</x-table.cell>
                                            <x-table.cell>
                                                <a class="link link-hover link-primary font-bold" href="{{ $incident->material->show_url }}">
                                                    {{ $incident->material->name }}
                                                </a>
                                            </x-table.cell>
                                            <x-table.cell>
                                                {{ $incident->material->zone->name }}
                                            </x-table.cell>
                                            <x-table.cell>
                                                <a class="link link-hover link-primary font-bold" href="{{ $incident->user->show_url }}">
                                                    {{ $incident->user->full_name }}
                                                </a>
                                            </x-table.cell>
                                            <x-table.cell>
                                                <span class="tooltip tooltip-top" data-tip="{{ $incident->description }}">{{ Str::limit($incident->description, 30) }}</span>
                                            </x-table.cell>
                                            <x-table.cell class="capitalize">{{ $incident->started_at->translatedFormat( 'D j M Y H:i') }}</x-table.cell>
                                            <x-table.cell>
                                                @if ($incident->impact == 'mineur')
                                                    <span class="font-bold text-yellow-500">Mineur</span>
                                                @elseif ($incident->impact == 'moyen')
                                                    <span class="font-bold text-orange-500">Moyen</span>
                                                @else
                                                    <span class="font-bold text-red-500">Critique</span>
                                                @endif
                                            </x-table.cell>
                                            <x-table.cell>
                                                @if ($incident->is_finished)
                                                    <span class="font-bold text-green-500">Oui</span>
                                                @else
                                                    <span class="font-bold text-red-500">Non</span>
                                                @endif
                                            </x-table.cell>
                                        </x-table.row>
                                    @endforeach
                                </x-slot>
                            </x-table.table>

                            <div class="grid grid-cols-1">
                                {{ $incidents->fragment('incidents')->links() }}
                            </div>
                        @else
                            <x-alert type="success" title="Aucun incident">
                                Aucun incident actif en cours !
                            </x-alert>
                        @endif
                    </x-tab>

                    <x-tab name="maintenances" label="Maintenances" icon="fas-screwdriver-wrench">
                        @if ($maintenances->isNotEmpty())
                            <x-table.table class="mb-6">
                                <x-slot name="head">
                                    <x-table.heading>#Id</x-table.heading>
                                    <x-table.heading>N° GMAO</x-table.heading>
                                    <x-table.heading>Matériel</x-table.heading>
                                    <x-table.heading>Description</x-table.heading>
                                    <x-table.heading>Raison</x-table.heading>
                                    <x-table.heading>Créateur</x-table.heading>
                                    <x-table.heading>Type</x-table.heading>
                                    <x-table.heading>Réalisation</x-table.heading>
                                    <x-table.heading>Commencée le</x-table.heading>
                                </x-slot>

                                <x-slot name="body">
                                    @foreach($maintenances as $maintenance)
                                        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $maintenance->getKey() }}">
                                            <x-table.cell>
                                                <a class="link link-hover link-primary tooltip tooltip-right" href="{{ $maintenance->show_url }}"  data-tip="Voir la fiche Maintenance">
                                                    <span class="font-bold">{{ $maintenance->getKey() }}</span>
                                                </a>
                                            </x-table.cell>
                                            <x-table.cell class="prose">
                                                @unless (is_null($maintenance->gmao_id))
                                                    <code class="text-neutral-content  bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                                        {{ $maintenance->gmao_id }}
                                                    </code>
                                                @endunless
                                            </x-table.cell>
                                            <x-table.cell class="prose">
                                                @unless (is_null($maintenance->material_id))
                                                    <a class="link link-hover link-primary font-bold" href="{{ $maintenance->material_url }}">
                                                        {{ $maintenance->material->name }}
                                                    </a>
                                                @endunless
                                            </x-table.cell>
                                            <x-table.cell>
                                                <span class="tooltip tooltip-top" data-tip="{{ $maintenance->description }}">
                                                    {{ Str::limit($maintenance->description, 30) }}
                                                </span>
                                            </x-table.cell>
                                            <x-table.cell>
                                                <span class="tooltip tooltip-top" data-tip="{{ $maintenance->reason }}">
                                                    {{ Str::limit($maintenance->reason, 30) }}
                                                </span>
                                            </x-table.cell>
                                            <x-table.cell>
                                                <a class="link link-hover link-primary font-bold" href="{{ $maintenance->user->show_url }}">
                                                    {{ $maintenance->user->full_name }}
                                                </a>
                                            </x-table.cell>
                                            <x-table.cell>
                                                @if ($maintenance->type === 'curative')
                                                    <span class="font-bold text-red-500">Curative</span>
                                                @else
                                                    <span class="font-bold text-green-500">Préventive</span>
                                                @endif
                                            </x-table.cell>
                                            <x-table.cell>
                                                @if ($maintenance->realization === 'external')
                                                    <span class="font-bold text-red-500">Externe</span>
                                                @elseif ($maintenance->realization === 'internal')
                                                    <span class="font-bold text-green-500">Interne</span>
                                                @else
                                                    <span class="font-bold text-yellow-500">Interne et Externe</span>
                                                @endif
                                            </x-table.cell>
                                            <x-table.cell class="capitalize">
                                                {{ $maintenance->started_at?->translatedFormat( 'D j M Y H:i') }}
                                            </x-table.cell>
                                        </x-table.row>
                                    @endforeach
                                </x-slot>
                            </x-table.table>

                            <div class="grid grid-cols-1">
                                {{ $maintenances->fragment('maintenances')->links() }}
                            </div>
                        @else
                            <x-alert type="success" title="Aucune maintenance">
                                Aucune maintenance active en cours !
                            </x-alert>
                        @endif
                    </x-tab>
                </x-tabs>

            </div>
        </div>

        <div class="col-span-12">
            <div class="p-6 shadow-md border rounded-lg h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-shrink-0">
                        <span class="text-xl font-bold sm:text-2xl">Incidents et Maintenances</span>
                        <h3 class="text-base font-light text-gray-500 ">Historique sur les 12 derniers mois</h3>
                    </div>
                    <div class="flex items-center justify-end">
                        <x-icon name="fas-chart-line" class="h-12 w-12 text-cyan-500"></x-icon>
                    </div>
                </div>
                <div id="incidents-maintenances-graph" height="420px"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-4 mb-4">
        <div class="col-span-12 2xl:col-span-8">
            <div class="p-6 shadow-md border rounded-lg h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex flex-col">
                            <span class="text-xl font-bold sm:text-2xl">
                                Entrées et Sorties totales pour les Pièces Détachées
                            </span>
                        <h3 class="text-base font-light text-gray-500">
                            Historique sur les 12 derniers mois
                        </h3>
                    </div>
                    <div class="flex items-center justify-end">
                        <x-icon name="fas-chart-line" class="h-12 w-12 text-cyan-500"></x-icon>
                    </div>
                </div>
                <div id="part-entries-part-exits-graph" height="420px"></div>
            </div>
        </div>

        <div class="col-span-12 2xl:col-span-4">
            <div class="p-6 shadow-md border rounded-lg h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">

            </div>
        </div>
    </div>
</section>

{{-- QrCode Modal --}}
<livewire:qr-code-modal>
@endsection
