@extends('layouts.app')
{!! config(['app.title' => $company->name]) !!}

@push('meta')
    <x-meta title="{{ $company->name }}"/>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">
        <div class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-12 xl:col-span-5">
                <div class="flex flex-col text-center shadow-md border rounded-lg p-6 w-full h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <div class="w-full">
                        <div class="mb-4">
                            <x-icon name="fas-briefcase" class="h-12 w-12 m-auto"></x-icon>
                        </div>
                    </div>

                    <div class="w-full">
                        <h1 class="text-2xl xl:text-4xl font-bds pb-2 mx-5 xl:border-dotted xl:border-b xl:border-slate-500">
                            {{ $company->name }}
                        </h1>
                        <p class="hidden xl:block py-2 mx-5 text-gray-400">
                            {{ $company->description }}
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
                            @if ($company->site->id == settings('site_id_selvah'))
                                <img src="{{ asset('images/logos/selvah.png') }}" alt="Selvah Logo" class="inline-block w-20">
                            @elseif ($company->site->id == settings('site_id_extrusel'))
                                <img src="{{ asset('images/logos/extrusel.png') }}" alt="Extrusel Logo" class="inline-block w-28">
                            @elseif ($company->site->id == settings('site_id_moulin_jannet'))
                                <img src="{{ asset('images/logos/moulin_jannet.png') }}" alt="Moulin Jannet Logo" class="inline-block w-16">
                            @elseif ($company->site->id == settings('site_id_val_union'))
                                <img src="{{ asset('images/logos/bfc_val_union.png') }}" alt="BFC Val Union Logo" class="inline-block dark:hidden h-14">
                                <img src="{{ asset('images/logos/bfc_val_union_blanc.png') }}" alt="BFC Val Union Logo" class="hidden dark:inline-block h-14">
                            @else
                                <img src="{{ asset('images/logos/cbds_324x383.png') }}" alt="Coopérative Bourgogne du Sud Logo" class="inline-block w-20">
                            @endif
                        </figure>
                        <div class="font-bold text-xl">
                            {{ $company->site->name }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-5">
                <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full text-center border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <x-icon name="fas-screwdriver-wrench" class="text-warning h-16 w-16 m-auto"></x-icon>
                    <div>
                        <div class="font-bold text-2xl">
                            {{ $company->maintenances->count() }}
                        </div>
                        <p class="text-muted font-bds uppercase">
                            Maintenance(s)
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-12 gap-6 mb-7">
            <div
                class="col-span-12 border shadow-md rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                <div class="w-full">
                    <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
                        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                            <a class="text-xs font-bold uppercase px-5 py-3 shadow-md rounded block leading-normal cursor-pointer text-white bg-neutral dark:text-neutral dark:bg-white"
                               href="#">
                                <x-icon name="fas-screwdriver-wrench" class="h-4 w-4 mr-2 inline"></x-icon>Maintenances
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="text-center mx-auto">
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
                                <x-table.row wire:loading.class.delay="opacity-50"
                                             wire:key="row-{{ $maintenance->getKey() }}">
                                    <x-table.cell>
                                        <a class="link link-hover link-primary tooltip tooltip-right text-left"
                                           href="{{ $maintenance->show_url }}" data-tip="Voir la fiche Maintenance">
                                            <span class="font-bold">#{{ $maintenance->getKey() }}</span>
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell>
                                        @unless (is_null($maintenance->gmao_id))
                                            <code
                                                class="code rounded-sm">
                                                {{ $maintenance->gmao_id }}
                                            </code>
                                        @endunless
                                    </x-table.cell>
                                    <x-table.cell>
                                        @unless (is_null($maintenance->material_id))
                                            <a class="link link-hover link-primary font-bold"
                                               href="{{ route('materials.show', $maintenance->material) }}">
                                                {{ $maintenance->material->name }}
                                            </a>
                                        @endunless
                                    </x-table.cell>
                                    <x-table.cell>
                                    <span class="tooltip tooltip-top text-left"
                                          data-tip="{{ $maintenance->description }}">
                                        {{ Str::limit($maintenance->description, 50) }}
                                    </span>
                                    </x-table.cell>
                                    <x-table.cell>
                                    <span class="tooltip tooltip-top" data-tip="{{ $maintenance->reason }}">
                                        {{ Str::limit($maintenance->reason, 50) }}
                                    </span>
                                    </x-table.cell>
                                    <x-table.cell><a class="link link-hover link-primary font-bold" href="{{ $maintenance->user->show_url }}">
                                            {{ $maintenance->user->full_name }}
                                        </a></x-table.cell>
                                    <x-table.cell>
                                        <span class="font-bold {{ $maintenance->type->color() }}">
                                            {{ $maintenance->type->label() }}
                                        </span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="font-bold {{ $maintenance->realization->color() }}">
                                            {{ $maintenance->realization->label() }}
                                        </span>
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
                                            Aucune maintenance trouvée pour cette entreprise...
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
                </div>

            </div>
        </div>
    </section>
@endsection
