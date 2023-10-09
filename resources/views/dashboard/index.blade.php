@extends('layouts.app')
{!! config(['app.title' => 'Tableau de bord']) !!}

@push('meta')
    <x-meta title="Tableau de bord"/>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">

    </section>

    {{-- QrCode Modal --}}
    <livewire:qr-code-modal>
@endsection
