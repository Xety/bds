@extends('layouts.app')
{!! config(['app.title' => $supplier->name]) !!}

@push('meta')
    <x-meta title="{{ $supplier->name }}"/>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">
        <div class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-4 h-full">
                    <div class="col-span-12 xl:col-span-6 h-full">
                        <div class="flex flex-col text-center shadow-md border rounded-lg p-6 w-full h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <div class="w-full">
                                <div class="mb-4">
                                    <x-icon name="fas-shop" class="h-12 w-12 m-auto"></x-icon>
                                </div>
                            </div>

                            <div class="w-full">
                                <h1 class="text-2xl xl:text-4xl font-bds pb-2 mx-5 xl:border-dotted xl:border-b xl:border-slate-500">
                                    {{ $supplier->name }}
                                </h1>
                                <p class="hidden xl:block py-2 mx-5 text-gray-400">
                                    {{ $supplier->description }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-6 h-full">
                        <div class="flex flex-col items-center text-center shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <x-icon name="fas-gear" class="text-warning h-16 w-16 m-auto"></x-icon>
                            <div>
                                <div class="font-bold text-2xl">
                                    {{ $supplier->part_count }}
                                </div>
                                <p class="text-muted font-bds uppercase">
                                    Pièce(s) Détachée(s)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6 mb-7">
            <div class="col-span-12 shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                <x-table.table class="mb-6">
                    <x-slot name="head">
                        <x-table.heading>#Id</x-table.heading>
                        <x-table.heading>Name</x-table.heading>
                        <x-table.heading>Site</x-table.heading>
                        <x-table.heading>Description</x-table.heading>
                        <x-table.heading>Référence</x-table.heading>
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
                                        Aucune pièce détachée trouvée pour le fournisseur <span
                                            class="font-bold">{{ $supplier->name }}</span>...
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

            </div>
        </div>
    </section>
@endsection
