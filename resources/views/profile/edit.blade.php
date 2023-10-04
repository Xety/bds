@extends('layouts.app')
{!! config(['app.title' => 'Mon profil']) !!}

@push('meta')
    <x-meta title="Mon profil" />
@endpush

@section('content')
<x-breadcrumbs :breadcrumbs="$breadcrumbs" />

<section class="m-3 lg:m-10">
    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
            <h2 class="divider text-2xl font-selvah">
                Changer votre Mot de Passe
            </h2>
            @include('profile.partials.update-password-form')
        </div>
    </div>
</section>
@endsection
