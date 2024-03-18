@extends('layouts.app')
{!! config(['app.title' => 'Voir les Activités']) !!}

@push('meta')
    <x-meta title="Voir les Activités"/>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">
        <hgroup class="text-center px-5 pb-5">
            <h1 class="text-4xl">
                <x-icon name="fas-file-shield" class="h-10 w-10 inline"></x-icon> Voir les Activités
            </h1>
            <p class="text-gray-400 ">
                Voir les activités des utilisateurs.
            </p>
        </hgroup>

        <div class="grid grid-cols-12 gap-6 mb-7">
            <div class="col-span-12 shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                <livewire:activities />
            </div>
        </div>
    </section>
@endsection
