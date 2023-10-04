@extends('layouts.app')
{!! config(['app.title' => $material->name]) !!}

@push('meta')
    <x-meta title="{{ $material->name }}" />
@endpush

@section('content')
<x-breadcrumbs :breadcrumbs="$breadcrumbs" />

<section class="m-3 lg:m-10">
    <div class="grid grid-cols-12 gap-4 mb-4">
        <div class="col-span-12">
            <div class="grid grid-cols-12 gap-4 h-full">
                <div class="col-span-12 xl:col-span-9 h-full">
                    <div class="flex flex-col text-center shadow-md border rounded-lg p-6 w-full h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                        <div class="w-full">
                            <div class="text-5xl m-2 mb-4">
                                <i class="fa-solid fa-microchip"></i>
                            </div>
                        </div>

                        <div class="w-full">
                            <h1 class="text-2xl xl:text-4xl font-selvah pb-2 mx-5 xl:border-dotted xl:border-b xl:border-slate-500">
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
                                    Gate::any(['update', 'generateQrCode'], \Selvah\Models\Material::class) ||
                                    Gate::any(['create'], \Selvah\Models\Incident::class) ||
                                    Gate::any(['create'], \Selvah\Models\Maintenance::class) ||
                                    Gate::any(['create'], \Selvah\Models\Cleaning::class))
                                    <div class="dropdown dropdown-end">
                                        <label tabindex="0" class="btn btn-neutral mb-2">
                                            Actions
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                                                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                            </svg>
                                        </label>
                                        <ul tabindex="0" class="dropdown-content menu items-start p-2 shadow bg-base-100 rounded-box w-56 z-[1]">
                                            @can('update', \Selvah\Models\Material::class)
                                                <li class="w-full">
                                                    <a href="{{ route('materials.index', ['editid' => $material->getKey(), 'edit' => 'true']) }}" class="text-blue-500 tooltip tooltip-top text-left" data-tip="Modifier ce matériel">
                                                        <i class="fa-solid fa-pen-to-square"></i> Modifier ce matériel
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('generateQrCode', \Selvah\Models\Material::class)
                                                <li class="w-full">
                                                    <a href="{{ route('materials.index', ['qrcodeid' => $material->getKey(), 'qrcode' => 'true']) }}" class="text-purple-500 tooltip tooltip-top text-left" data-tip="Générer un QR Code pour ce matériel">
                                                        <i class="fa-solid fa-qrcode"></i> Générer un QR Code
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('create', \Selvah\Models\Incident::class)
                                                <li class="w-full">
                                                    <a href="{{ route('incidents.index', ['qrcodeid' => $material->getKey(), 'qrcode' => 'true']) }}" class="text-red-500 tooltip tooltip-top text-left" data-tip="Créer un incident pour ce matériel.">
                                                        <i class="fa-solid fa-triangle-exclamation"></i> Créer un Incident
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('create', \Selvah\Models\Maintenance::class)
                                                <li class="w-full">
                                                    <a href="{{ route('maintenances.index', ['qrcodeid' => $material->getKey(), 'qrcode' => 'true']) }}" class="text-yellow-500 tooltip tooltip-top text-left" data-tip="Créer une maintenance pour ce matériel.">
                                                        <i class="fa-solid fa-screwdriver-wrench"></i> Créer une Maintenance
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('create', \Selvah\Models\Cleaning::class)
                                                <li class="w-full">
                                                    <a href="{{ route('cleanings.index', ['qrcodeid' => $material->getKey(), 'qrcode' => 'true']) }}" class="text-green-500 tooltip tooltip-top text-left" data-tip="Créer un nettoyage pour ce matériel.">
                                                        <i class="fa-solid fa-broom"></i> Créer un Nettoyage
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class="grid grid-cols-12 gap-2 mb-4">
                            <div class="col-span-12">
                                <div class="inline-block font-bold min-w-[140px]">Test PH : </div>
                                <div class="inline-block prose">
                                    @if ($material->cleaning_test_ph_enabled)
                                        <code class="font-bold text-red-500 bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                            Activé
                                        </code>
                                    @else
                                        <code class="font-bold text-green-500 bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                            Désactivé
                                        </code>
                                    @endif
                                </div>
                            </div>

                            <div class="col-span-12 flex items-center">
                                <div class="inline-block font-bold min-w-[140px]">Alerte de <br>Nettoyage : </div>
                                <div class="inline-block prose">
                                    @if ($material->cleaning_alert)
                                        <code class="font-bold text-red-500 bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                            Activé
                                        </code>
                                    @else
                                        <code class="font-bold text-green-500 bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                            Désactivé
                                        </code>
                                    @endif
                                </div>
                            </div>

                            <div class="col-span-12 flex items-center">
                                <div class="inline-block font-bold min-w-[140px]">Alerte par <br>Email : </div>
                                <div class="inline-block prose">
                                    @if ($material->cleaning_alert_email)
                                        <code class="font-bold text-red-500 bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                            Activé
                                        </code>
                                    @else
                                        <code class="font-bold text-green-500 bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                            Désactivé
                                        </code>
                                    @endif
                                </div>
                            </div>

                            <div class="col-span-12 flex items-center">
                                <div class="inline-block font-bold min-w-[140px]">Fréquence de <br>Nettoyage : </div>
                                <div class="inline-block prose">
                                    @if ($material->cleaning_alert)
                                        <code class="font-bold text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                            {{ $material->cleaning_alert_frequency_repeatedly }}
                                        </code>
                                    @endif
                                </div>
                            </div>

                            <div class="col-span-12 flex items-center">
                                <div class="inline-block font-bold min-w-[140px]">Type de <br>Fréquence : </div>
                                <div class="inline-block prose">
                                    @if ($material->cleaning_alert)
                                        <code class="font-bold text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                            {{ $material->cleaning_alert_frequency_type }}
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
                        <i class="fa-solid fa-coins text-primary text-8xl"></i>
                        <div>
                            <div class="text-muted text-xl">
                                Zone
                            </div>
                            <p class="font-bold font-selvah uppercase text-primary">
                                {{ $material->zone->name }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-2 h-full">
                    <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                        <i class="fa-solid fa-triangle-exclamation text-[color:hsl(var(--er))] text-8xl"></i>
                        <div>
                            <div class="font-bold text-2xl">
                                 {{ $material->incident_count }}
                            </div>
                            <p class="text-muted font-selvah uppercase">
                                Incident(s)
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-2 h-full">
                    <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                        <i class="fa-solid fa-screwdriver-wrench text-[color:hsl(var(--wa))] text-8xl"></i>
                        <div>
                            <div class="font-bold text-2xl">
                                {{ $material->maintenance_count }}
                            </div>
                            <p class="text-muted font-selvah uppercase">
                                Maintenance(s)
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-2 h-full">
                    <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                        <i class="fa-solid fa-gear text-primary text-8xl"></i>
                        <div>
                            <div class="font-bold text-2xl">
                                {{ $material->part_count }}
                            </div>
                            <p class="text-muted font-selvah uppercase">
                                Pièce(s) Détachée(s)
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-2 h-full">
                    <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                        <i class="fa-solid fa-broom text-success text-8xl"></i>
                        <div>
                            <div class="font-bold text-2xl">
                                {{ $material->cleaning_count }}
                            </div>
                            <p class="text-muted font-selvah uppercase">
                                Nettoyage(s)
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-2 h-full">
                    <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                        <i class="fa-solid fa-qrcode text-purple-600 text-8xl"></i>
                        <div>
                            <div class="font-bold text-2xl">
                                {{ $material->qrcode_flash_count }}
                            </div>
                            <p class="text-muted font-selvah uppercase">
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


            <material-tabs>
                {{-- INCIDENTS --}}
                <template v-slot:incidents>
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
                                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $incident->getKey() }}">
                                    <x-table.cell>{{ $incident->getKey() }}</x-table.cell>
                                    <x-table.cell>
                                        <a class="link link-hover link-primary font-bold" href="{{ $incident->material->show_url }}">
                                            {{ $incident->material->name }}
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell>{{ $incident->material->zone->name }}</x-table.cell>
                                    <x-table.cell>{{ $incident->user->username }}</x-table.cell>
                                    <x-table.cell>
                                        <span class="tooltip tooltip-top" data-tip="{{ $incident->description }}">
                                            {{ Str::limit($incident->description, 50) }}
                                        </span>
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
                                    <x-table.cell class="capitalize">{{ $incident->finished_at?->translatedFormat( 'D j M Y H:i') }}</x-table.cell>
                                </x-table.row>
                            @empty
                                <x-table.row>
                                    <x-table.cell colspan="11">
                                        <div class="text-center p-2">
                                            <span class="text-muted">
                                                Aucun incident trouvé pour le matériel <span class="font-bold">{{ $material->name }}</span>...
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
                </template>

                {{-- MAINTENANCES --}}
                <template v-slot:maintenances>
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
                            <x-table.heading>Finie le</x-table.heading>
                            <x-table.heading>Créée le</x-table.heading>
                        </x-slot>

                        <x-slot name="body">
                            @forelse($maintenances as $maintenance)
                                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $maintenance->getKey() }}">
                                    <x-table.cell>
                                        <a class="link link-hover link-primary tooltip tooltip-right" href="{{ $maintenance->show_url }}"  data-tip="Voir la fiche Maintenance">
                                            <span class="font-bold">{{ $maintenance->getKey() }}</span>
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell class="prose">
                                        @unless (is_null($maintenance->gmao_id))
                                            <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                            {{ $maintenance->gmao_id }}
                                        </code>
                                        @endunless
                                    </x-table.cell>
                                    <x-table.cell class="prose">
                                        @unless (is_null($maintenance->material_id))
                                            <a class="link link-hover link-primary font-bold" href="{{ $maintenance->material->show_url }}">
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
                                    <x-table.cell>{{ $maintenance->user->username }}</x-table.cell>
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
                                                Aucune maintenance trouvée pour le matériel <span class="font-bold">{{ $material->name }}</span>...
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
                </template>

                {{-- PARTS --}}
                <template v-slot:parts>
                    <x-table.table class="mb-6">
                        <x-slot name="head">
                            <x-table.heading>#Id</x-table.heading>
                            <x-table.heading>Name</x-table.heading>
                            <x-table.heading>Matériel</x-table.heading>
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
                                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $part->getKey() }}">
                                    <x-table.cell>{{ $part->getKey() }}</x-table.cell>
                                    <x-table.cell>
                                        <a class="link link-hover link-primary font-bold" href="{{ $part->show_url }}">
                                            {{ $part->name }}
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell>{{ $part->material->name }}</x-table.cell>
                                    <x-table.cell>
                                        <span class="tooltip tooltip-top" data-tip="{{ $part->description }}">
                                            {{ Str::limit($part->description, 50) }}
                                        </span>
                                    </x-table.cell>
                                    <x-table.cell class="prose">
                                        <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                            {{ $part->reference}}
                                        </code>
                                    </x-table.cell>
                                    <x-table.cell>{{ $part->supplier }}</x-table.cell>
                                    <x-table.cell class="prose">
                                        <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                            {{ $part->price }}€
                                        </code>
                                    </x-table.cell>
                                    <x-table.cell class="prose">
                                        <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
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
                                    <x-table.cell class="prose">
                                        <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                            {{ $part->part_entry_count }}
                                        </code>
                                    </x-table.cell>
                                    <x-table.cell class="prose">
                                        <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                            {{ $part->part_exit_count }}
                                        </code>
                                    </x-table.cell>
                                    <x-table.cell class="capitalize">{{ $part->created_at->translatedFormat( 'D j M Y H:i') }}</x-table.cell>
                                </x-table.row>
                            @empty
                                <x-table.row>
                                    <x-table.cell colspan="17">
                                        <div class="text-center p-2">
                                            <span class="text-muted">
                                                Aucune pièce détachée trouvée pour le matériel <span class="font-bold">{{ $material->name }}</span>...
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
                </template>

                {{-- CLEANINGS --}}
                <template v-slot:cleanings>
                    <x-table.table class="mb-6">
                        <x-slot name="head">
                            <x-table.heading>#Id</x-table.heading>
                            <x-table.heading>Matériel</x-table.heading>
                            <x-table.heading>Zone</x-table.heading>
                            <x-table.heading>Créateur</x-table.heading>
                            <x-table.heading>Description</x-table.heading>
                            <x-table.heading>Type</x-table.heading>
                            <x-table.heading>PH de l'eau</x-table.heading>
                            <x-table.heading>PH de l'eau <br>après nettoyage</x-table.heading>
                            <x-table.heading>Créé le</x-table.heading>
                        </x-slot>

                        <x-slot name="body">
                            @forelse($cleanings as $cleaning)
                                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $cleaning->getKey() }}">
                                    <x-table.cell>{{ $cleaning->getKey() }}</x-table.cell>
                                    <x-table.cell>
                                        <a class="link link-hover link-primary font-bold" href="{{ $cleaning->material->show_url }}">
                                            {{ $cleaning->material->name }}
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell>{{ $cleaning->material->zone->name }}</x-table.cell>
                                    <x-table.cell>{{ $cleaning->user->username }}</x-table.cell>
                                    <x-table.cell>
                                        <span class="tooltip tooltip-top" data-tip="{{ $cleaning->description }}">
                                            {{ Str::limit($cleaning->description, 50) }}
                                        </span>
                                    </x-table.cell>
                                    <x-table.cell class="capitalize">{{ \Selvah\Models\Cleaning::TYPES[$cleaning->type] }}</x-table.cell>
                                    <x-table.cell class="prose">
                                        @if ($cleaning->type == 'weekly' && $cleaning->ph_test_water !== null)
                                            <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
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
                                    <x-table.cell class="prose">
                                        @if ($cleaning->type == 'weekly' && $cleaning->ph_test_water_after_cleaning !== null)
                                            <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
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
                                    <x-table.cell class="capitalize">{{ $cleaning->created_at->translatedFormat( 'D j M Y H:i') }}</x-table.cell>
                                </x-table.row>
                            @empty
                                <x-table.row>
                                    <x-table.cell colspan="11">
                                        <div class="text-center p-2">
                                            <span class="text-muted">
                                                Aucun nettoyage trouvé pour le matériel <span class="font-bold">{{ $material->name }}</span>...
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
                </template>
            </material-tabs>

        </div>
    </div>
</section>
@endsection
