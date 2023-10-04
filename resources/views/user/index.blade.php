@extends('layouts.app')
{!! config(['app.title' => 'Gérer les Utilisateurs']) !!}

@push('meta')
    <x-meta title="Gérer les Utilisateurs" />
@endpush

@section('content')
<x-breadcrumbs :breadcrumbs="$breadcrumbs" />

<section class="m-3 lg:m-10">
    <hgroup class="text-center px-5 pb-5">
        <h1 class="text-4xl font-xetaravel">
            <i class="fa-solid fa-users"></i> Gestion des Utilisateurs
        </h1>
        <p class="text-gray-400 ">
            Gérer les utilisateurs du site.
        </p>
    </hgroup>

    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
            <livewire:users />
        </div>
    </div>
</section>
@endsection
