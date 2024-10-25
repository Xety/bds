@extends('layouts.app')
{!! config(['app.title' => 'Maintenance N° ' . $maintenance->getKey()]) !!}

@push('meta')
    <x-meta title="{{ 'Maintenance N° ' . $maintenance->getKey() }}" />
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <section class="m-3 lg:m-10">
        <hgroup class="text-center px-5 pb-5">
            <h1 class="text-4xl font-selvah">
                <x-icon name="fas-screwdriver-wrench" class="h-10 w-10 inline"></x-icon> Maintenance N°
                <span class="prose text-4xl">
                    <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                        {{ $maintenance->getKey() }}
                    </code>
                </span>
            </h1>
        </hgroup>

        <div class="flex flex-col shadow-md border rounded-lg p-6 w-full h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">

            <div class="grid grid-cols-12 gap-4 mb-4 2xl:mb-8 h-full">
                <div class="col-span-12 md:col-span-6 2xl:col-span-4">
                    <div class="inline-block font-bold min-w-[120px]">N° GMAO : </div>
                    <div class="inline-block prose">
                        <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                            @if ($maintenance->gmao_id)
                                {{ $maintenance->gmao_id }}
                            @else
                                Aucune
                            @endif
                        </code>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6 2xl:col-span-4">
                    <div class="inline-block font-bold min-w-[120px]">Matériel : </div>
                    <div class="inline-block">
                        @if ($maintenance->material_id)
                            <a class="link link-hover link-primary font-bold" href="{{ $maintenance->material->show_url }}">
                                {{ $maintenance->material->name }}
                            </a>
                        @else
                            <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                Aucun
                            </code>
                        @endif
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6 2xl:col-span-4">
                    <div class="inline-block font-bold min-w-[120px]">Créé par : </div>
                    <div class="inline-block">
                        <a class="link link-hover text-primary font-bold" href="{{ route('users.show', $maintenance->user) }}">
                            {{ $maintenance->user->full_name }}
                        </a>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6 2xl:col-span-4">
                    <div class="inline-block font-bold min-w-[120px]">Type : </div>
                    <div class="inline-block prose">
                        <code class="{{ $maintenance->type->color() }} bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                            {{ $maintenance->type->label() }}
                        </code>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6 2xl:col-span-4">
                    <div class="inline-block font-bold min-w-[120px]">Réalisation : </div>
                    <div class="inline-block prose">
                        <code class="{{ $maintenance->realization->color() }} bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                            {{ $maintenance->realization->label() }}
                        </code>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6 2xl:col-span-4">
                    <div class="inline-block font-bold min-w-[120px]">Opérateurs : </div>
                    <div class="inline-block">
                        @forelse ($maintenance->operators as $operator)
                            <a class="link link-hover text-primary font-bold" href="{{ route('users.show', $operator) }}">
                                {{ $operator->full_name }}
                            </a>@if (!$loop->last),@endif
                        @empty
                            <span class="text-gray-400">Aucun</span>
                        @endforelse
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6 2xl:col-span-4">
                    <div class="inline-block font-bold min-w-[120px]">Commencée le : </div>
                    <div class="inline-block prose">
                        <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm capitalize">
                            {{ $maintenance->started_at?->translatedFormat( 'D j M Y H:i') }}
                        </code>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6 2xl:col-span-4">
                    <div class="inline-block font-bold min-w-[120px]">Finie le : </div>
                    <div class="inline-block prose">
                        @if($maintenance->finished_at)
                            <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm capitalize">
                                {{ $maintenance->finished_at?->translatedFormat( 'D j M Y H:i') }}
                            </code>
                        @endif
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6 2xl:col-span-4">
                    <div class="inline-block font-bold min-w-[120px]">Terminée : </div>
                    <div class="inline-block prose">
                        @if (is_null($maintenance->finished_at))
                            <code class="text-red-500 bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                Non
                            </code>
                        @else
                            <code class="text-green-500 bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                Oui
                            </code>
                        @endif
                    </div>
                </div>

                <div class="col-span-12">
                    <div class="font-bold">Entreprise(s) extérieure(s) intervenue(s): </div>
                    <div>
                        @forelse ($maintenance->companies as $company)
                            <a class="link link-hover link-primary tooltip tooltip-right" href="{{ $company->show_url }}"  data-tip="Voir la fiche Entreprise"><span class="font-bold">{{ $company->name }}</span></a>@if (!$loop->last),@endif
                        @empty
                            <span class="text-gray-400">Aucune</span>
                        @endforelse
                    </div>
                </div>

                <div class="col-span-12">
                    <div class="font-bold">Description : </div>
                    <div>
                        {{ $maintenance->description }}
                    </div>
                </div>

                <div class="col-span-12">
                    <div class="font-bold">Raison : </div>
                    <div>
                        {{ $maintenance->reason }}
                    </div>
                </div>

                <div class="col-span-12">
                    <x-tabs selected="part-exits">
                        <x-tab name="part-exits" label="Pièce(s) détachée(s) sortie(s) du stock" icon="fas-gear">
                            <x-table.table class="mb-6">
                                <x-slot name="head">
                                    <x-table.heading>#Id</x-table.heading>
                                    <x-table.heading>Maintenance n°</x-table.heading>
                                    <x-table.heading>Pièce Détachée</x-table.heading>
                                    <x-table.heading>Référence</x-table.heading>
                                    <x-table.heading>Sortie par</x-table.heading>
                                    <x-table.heading>Description</x-table.heading>
                                    <x-table.heading>Nombre</x-table.heading>
                                    <x-table.heading>Prix Unitaire</x-table.heading>
                                    <x-table.heading>Prix Total</x-table.heading>
                                    <x-table.heading>Créé le</x-table.heading>
                                </x-slot>

                                <x-slot name="body">
                                    @forelse($partExits as $partExit)
                                        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $partExit->getKey() }}">
                                            <x-table.cell>{{ $partExit->getKey() }}</x-table.cell>
                                            <x-table.cell>
                                                <a class="link link-hover link-primary tooltip tooltip-right" href="{{ $maintenance->show_url }}"  data-tip="Voir la fiche Maintenance">
                                                    <span class="font-bold">{{ $maintenance->getKey() }}</span>
                                                </a>
                                            </x-table.cell>
                                            <x-table.cell>
                                                <a class="link link-hover link-primary font-bold" href="{{ $partExit->part->show_url }}">
                                                    {{ $partExit->part->name }}
                                                </a>
                                            </x-table.cell>
                                            <x-table.cell class="prose">
                                                <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                                    {{ $partExit->part->reference }}
                                                </code>
                                            </x-table.cell>
                                            <x-table.cell>
                                                <a class="link link-hover link-primary font-bold" href="{{ $partExit->user->show_url }}">
                                                    {{ $partExit->user->full_name }}
                                                </a>
                                            </x-table.cell>
                                            <x-table.cell>
                                            <span class="tooltip tooltip-top" data-tip="{{ $partExit->description }}">
                                                {{ Str::limit($partExit->description, 50) }}
                                            </span>
                                            </x-table.cell>
                                            <x-table.cell class="prose">
                                                <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                                    {{ $partExit->number }}
                                                </code>
                                            </x-table.cell>
                                            <x-table.cell class="prose">
                                                <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                                    {{ $partExit->price }} €
                                                </code>
                                            </x-table.cell>
                                            <x-table.cell class="prose">
                                                <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                                    {{ number_format($partExit->number * $partExit->price, 2) }} €
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
                                                    <span class="text-muted">Aucune sortie de pièce détachée trouvée pour cette maintenance...</span>
                                                </div>
                                            </x-table.cell>
                                        </x-table.row>
                                    @endforelse
                                    @if($partExits->isNotEmpty())
                                            <x-table.row>
                                                <x-table.cell></x-table.cell>
                                                <x-table.cell></x-table.cell>
                                                <x-table.cell></x-table.cell>
                                                <x-table.cell></x-table.cell>
                                                <x-table.cell></x-table.cell>
                                                <x-table.cell></x-table.cell>
                                                <x-table.cell></x-table.cell>
                                                <x-table.cell></x-table.cell>
                                                <x-table.cell class="prose">
                                                    <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                                                        {{ $partCount }} €
                                                    </code>
                                                </x-table.cell>
                                                <x-table.cell></x-table.cell>
                                            </x-table.row>
                                    @endif
                                </x-slot>
                            </x-table.table>

                            <div class="grid grid-cols-1">
                                {{ $partExits->fragment('partExits')->links() }}
                            </div>
                        </x-tab>


                        <x-tab name="incidents" label="Incident(s)" icon="fas-triangle-exclamation">
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
                                                <span class="font-bold {{ $incident->impact->color() }}">
                                                    {{ $incident->impact->label() }}
                                                </span>
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
                                                Aucun incident trouvé pour cette maintenance...
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
                    </x-tabs>
                </div>
            </div>

        </div>
    </section>
@endsection
