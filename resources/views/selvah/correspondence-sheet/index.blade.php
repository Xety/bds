@extends('layouts.app')
{!! config(['app.title' => 'Gérer les Fiches de Correspondances Selvah']) !!}

@push('meta')
    <x-meta title="Gérer les Fiches de Correspondances Selvah"/>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">
        <hgroup class="text-center px-5 pb-5">
            <h1 class="text-4xl">
                <x-icon name="fas-file-invoice" class="h-10 w-10 inline"></x-icon> Gérer les Fiches de Correspondances
            </h1>
            <p class="text-gray-400 ">
                Gérer les Fiches de Correspondances de Selvah.
            </p>
        </hgroup>


        <livewire:selvah.correspondence-sheets />
    </section>
@endsection
