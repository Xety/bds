@extends('layouts.app')
{!! config(['app.title' => $part->name]) !!}

@push('meta')
    <x-meta title="{{ $part->name }}" />
@endpush

@push('scripts')
    @vite('resources/js/apexcharts.js')

    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            let settings = {
                    chart: {
                        height: '420px',
                        toolbar: {
                            show: false
                        }
                    },
                    series: [
                        {
                            name: 'Entrées Totales de Pièces',
                            data: {!! json_encode($chart['parts-entries']) !!},
                            color: '#f87272'
                        },
                        {
                            name: 'Sorties Totales de Pièces',
                            data: {!! json_encode($chart['parts-exits']) !!},
                            color: '#fbbd23'
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
                        categories: {!! json_encode($chart['months']) !!},
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
                    }
                };

            let chart = new ApexCharts(document.querySelector("#chart"), settings);
            chart.render();
        });
    </script>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <section class="m-3 lg:m-10">
        <div class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-4 h-full">
                    <div class="col-span-12 xl:col-span-6">
                        <div class="flex flex-col text-center shadow-md border rounded-lg p-6 w-full h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <div class="w-full">
                                <div class="text-5xl m-2 mb-4">
                                    <x-icon name="fas-gear" class="h-12 w-12 m-auto"></x-icon>
                                </div>
                            </div>

                            <div class="w-full">
                                <h1 class="text-2xl xl:text-4xl font-selvah pb-2 mx-5 xl:border-dotted xl:border-b xl:border-slate-500">
                                    {{ $part->name }}
                                </h1>
                                <p class="hidden xl:block py-2 mx-5 text-gray-400">
                                    {{ $part->description }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-2">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <div class="flex flex-col gap-4 p-5 items-center content-between">
                                <div class="text-muted text-xl font-bds uppercase">
                                    Site
                                </div>
                                <figure class="px-10">
                                    @if ($part->site->id == settings('site_id_selvah'))
                                        <img src="{{ asset('images/logos/selvah.png') }}" alt="Selvah Logo" class="inline-block w-20">
                                    @elseif ($part->site->id == settings('site_id_extrusel'))
                                        <img src="{{ asset('images/logos/extrusel.png') }}" alt="Extrusel Logo" class="inline-block w-28">
                                    @elseif ($part->site->id == settings('site_id_moulin_jannet'))
                                        <img src="{{ asset('images/logos/moulin_jannet.png') }}" alt="Moulin Jannet Logo" class="inline-block w-16">
                                    @elseif ($part->site->id == settings('site_id_val_union'))
                                        <img src="{{ asset('images/logos/bfc_val_union.png') }}" alt="BFC Val Union Logo" class="inline-block dark:hidden h-14">
                                        <img src="{{ asset('images/logos/bfc_val_union_blanc.png') }}" alt="BFC Val Union Logo" class="hidden dark:inline-block h-14">
                                    @else
                                        <img src="{{ asset('images/logos/cbds_32x383.png') }}" alt="Coopérative Bourgogne du Sud Logo" class="inline-block w-20">
                                    @endif
                                </figure>
                                <div class="font-bold text-xl">
                                    {{ $part->site->name }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <div class="flex flex-col shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <div class="flex flex-col-reverse 2xl:flex-row justify-between">
                                <div class="text-2xl font-bold">
                                    <h2 class="mb-4">
                                        Informations
                                    </h2>
                                </div>
                                <div class="text-right">
                                    @if ((Gate::any(['update', 'generateQrCode'], $part) ||
                                        Gate::any(['create'], \BDS\Models\PartEntry::class) ||
                                        Gate::any(['create'], \BDS\Models\PartExit::class)) &&
                                        getPermissionsTeamId() === $part->site_id)
                                        <x-dropdown right hover label="Actions" class="w-60" trigger-class="btn-neutral btn-sm">
                                            @can('update', $part)
                                                <x-menu-item
                                                    title="Modifier cette pièce"
                                                    icon="fas-pen-to-square"
                                                    tooltip
                                                    tooltip-content="Modifier cette pièce détachée"
                                                    link="{{ route('parts.index', ['partId' => $part->getKey(), 'editing' => 'true']) }}" class="text-blue-500 text-left" />
                                            @endcan
                                            @can('generateQrCode', $part)
                                                <x-menu-item
                                                    title="Générer un QR Code"
                                                    icon="fas-qrcode"
                                                    tooltip
                                                    tooltip-content="Générer un QR Code pour cette pièce détachée"
                                                    link="{{ route('parts.index', ['partId' => $part->getKey(), 'qrcode' => 'true']) }}"
                                                    class="text-purple-500" />
                                            @endcan
                                            @can('create', \BDS\Models\PartEntry::class)
                                                <x-menu-item
                                                    wire:navigate
                                                    title="Créer une Entrée"
                                                    icon="fas-arrow-right-to-bracket"
                                                    tooltip
                                                    tooltip-content="Créer une entrée pour cette pièce détachée"
                                                    link="{{ route('part-entries.index', ['partId' => $part->getKey(), 'creating' => 'true']) }}"
                                                    class="text-green-500" />
                                            @endcan
                                            @can('create', \BDS\Models\PartExit::class)
                                                <x-menu-item
                                                    wire:navigate
                                                    title="Créer une Sortie"
                                                    icon="fas-right-from-bracket"
                                                    tooltip
                                                    tooltip-content="Créer une sortie pour cette pièce détachée"
                                                    link="{{ route('part-exits.index', ['partId' => $part->getKey(), 'creating' => 'true']) }}"
                                                    class="text-yellow-500" />
                                            @endcan
                                        </x-dropdown>
                                    @endif
                                </div>
                            </div>


                            <div class="grid grid-cols-12 gap-2 mb-4">
                                <div class="col-span-12">
                                    <div class="inline-block font-bold min-w-[140px]">Référence : </div>
                                    <div class="inline-block">
                                        @if ($part->reference)
                                            <code class="code rounded-sm">
                                                {{ $part->reference }}
                                            </code>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-span-12">
                                    <div class="inline-block font-bold min-w-[140px]">Prix Unitaire : </div>
                                    <div class="inline-block">
                                        @if ($part->price)
                                            <code class="code rounded-sm">
                                                {{ $part->price }}€
                                            </code>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-span-12">
                                    <div class="inline-block font-bold min-w-[140px]">Alerte : </div>
                                    <div class="inline-block">
                                        @if ($part->number_warning_enabled)
                                            <code class="code !text-red-500 rounded-sm">
                                                Oui
                                            </code>
                                        @else
                                            <code class="code !text-green-500 rounded-sm">
                                                Non
                                            </code>
                                        @endif
                                    </div>
                                </div>

                                @if ($part->number_warning_enabled)
                                    <div class="col-span-12">
                                        <div class="inline-block font-bold min-w-[140px]">Nb mini alerte : </div>
                                        <div class="inline-block">
                                            <code class="code rounded-sm">
                                                {{ number_format($part->number_warning_minimum) }}
                                            </code>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-span-12">
                                    <div class="inline-block font-bold min-w-[140px]">Alerte critique : </div>
                                    <div class="inline-block">
                                        @if ($part->number_critical_enabled)
                                            <code class="code !text-red-500 rounded-sm">
                                                Oui
                                            </code>
                                        @else
                                            <code class="code !text-green-500 rounded-sm">
                                                Non
                                            </code>
                                        @endif
                                    </div>
                                </div>


                                @if ($part->number_critical_enabled)
                                    <div class="col-span-12">
                                        <div class="inline-block font-bold min-w-[140px]">Nb mini critique : </div>
                                        <div class="inline-block">
                                            <code class="code rounded-sm">
                                                {{ number_format($part->number_critical_minimum) }}
                                            </code>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12">
                <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex flex-col">
                            <span class="text-xl font-bold sm:text-2xl">
                                Entrées et Sortie totales pour la pièce détachée {{ $part->name }}
                            </span>
                            <h3 class="text-base font-light text-gray-500">
                                Historique sur les 12 derniers mois
                            </h3>
                        </div>
                        <div class="flex items-center justify-end">
                            <x-icon name="fas-chart-line" class="h-12 w-12 text-cyan-500"></x-icon>
                        </div>
                    </div>

                    <div id="chart" height="420px"></div>
                </div>
            </div>

            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-4 text-center h-full">
                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <x-icon name="fas-shop" class="text-primary h-16 w-16 m-auto"></x-icon>
                            <div>
                                <div class="text-muted text-xl uppercase">
                                    Fournisseur
                                </div>
                                <p class="font-bold font-selvah uppercase">
                                    @if($part->supplier_id)
                                        <a class="link link-hover link-primary font-bold" href="{{ $part->supplier->show_url }}">
                                            {{ $part->supplier->name }}
                                        </a>
                                    @else
                                        Aucun
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <x-icon name="fas-cubes-stacked" class="text-success h-16 w-16 m-auto"></x-icon>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ $part->stock_total }}
                                </div>
                                <p class="text-muted font-bds uppercase">
                                    Nombre(s) en stock
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <x-icon name="fas-euro-sign" class="text-info h-16 w-16 m-auto"></x-icon>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ number_format($part->stock_total * $part->price) }}€
                                </div>
                                <p class="text-muted font-bds uppercase">
                                    Prix des pièces en stock
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <x-icon name="fas-arrow-right-to-bracket" class="text-warning h-16 w-16 m-auto"></x-icon>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ $part->part_entry_count }}
                                </div>
                                <p class="text-muted font-bds uppercase">
                                    Entrée(s) de pièce(s)
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <x-icon name="fas-right-from-bracket" class="text-error h-16 w-16 m-auto"></x-icon>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ $part->part_exit_count }}
                                </div>
                                <p class="text-muted font-bds uppercase">
                                    Sortie(s) de pièce(s)
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <x-icon name="fas-qrcode" class="text-purple-600 h-16 w-16 m-auto"></x-icon>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ $part->qrcode_flash_count }}
                                </div>
                                <p class="text-muted font-bds uppercase">
                                    Nombre de flash QR Code
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6 mb-7">
            <div class="col-span-12 border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">

                <x-tabs selected="materials">
                    <x-tab name="materials" label="Matériels" icon="fas-microchip">
                        <x-table.table class="mb-6">
                            <x-slot name="head">
                                <x-table.heading>#Id</x-table.heading>
                                <x-table.heading>Nom</x-table.heading>
                                <x-table.heading>Site</x-table.heading>
                                <x-table.heading>Zone</x-table.heading>
                                <x-table.heading>Description</x-table.heading>
                                <x-table.heading>Créé le</x-table.heading>
                            </x-slot>

                            <x-slot name="body">
                                @forelse($materials as $material)
                                    <x-table.row wire:loading.class.delay="opacity-50"
                                                 wire:key="row-{{ $material->getKey() }}">
                                        <x-table.cell>{{ $material->getKey() }}</x-table.cell>
                                        <x-table.cell>
                                            <a class="link link-hover link-primary font-bold"
                                               href="{{ $material->show_url }}">
                                                {{ $material->name }}
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <a class="link link-hover link-primary font-bold" href="{{ $material->zone->site->show_url }}">
                                                {{ $material->zone->site->name }}
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <a class="link link-hover link-primary font-bold" href="{{ $material->zone->show_url }}">
                                                {{ $material->zone->name }}
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell>
                                        <span class="tooltip tooltip-top" data-tip="{{ $material->description }}">
                                            {{ Str::limit($material->description, 50) }}
                                        </span>
                                        </x-table.cell>
                                        <x-table.cell class="capitalize">
                                            {{ $material->created_at->translatedFormat( 'D j M Y H:i') }}
                                        </x-table.cell>
                                    </x-table.row>
                                @empty
                                    <x-table.row>
                                        <x-table.cell colspan="11">
                                            <div class="text-center p-2">
                                            <span class="text-muted">
                                                Aucun matériel trouvé pour la pièce détachée <span
                                                    class="font-bold">{{ $part->name }}</span>...
                                            </span>
                                            </div>
                                        </x-table.cell>
                                    </x-table.row>
                                @endforelse
                            </x-slot>
                        </x-table.table>

                        <div class="grid grid-cols-1">
                            {{ $materials->fragment('materials')->links() }}
                        </div>
                    </x-tab>


                    <x-tab name="part-entries" label="Entrées de Pièces" icon="fas-arrow-right-to-bracket">
                        <x-table.table class="mb-6">
                            <x-slot name="head">
                                <x-table.heading>#Id</x-table.heading>
                                <x-table.heading>Pièce Détachée</x-table.heading>
                                <x-table.heading>Entrée par</x-table.heading>
                                <x-table.heading>Nombre</x-table.heading>
                                <x-table.heading>Commande n°</x-table.heading>
                                <x-table.heading>Créé le</x-table.heading>
                            </x-slot>

                            <x-slot name="body">
                                @forelse($partEntries as $partEntry)
                                    <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $partEntry->getKey() }}">
                                        <x-table.cell>{{ $partEntry->getKey() }}</x-table.cell>
                                        <x-table.cell>
                                            <a class="link link-hover link-primary font-bold" href="{{ $partEntry->part->show_url }}">
                                                {{ $partEntry->part->name }}
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell>
                                            {{ $partEntry->user->full_name }}
                                        </x-table.cell>
                                        <x-table.cell>
                                            <code class="code rounded-sm">
                                                {{ $partEntry->number }}
                                            </code>
                                        </x-table.cell>
                                        <x-table.cell>
                                            @if ($partEntry->order_id)
                                                <code class="code rounded-sm">
                                                    {{ $partEntry->order_id}}
                                                </code>
                                            @endif
                                        </x-table.cell>
                                        <x-table.cell class="capitalize">
                                            {{ $partEntry->created_at->translatedFormat( 'D j M Y H:i') }}
                                        </x-table.cell>
                                    </x-table.row>
                                @empty
                                    <x-table.row>
                                        <x-table.cell colspan="17">
                                            <div class="text-center p-2">
                                                <span class="text-muted">Aucune entrée trouvée pour la pièce détachée {{ $part->name }}...</span>
                                            </div>
                                        </x-table.cell>
                                    </x-table.row>
                                @endforelse
                            </x-slot>
                        </x-table.table>

                        <div class="grid grid-cols-1">
                            {{ $partEntries->fragment('part-entries')->links() }}
                        </div>
                    </x-tab>

                    <x-tab name="part-exits" label="Sorties de Pièces" icon="fas-right-from-bracket">
                        <x-table.table class="mb-6">
                            <x-slot name="head">
                                <x-table.heading>#Id</x-table.heading>
                                <x-table.heading>Maintenance n°</x-table.heading>
                                <x-table.heading>Pièce Détachée</x-table.heading>
                                <x-table.heading>Sortie par</x-table.heading>
                                <x-table.heading>Description</x-table.heading>
                                <x-table.heading>Nombre</x-table.heading>
                                <x-table.heading>Prix (U)</x-table.heading>
                                <x-table.heading>Créé le</x-table.heading>
                            </x-slot>

                            <x-slot name="body">
                                @forelse($partExits as $partExit)
                                    <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $partExit->getKey() }}">
                                        <x-table.cell>{{ $partExit->getKey() }}</x-table.cell>
                                        <x-table.cell>
                                            @unless (is_null($partExit->maintenance))
                                                <a class="link link-hover link-primary tooltip tooltip-right" href="{{ $partExit->maintenance->show_url }}"  data-tip="Voir la fiche Maintenance">
                                                    <span class="font-bold">{{ $partExit->maintenance->getKey() }}</span>
                                                </a>
                                            @endunless
                                        </x-table.cell>
                                        <x-table.cell>
                                            <a class="link link-hover link-primary font-bold" href="{{ $partExit->part->show_url }}">
                                                {{ $partExit->part->name }}
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell>
                                            {{ $partExit->user->full_name }}
                                        </x-table.cell>
                                        <x-table.cell>
                                            <span class="tooltip tooltip-top" data-tip="{{ $part->description }}">
                                                {{ Str::limit($partExit->description, 50) }}
                                            </span>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <code class="code rounded-sm">
                                                {{ $partExit->number }}
                                            </code>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <code class="code rounded-sm">
                                                {{ $partExit->price }} €
                                            </code>
                                        </x-table.cell>
                                        <x-table.cell class="capitalize">
                                            {{ $partExit->created_at->translatedFormat( 'D j M Y H:i') }}
                                        </x-table.cell>
                                    </x-table.row>
                                @empty
                                    <x-table.row>
                                        <x-table.cell colspan="17">
                                            <div class="text-center p-2">
                                                <span class="text-muted">Aucune sortie trouvée pour la pièce détachée {{ $part->name }}...</span>
                                            </div>
                                        </x-table.cell>
                                    </x-table.row>
                                @endforelse
                            </x-slot>
                        </x-table.table>

                        <div class="grid grid-cols-1">
                            {{ $partExits->fragment('part-exits')->links() }}
                        </div>
                    </x-tab>
                </x-tabs>
            </div>
        </div>
    </section>
@endsection
