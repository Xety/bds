@extends('layouts.app')
{!! config(['app.title' => $material->name]) !!}

@push('meta')
    <x-meta title="{{ $material->name }}"/>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">
        <div class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-4 h-full">
                    <div class="col-span-12 xl:col-span-9 h-full">
                        <div class="flex flex-col text-center shadow-md border rounded-lg p-6 w-full h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <div class="w-full">
                                <div class="mb-4">
                                    <x-icon name="fas-microchip" class="h-12 w-12 m-auto"></x-icon>
                                </div>
                            </div>

                            <div class="w-full">
                                <h1 class="text-2xl xl:text-4xl font-bds pb-2 mx-5 xl:border-dotted xl:border-b xl:border-slate-500">
                                    {{ $material->name }}
                                </h1>
                                <p class="hidden xl:block py-2 mx-5 text-gray-400">
                                    {{ $material->description }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-3 h-full">
                        <div class="flex flex-col shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <div class="flex flex-col-reverse 2xl:flex-row justify-between">
                                <div class="text-2xl font-bold">
                                    <h2 class="mb-4">
                                        Informations
                                    </h2>
                                </div>
                                <div class="text-right">
                                    @if (
                                        Gate::any(['update', 'generateQrCode'], $material) ||
                                        Gate::any(['create'], \BDS\Models\Incident::class) ||
                                        Gate::any(['create'], \BDS\Models\Maintenance::class) ||
                                        Gate::any(['create'], \BDS\Models\Cleaning::class))
                                        <x-table.cell>
                                            <x-dropdown label="Actions" class="w-60" trigger-class="btn-neutral btn-sm" right bottom hover>
                                                @can('update', $material)
                                                    <x-menu-item
                                                        title="Modifier ce matériel"
                                                        icon="fas-pen-to-square"
                                                        icon-class="inline h-4 w-4"
                                                        tooltip
                                                        tooltip-content="Modifier ce matériel"
                                                        link="{{  route('materials.index', ['editId' => $material->getKey(), 'editing' => 'true']) }}"
                                                        class="text-blue-500" />
                                                @endcan
                                                @can('generateQrCode', $material)
                                                    <x-menu-item
                                                        title="Générer un QR Code"
                                                        icon="fas-qrcode"
                                                        tooltip
                                                        tooltip-content="Générer un QR Code pour ce matériel"
                                                        link="{{ route('materials.index', ['materialId' => $material->getKey(), 'qrcode' => 'true']) }}"
                                                        class="text-purple-500" />
                                                @endcan
                                                @can('create', \BDS\Models\Incident::class)
                                                    <x-menu-item
                                                        title="Créer un Incident"
                                                        icon="fas-triangle-exclamation"
                                                        tooltip
                                                        tooltip-content="Créer un incident pour ce matériel."
                                                        link="{{ route('incidents.index', ['materialId' => $material->getKey(), 'creating' => 'true']) }}"
                                                        class="text-red-500" />
                                                @endcan
                                                @can('create', \BDS\Models\Maintenance::class)
                                                    <x-menu-item
                                                        title="Créer une Maintenance"
                                                        icon="fas-screwdriver-wrench"
                                                        tooltip
                                                        tooltip-content="Créer une maintenance pour ce matériel."
                                                        link="{{ route('maintenances.index', ['materialId' => $material->getKey(), 'creating' => 'true']) }}"
                                                        class="text-yellow-500" />
                                                @endcan
                                                @can('create', \BDS\Models\Cleaning::class)
                                                    <x-menu-item
                                                        title="Créer un Nettoyage"
                                                        icon="fas-broom"
                                                        tooltip
                                                        tooltip-content="Créer un nettoyage pour ce matériel."
                                                        link="{{ route('cleanings.index', ['materialId' => $material->getKey(), 'creating' => 'true']) }}"
                                                        class="text-green-500" />
                                                @endcan
                                            </x-dropdown>
                                        </x-table.cell>
                                    @endif
                                </div>
                            </div>


                            <div class="grid grid-cols-12 gap-2 mb-4">
                                <div class="col-span-12 flex items-center">
                                    <div class="inline-block font-bold min-w-[140px]">Test PH :</div>
                                    <div class="inline-block">
                                        @if ($material->cleaning_test_ph_enabled)
                                            <code class="code rounded-sm">
                                                Activé
                                            </code>
                                        @else
                                            <code class="code rounded-sm">
                                                Désactivé
                                            </code>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-span-12 flex items-center">
                                    <div class="inline-block font-bold min-w-[140px]">Alerte de <br>Nettoyage :</div>
                                    <div class="inline-block">
                                        @if ($material->cleaning_alert)
                                            <code class="code rounded-sm">
                                                Activé
                                            </code>
                                        @else
                                            <code class="code rounded-sm">
                                                Désactivé
                                            </code>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-span-12 flex items-center">
                                    <div class="inline-block font-bold min-w-[140px]">Alerte par <br>Email :</div>
                                    <div class="inline-block">
                                        @if ($material->cleaning_alert_email)
                                            <code class="code rounded-sm">
                                                Activé
                                            </code>
                                        @else
                                            <code class="code rounded-sm">
                                                Désactivé
                                            </code>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-span-12 flex items-center">
                                    <div class="inline-block font-bold min-w-[140px]">Fréquence de <br>Nettoyage :</div>
                                    <div class="inline-block">
                                        @if ($material->cleaning_alert)
                                            <code class="code rounded-sm">
                                                {{ $material->cleaning_alert_frequency_repeatedly }}
                                            </code>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-span-12 flex items-center">
                                    <div class="inline-block font-bold min-w-[140px]">Type de <br>Fréquence :</div>
                                    <div class="inline-block">
                                        @if ($material->cleaning_alert)
                                            <code class="code rounded-sm">
                                                {{ collect(\BDS\Models\Material::CLEANING_TYPES)->sole('id', $material->cleaning_alert_frequency_type)['name'] }}
                                            </code>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-4 text-center h-full">
                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <x-icon name="fas-coins" class="text-primary h-16 w-16 m-auto"></x-icon>
                            <div>
                                <div class="text-muted text-xl">
                                    Zone
                                </div>
                                <p class="font-bold font-bds uppercase text-primary">
                                    {{ $material->zone->name }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <x-icon name="fas-triangle-exclamation" class="text-error h-16 w-16 m-auto"></x-icon>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ $material->incident_count }}
                                </div>
                                <p class="text-muted font-bds uppercase">
                                    Incident(s)
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <x-icon name="fas-screwdriver-wrench" class="text-warning h-16 w-16 m-auto"></x-icon>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ $material->maintenance_count }}
                                </div>
                                <p class="text-muted font-bds uppercase">
                                    Maintenance(s)
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <x-icon name="fas-gear" class="text-primary h-16 w-16 m-auto"></x-icon>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ $material->part_count }}
                                </div>
                                <p class="text-muted font-bds uppercase">
                                    Pièce(s) Détachée(s)
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <x-icon name="fas-broom" class="text-success h-16 w-16 m-auto"></x-icon>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ $material->cleaning_count }}
                                </div>
                                <p class="text-muted font-bds uppercase">
                                    Nettoyage(s)
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <x-icon name="fas-qrcode" class="text-purple-600 h-16 w-16 m-auto"></x-icon>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ $material->qrcode_flash_count }}
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
            <div class="col-span-12 shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">

                <x-tabs selected="incidents">
                    <x-tab name="incidents" label="Incidents" icon="fas-triangle-exclamation">
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
                                <x-table.heading>Résolu le</x-table.heading>
                            </x-slot>

                            <x-slot name="body">
                                @forelse($incidents as $incident)
                                    <x-table.row wire:loading.class.delay="opacity-50"
                                                 wire:key="row-{{ $incident->getKey() }}">
                                        <x-table.cell>{{ $incident->getKey() }}</x-table.cell>
                                        <x-table.cell>
                                            <a class="link link-hover link-primary font-bold"
                                               href="{{ $incident->material->show_url }}">
                                                {{ $incident->material->name }}
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell>{{ $incident->material->zone->name }}</x-table.cell>
                                        <x-table.cell>
                                            <a class="link link-hover link-primary font-bold" href="{{ $incident->user->show_url }}">
                                                {{ $incident->user->full_name }}
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell>
                                        <span class="tooltip tooltip-top" data-tip="{{ $incident->description }}">
                                            {{ Str::limit($incident->description, 50) }}
                                        </span>
                                        </x-table.cell>
                                        <x-table.cell
                                            class="capitalize">{{ $incident->started_at->translatedFormat( 'D j M Y H:i') }}</x-table.cell>
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
                                        <x-table.cell
                                            class="capitalize">{{ $incident->finished_at?->translatedFormat( 'D j M Y H:i') }}</x-table.cell>
                                    </x-table.row>
                                @empty
                                    <x-table.row>
                                        <x-table.cell colspan="11">
                                            <div class="text-center p-2">
                                            <span class="text-muted">
                                                Aucun incident trouvé pour le matériel <span
                                                    class="font-bold">{{ $material->name }}</span>...
                                            </span>
                                            </div>
                                        </x-table.cell>
                                    </x-table.row>
                                @endforelse
                            </x-slot>
                        </x-table.table>

                        <div class="grid grid-cols-1">
                            {{ $incidents->fragment('incidents')->links() }}
                        </div>
                    </x-tab>
                    <x-tab name="maintenances" label="Maintenances" icon="fas-screwdriver-wrench">
                        <x-table.table class="mb-6">
                            <x-slot name="head">
                                <x-table.heading>#Id</x-table.heading>
                                <x-table.heading>N° GMAO</x-table.heading>
                                <x-table.heading>Matériel</x-table.heading>
                                <x-table.heading>Description</x-table.heading>
                                <x-table.heading>Raison</x-table.heading>
                                <x-table.heading>Créateur</x-table.heading>
                                <x-table.heading>Fréquence</x-table.heading>
                                <x-table.heading>Réalisation</x-table.heading>
                                <x-table.heading>Commencée le</x-table.heading>
                                <x-table.heading>Finie le</x-table.heading>
                                <x-table.heading>Créée le</x-table.heading>
                            </x-slot>

                            <x-slot name="body">
                                @forelse($maintenances as $maintenance)
                                    <x-table.row wire:loading.class.delay="opacity-50"
                                                 wire:key="row-{{ $maintenance->getKey() }}">
                                        <x-table.cell>
                                            <a class="link link-hover link-primary tooltip tooltip-right"
                                               href="{{ $maintenance->show_url }}" data-tip="Voir la fiche Maintenance">
                                                <span class="font-bold">{{ $maintenance->getKey() }}</span>
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell>
                                            @unless (is_null($maintenance->gmao_id))
                                                <code class="code rounded-sm">
                                                    {{ $maintenance->gmao_id }}
                                                </code>
                                            @endunless
                                        </x-table.cell>
                                        <x-table.cell>
                                            @unless (is_null($maintenance->material_id))
                                                <a class="link link-hover link-primary font-bold"
                                                   href="{{ $maintenance->material->show_url }}">
                                                    {{ $maintenance->material->name }}
                                                </a>
                                            @endunless
                                        </x-table.cell>
                                        <x-table.cell>
                                        <span class="tooltip tooltip-top" data-tip="{{ $maintenance->description }}">
                                            {{ Str::limit($maintenance->description, 50) }}
                                        </span>
                                        </x-table.cell>
                                        <x-table.cell>
                                        <span class="tooltip tooltip-top" data-tip="{{ $maintenance->reason }}">
                                            {{ Str::limit($maintenance->reason, 50) }}
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
                                        <x-table.cell class="capitalize">
                                            {{ $maintenance->finished_at?->translatedFormat( 'D j M Y H:i') }}
                                        </x-table.cell>
                                        <x-table.cell class="capitalize">
                                            {{ $maintenance->created_at->translatedFormat( 'D j M Y H:i') }}
                                        </x-table.cell>
                                    </x-table.row>
                                @empty
                                    <x-table.row>
                                        <x-table.cell colspan="12">
                                            <div class="text-center p-2">
                                            <span class="text-muted">
                                                Aucune maintenance trouvée pour le matériel <span
                                                    class="font-bold">{{ $material->name }}</span>...
                                            </span>
                                            </div>
                                        </x-table.cell>
                                    </x-table.row>
                                @endforelse
                            </x-slot>
                        </x-table.table>

                        <div class="grid grid-cols-1">
                            {{ $maintenances->fragment('maintenances')->links() }}
                        </div>
                    </x-tab>
                    <x-tab name="parts" label="Pièces Détachées" icon="fas-gear">
                        <x-table.table class="mb-6">
                            <x-slot name="head">
                                <x-table.heading>#Id</x-table.heading>
                                <x-table.heading>Name</x-table.heading>
                                <x-table.heading>Site</x-table.heading>
                                <x-table.heading>Description</x-table.heading>
                                <x-table.heading>Référence</x-table.heading>
                                <x-table.heading>Fournisseur</x-table.heading>
                                <x-table.heading>Prix Unitaire</x-table.heading>
                                <x-table.heading>Nombre en stock</x-table.heading>
                                <x-table.heading>Alerte activée</x-table.heading>
                                <x-table.heading>Alerte critique activée</x-table.heading>
                                <x-table.heading>Nombre de pièces entrées</x-table.heading>
                                <x-table.heading>Nombre de pièces sorties</x-table.heading>
                                <x-table.heading>Créé le</x-table.heading>
                            </x-slot>

                            <x-slot name="body">
                                @forelse($parts as $part)
                                    <x-table.row wire:loading.class.delay="opacity-50"
                                                 wire:key="row-{{ $part->getKey() }}">
                                        <x-table.cell>{{ $part->getKey() }}</x-table.cell>
                                        <x-table.cell>
                                            <a class="link link-hover link-primary font-bold"
                                               href="{{ $part->show_url }}">
                                                {{ $part->name }}
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell>
                                            {{ $part->site->name }}
                                        </x-table.cell>
                                        <x-table.cell>
                                        <span class="tooltip tooltip-top" data-tip="{{ $part->description }}">
                                            {{ Str::limit($part->description, 50) }}
                                        </span>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <code class="code rounded-sm">
                                                {{ $part->reference }}
                                            </code>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <a class="link link-hover link-primary font-bold" href="{{ $part->supplier->show_url }}">
                                                {{ $part->supplier->name }}
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <code class="code rounded-sm">
                                                {{ $part->price }}€
                                            </code>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <code class="code rounded-sm">
                                                {{ $part->stock_total }}
                                            </code>
                                        </x-table.cell>
                                        <x-table.cell>
                                            @if ($part->number_warning_enabled)
                                                <span class="font-bold text-red-500">Oui</span>
                                            @else
                                                <span class="font-bold text-green-500">Non</span>
                                            @endif
                                        </x-table.cell>
                                        <x-table.cell>
                                            @if ($part->number_critical_enabled)
                                                <span class="font-bold text-red-500">Oui</span>
                                            @else
                                                <span class="font-bold text-green-500">Non</span>
                                            @endif
                                        </x-table.cell>
                                        <x-table.cell>
                                            <code class="code rounded-sm">
                                                {{ $part->part_entry_count }}
                                            </code>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <code class="code rounded-sm">
                                                {{ $part->part_exit_count }}
                                            </code>
                                        </x-table.cell>
                                        <x-table.cell
                                            class="capitalize">{{ $part->created_at->translatedFormat( 'D j M Y H:i') }}</x-table.cell>
                                    </x-table.row>
                                @empty
                                    <x-table.row>
                                        <x-table.cell colspan="17">
                                            <div class="text-center p-2">
                                            <span class="text-muted">
                                                Aucune pièce détachée trouvée pour le matériel <span
                                                    class="font-bold">{{ $material->name }}</span>...
                                            </span>
                                            </div>
                                        </x-table.cell>
                                    </x-table.row>
                                @endforelse
                            </x-slot>
                        </x-table.table>

                        <div class="grid grid-cols-1">
                            {{ $parts->fragment('parts')->links() }}
                        </div>
                    </x-tab>
                    <x-tab name="cleanings" label="Nettoyages" icon="fas-broom">
                        <x-table.table class="mb-6">
                            <x-slot name="head">
                                <x-table.heading>#Id</x-table.heading>
                                <x-table.heading>Matériel</x-table.heading>
                                <x-table.heading>Zone</x-table.heading>
                                <x-table.heading>Créateur</x-table.heading>
                                <x-table.heading>Description</x-table.heading>
                                <x-table.heading>Fréquence</x-table.heading>
                                <x-table.heading>PH de l'eau</x-table.heading>
                                <x-table.heading>PH de l'eau <br>après nettoyage</x-table.heading>
                                <x-table.heading>Créé le</x-table.heading>
                            </x-slot>

                            <x-slot name="body">
                                @forelse($cleanings as $cleaning)
                                    <x-table.row wire:loading.class.delay="opacity-50"
                                                 wire:key="row-{{ $cleaning->getKey() }}">
                                        <x-table.cell>{{ $cleaning->getKey() }}</x-table.cell>
                                        <x-table.cell>
                                            <a class="link link-hover link-primary font-bold"
                                               href="{{ $cleaning->material->show_url }}">
                                                {{ $cleaning->material->name }}
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell>
                                            {{ $cleaning->material->zone->name }}
                                        </x-table.cell>
                                        <x-table.cell>
                                            <a class="link link-hover text-primary font-bold" href="{{ route('users.show', $cleaning->user) }}">
                                                {{ $cleaning->user->full_name }}
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell>
                                        <span class="tooltip tooltip-top" data-tip="{{ $cleaning->description }}">
                                            {{ Str::limit($cleaning->description, 50) }}
                                        </span>
                                        </x-table.cell>
                                        <x-table.cell>
                                            {{ $cleaning->type->label() }}
                                        </x-table.cell>
                                        <x-table.cell>
                                            @if ($cleaning->type == 'weekly' && $cleaning->ph_test_water !== null)
                                                <code class="code rounded-sm">
                                                    @if ($cleaning->ph_test_water !== $cleaning->ph_test_water_after_cleaning)
                                                        <span class="font-bold text-red-500">
                                                        {{ $cleaning->ph_test_water }}
                                                    </span>
                                                    @else
                                                        <span class="font-bold text-green-500">
                                                        {{ $cleaning->ph_test_water }}
                                                    </span>
                                                    @endif
                                                </code>
                                            @endif
                                        </x-table.cell>
                                        <x-table.cell>
                                            @if ($cleaning->type == 'weekly' && $cleaning->ph_test_water_after_cleaning !== null)
                                                <code class="code rounded-sm">
                                                    @if ($cleaning->ph_test_water_after_cleaning !== $cleaning->ph_test_water)
                                                        <span class="font-bold text-red-500">
                                                        {{ $cleaning->ph_test_water_after_cleaning }}
                                                    </span>
                                                    @else
                                                        <span class="font-bold text-green-500">
                                                        {{ $cleaning->ph_test_water_after_cleaning }}
                                                    </span>
                                                    @endif
                                                </code>
                                            @endif
                                        </x-table.cell>
                                        <x-table.cell
                                            class="capitalize">{{ $cleaning->created_at->translatedFormat( 'D j M Y H:i') }}</x-table.cell>
                                    </x-table.row>
                                @empty
                                    <x-table.row>
                                        <x-table.cell colspan="11">
                                            <div class="text-center p-2">
                                            <span class="text-muted">
                                                Aucun nettoyage trouvé pour le matériel <span
                                                    class="font-bold">{{ $material->name }}</span>...
                                            </span>
                                            </div>
                                        </x-table.cell>
                                    </x-table.row>
                                @endforelse
                            </x-slot>
                        </x-table.table>

                        <div class="grid grid-cols-1">
                            {{ $cleanings->fragment('cleanings')->links() }}
                        </div>
                    </x-tab>
                </x-tabs>

            </div>
        </div>
    </section>
@endsection
