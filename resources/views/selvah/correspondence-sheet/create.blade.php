@extends('layouts.app')
{!! config(['app.title' => 'Créer une Fiche de Correspondance Selvah']) !!}

@push('meta')
    <x-meta title="Créer une Fiche de Correspondance Selvah"/>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">
        <hgroup class="text-center px-5 pb-5">
            <h1 class="text-4xl">
                <x-icon name="fas-file-invoice" class="h-10 w-10 inline"></x-icon> Créer une Fiche de Correspondance Selvah
            </h1>
            <p class="text-gray-400 ">
                Création d'une Fiche de Correspondance Selvah.
            </p>
        </hgroup>


        <livewire:selvah.create-correspondence-sheets />
    </section>
@endsection
