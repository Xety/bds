@extends('layouts.app')
{!! config(['app.title' => 'Gérer les Paramètres']) !!}

@push('meta')
    <x-meta title="Gérer les Paramètres"/>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">
        <div class="grid grid-cols-12 gap-6 mb-7">
            <div class="col-span-12 lg:col-span-6 shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                @include('setting.partials.update-general-setting')
            </div>
        </div>
    </section>
@endsection
