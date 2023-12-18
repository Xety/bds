@extends('layouts.app')
{!! config(['app.title' => $part->name]) !!}

@push('meta')
    <x-meta title="{{ $part->name }}" />
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <section class="m-3 lg:m-10">
        <div class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-4 h-full">
                    <div class="col-span-12 xl:col-span-7 h-full">
                        <div class="flex flex-col text-center shadow-md border rounded-lg p-6 w-full h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <div class="w-full">
                                <div class="text-5xl m-2 mb-4">
                                    <x-icon name="fas-microchip" class="h-12 w-12 m-auto"></x-icon>
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

                    <div class="col-span-12 xl:col-span-5 h-full">
                        <div class="flex flex-col shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <div class="flex flex-col-reverse 2xl:flex-row justify-between">
                                <div class="text-2xl font-bold">
                                    <h2 class="mb-4">
                                        Informations
                                    </h2>
                                </div>
                                <div class="text-right">
                                    @if (
                                        Gate::any(['update', 'generateQrCode'], \BDS\Models\Part::class) ||
                                        Gate::any(['create'], \BDS\Models\PartEntry::class) ||
                                        Gate::any(['create'], \BDS\Models\PartExit::class))
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
                                                    link="{{ route('parts.index', ['qrcodeId' => $part->getKey(), 'qrcode' => 'true']) }}"
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
                <div class="grid grid-cols-12 gap-4 text-center h-full">
                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <x-icon name="fas-shop" class="text-primary h-16 w-16 m-auto"></x-icon>
                            <div>
                                <div class="text-muted text-xl">
                                    Fournisseur
                                </div>
                                <p class="font-bold font-selvah uppercase">
                                    @unless(is_null($part->supplier_id))
                                        <a class="link link-hover link-primary font-bold" href="{{ $part->supplier->show_url }}">
                                            {{ $part->supplier->name }}
                                        </a>
                                    @endunless
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
                                <p class="text-muted font-selvah uppercase">
                                    Nombre(s) en stock
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <i class="fa-solid fa-euro text-info text-8xl"></i>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ number_format($part->stock_total * $part->price) }}€
                                </div>
                                <p class="text-muted font-selvah uppercase">
                                    Prix des pièces en stock
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <i class="fa-solid fa-arrow-right-to-bracket text-warning text-8xl"></i>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ $part->part_entry_count }}
                                </div>
                                <p class="text-muted font-selvah uppercase">
                                    Entrée(s) de pièce(s)
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <i class="fa-solid fa-right-from-bracket text-error text-8xl"></i>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ $part->part_exit_count }}
                                </div>
                                <p class="text-muted font-selvah uppercase">
                                    Sortie(s) de pièce(s)
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-2 h-full">
                        <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <i class="fa-solid fa-qrcode text-purple-600 text-8xl"></i>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ $part->qrcode_flash_count }}
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
            <div class="col-span-12 border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">

                <part-tabs>
                    <template v-slot:part-entries>
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
                                        <x-table.cell>{{ $partEntry->user->username }}</x-table.cell>
                                        <x-table.cell class="prose">
                                            <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                                {{ $partEntry->number }}
                                            </code>
                                        </x-table.cell>
                                        <x-table.cell class="prose">
                                            @if ($partEntry->order_id)
                                                <code class="text-neutral-content  bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
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
                            {{ $partEntries->fragment('partEntries')->links() }}
                        </div>
                    </template>

                    <template v-slot:part-exits>
                        <x-table.table class="mb-6">
                            <x-slot name="head">
                                <x-table.heading>#Id</x-table.heading>
                                <x-table.heading>Maintenance n°</x-table.heading>
                                <x-table.heading>Pièce Détachée</x-table.heading>
                                <x-table.heading>Sortie par</x-table.heading>
                                <x-table.heading>Description</x-table.heading>
                                <x-table.heading>Nombre</x-table.heading>
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
                                        <x-table.cell>{{ $partExit->user->username }}</x-table.cell>
                                        <x-table.cell>
                                            <span class="tooltip tooltip-top" data-tip="{{ $part->description }}">
                                                {{ Str::limit($partExit->description, 50) }}
                                            </span>
                                        </x-table.cell>
                                        <x-table.cell class="prose">
                                            <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                                {{ $partExit->number }}
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
                            {{ $partExits->fragment('partExits')->links() }}
                        </div>
                    </template>
                </part-tabs>

            </div>
        </div>
    </section>
@endsection
