@extends('layouts.app')
{!! config(['app.title' => 'Gérer les Maintenances']) !!}

@push('meta')
    <x-meta title="Gérer les Maintenances"/>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">
        <hgroup class="text-center px-5 pb-5">
            <h1 class="text-4xl font-bds">
                <x-icon name="fas-screwdriver-wrench" class="h-10 w-10 inline"></x-icon> Gestion des Maintenances
            </h1>
            <p class="text-gray-400 ">
                Gérer les maintenances.
            </p>
        </hgroup>

        <div class="grid grid-cols-12 gap-6 mb-7">
            <div
                class="col-span-12 shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                <livewire:maintenances/>
            </div>
        </div>
    </section>
@endsection
