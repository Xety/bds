@extends('layouts.app')
{!! config(['app.title' => $company->name]) !!}

@push('meta')
    <x-meta title="{{ $company->name }}" />
@endpush

@section('content')
<x-breadcrumbs :breadcrumbs="$breadcrumbs" />

<section class="m-3 lg:m-10">
    <div class="grid grid-cols-12 gap-4 mb-4">
        <div class="col-span-12 xl:col-span-6">
            <div class="flex flex-col 2xl:flex-row text-center shadow-md border rounded-lg p-6 w-full h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">

                <div class="w-full 2xl:w-1/3">
                    <div class="text-5xl m-2 mb-4 2xl:text-8xl 2xl:mb-2">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                </div>

                <div class="w-full 2xl:w-2/3">
                    <h1 class="text-2xl font-selvah pb-2 mx-5 2xl:border-dotted 2xl:border-b 2xl:border-slate-500">
                        {{ $company->name }}
                    </h1>
                    <p class="hidden 2xl:block py-2 mx-5 text-gray-400">
                        {{ $company->description }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-span-12 xl:col-span-6">
            <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full text-center border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                <i class="fa-solid fa-screwdriver-wrench text-[color:hsl(var(--wa))] text-8xl"></i>
                <div>
                    <div class="font-bold text-2xl">
                        {{ $company->maintenances->count() }}
                    </div>
                    <p class="text-muted font-selvah uppercase">
                        Maintenance(s)
                    </p>
                </div>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 border shadow-md rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
            <div class="w-full">
                <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
                    <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                        <a class="text-xs font-bold uppercase px-5 py-3 shadow-md rounded block leading-normal cursor-pointer text-white bg-neutral dark:text-neutral dark:bg-white" href="#">
                            <i class="fa-solid fa-screwdriver-wrench mr-2"></i>Maintenances
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
                            <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $maintenance->getKey() }}">
                                <x-table.cell>
                                    <a class="link link-hover link-primary tooltip tooltip-right text-left" href="{{ $maintenance->show_url }}"  data-tip="Voir la fiche Maintenance">
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
                                        <a class="link link-hover link-primary font-bold" href="{{ route('materials.show', $maintenance->material) }}">
                                            {{ $maintenance->material->name }}
                                        </a>
                                    @endunless
                                </x-table.cell>
                                <x-table.cell>
                                    <span class="tooltip tooltip-top text-left" data-tip="{{ $maintenance->description }}">
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
