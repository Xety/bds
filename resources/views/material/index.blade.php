@extends('layouts.app')
{!! config(['app.title' => 'Gérer les Matériels']) !!}

@push('meta')
    <x-meta title="Gérer les Matériels" />
@endpush

@section('content')
<x-breadcrumbs :breadcrumbs="$breadcrumbs" />

<section class="m-3 lg:m-10">
    <hgroup class="text-center px-5 pb-5">
        <h1 class="text-4xl font-selvah">
            <i class="fa-solid fa-microchip"></i> Gestion des Matériels
        </h1>
        <p class="text-gray-400 ">
            Gérer les matériels de l'usine.
        </p>
    </hgroup>

    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
            <livewire:materials />
        </div>
    </div>
</section>
@endsection
