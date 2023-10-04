@extends('layouts.app')
{!! config(['app.title' => 'Gérer les Permissions']) !!}

@push('meta')
    <x-meta title="Gérer les Permissions" />
@endpush

@section('content')
<x-breadcrumbs :breadcrumbs="$breadcrumbs" />

<section class="m-3 lg:m-10">
    <hgroup class="text-center px-5 pb-5">
        <h1 class="text-4xl font-selvah">
            <i class="fa-solid fa-user-shield"></i> Gestion des Permissions
        </h1>
        <p class="text-gray-400 ">
            Gérer les permissions du site.
        </p>
    </hgroup>

    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
            <livewire:roles.permissions />
        </div>
    </div>
</section>
@endsection
