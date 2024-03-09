@extends('layouts.app')
{!! config(['app.title' => 'Profil de ' . $user->full_name]) !!}

@push('meta')
    <x-meta title="{{ 'Profil de ' . $user->full_name }}"/>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">
        <div class="grid grid-cols-12 gap-4 mb-4">
            @if ($user->trashed())
                <div class="col-span-12">
                    <x-alert type="error" class="text-left mb-4" title="Attention">
                        <span class="font-bold">Cet utilisateur a été supprimé le {{ $user->deleted_at->translatedFormat( 'D j M Y à H:i') }} par
                        @if(is_null($user->deletedUser))
                            l'application de manière automatisée.</span> La date de fin de contrat était le {{ $user->end_employment_contract->translatedFormat( 'D j M Y à H:i') }}
                        @else
                            {{ $user->deletedUser->full_name }}.</span>
                        @endif
                   </x-alert>
                </div>
            @endif


            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-4 h-full">
                    <div class="col-span-12 xl:col-span-6 h-full">
                        <div class="flex flex-col text-center shadow-md border rounded-lg p-6 w-full h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <div class="w-full">
                                <div class="mb-4">
                                    @php $online = $user->online; @endphp
                                    <div class="tooltip" data-tip="{{ $online ? $user->full_name.' est en ligne' : $user->full_name.' est hors ligne' }}" >
                                        <div class="avatar {{ $online ? 'online' : 'offline' }}">
                                            <div class="mask mask-squircle w-20 h-20 {{ $online ? 'tooltip' : '' }}">
                                                <img src="{{ asset($user->avatar) }}" alt="Avatar de {{ $user->full_name }}"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full">
                                <h1 class="text-2xl xl:text-4xl font-bds pb-2 mx-5 xl:border-dotted xl:border-b xl:border-slate-500 mb-4">
                                    {{ $user->full_name }}
                                </h1>

                                <div class="grid grid-cols-12 gap-4">
                                    <div class="col-span-6 flex flex-col gap-1 items-center">
                                        <div class="flex gap-1 font-bold items-center">
                                            <x-icon name="fas-calendar" class="w-4 h-4 inline"></x-icon>
                                            Création  :
                                        </div>
                                        <div class="inline-block">
                                            <code class="code rounded-sm">
                                                {{ $user->created_at?->translatedFormat( 'D j M Y H:i') }}
                                            </code>
                                        </div>
                                    </div>
                                    <div class="col-span-6 flex flex-col gap-1 items-center">
                                        <div class="flex gap-1 font-bold items-center">
                                            <x-icon name="fas-calendar" class="w-4 h-4 inline"></x-icon>
                                            Mis à jour  :
                                        </div>
                                        <div class="inline-block">
                                            <code class="code rounded-sm">
                                                {{ $user->updated_at?->translatedFormat( 'D j M Y H:i') }}
                                            </code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 xl:col-span-6 h-full">
                        <div class="flex flex-col shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                            <div class="grid grid-cols-12 gap-2 mb-4">
                                <div class="col-span-12 flex flex-col xl:flex-row items-center">
                                    <div class="flex gap-1 font-bold xl:min-w-[200px] items-center">
                                        <x-icon name="fas-at" class="w-4 h-4 inline"></x-icon>
                                        Email :
                                    </div>
                                    <div class="inline-block">
                                        <code class="code rounded-sm">
                                            <a href="mailto:{{ $user->email }}" target="_blank">{{ $user->email }}</a>
                                        </code>
                                    </div>
                                </div>

                                <div class="col-span-12 flex flex-col xl:flex-row items-center">
                                    <div class="flex gap-1 font-bold xl:min-w-[200px] items-center">
                                        <x-icon name="fas-phone" class="w-4 h-4 inline"></x-icon>
                                        Téléphone bureau :
                                    </div>
                                    <div class="inline-block">
                                        @if($user->office_phone)
                                            <code class="code rounded-sm">
                                                <a href="tel:{{ str_replace(' ', '', $user->office_phone) }}" target="_blank">{{ $user->office_phone }}</a>
                                            </code>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-span-12 flex flex-col xl:flex-row items-center">
                                    <div class="flex gap-1 font-bold xl:min-w-[200px] items-center">
                                        <x-icon name="fas-mobile-alt" class="w-4 h-4 inline"></x-icon>
                                        Téléphone portable :
                                    </div>
                                    <div class="inline-block">
                                        @if($user->cell_phone)
                                            <code class="code rounded-sm">
                                                <a href="tel:{{ str_replace(' ', '', $user->cell_phone) }}" target="_blank">{{ $user->cell_phone }}</a>
                                            </code>
                                        @endif
                                    </div>
                                </div>

                                @if($user->end_employment_contract)
                                    <div class="col-span-12 flex flex-col xl:flex-row items-center">
                                        <div class="flex gap-1 font-bold xl:min-w-[200px] items-center">
                                            <x-icon name="fas-calendar" class="w-4 h-4 inline"></x-icon>
                                            Date fin de contract :
                                        </div>
                                        <div class="inline-block">
                                                <code class="code rounded-sm">
                                                    {{ $user->end_employment_contract?->translatedFormat( 'D j M Y H:i') }}
                                                </code>
                                        </div>
                                    </div>
                                @endif

                                @can('update', $user)
                                    <div class="col-span-12 flex flex-col xl:flex-row items-center">
                                        <div class="flex gap-1 font-bold xl:min-w-[200px] items-center">
                                            <x-icon name="fas-calendar" class="w-4 h-4 inline"></x-icon>
                                            Dernière connexion :
                                        </div>
                                        <div class="inline-block">
                                            @if($user->last_login_date)
                                                <code class="code rounded-sm">
                                                    {{ $user->last_login_date?->translatedFormat( 'D j M Y H:i') }}
                                                </code>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-span-12 flex flex-col xl:flex-row items-center">
                                        <div class="flex gap-1 font-bold xl:min-w-[200px] items-center">
                                            <x-icon name="fas-earth-europe" class="w-4 h-4 inline"></x-icon>
                                            IP dernière connexion :
                                        </div>
                                        <div class="inline-block">
                                            @if($user->last_login_ip)
                                                <code class="code rounded-sm">
                                                    {{ $user->last_login_ip }}
                                                </code>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-span-12 flex flex-col xl:flex-row items-center">
                                        <div class="flex gap-1 font-bold xl:min-w-[200px] items-center">
                                            <x-icon name="fas-user-lock" class="w-4 h-4 inline"></x-icon>
                                            Compte configuré le :
                                        </div>
                                        <div class="inline-block">
                                            @if($user->password_setup_at)
                                                <code class="code rounded-sm">
                                                    {{ $user->password_setup_at?->translatedFormat( 'D j M Y H:i') }}
                                                </code>
                                            @else
                                                Mot de passe non configuré
                                            @endif
                                        </div>
                                    </div>
                                @endcan

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4 text-center h-full mb-4">
            <div class="col-span-12 xl:col-span-2 h-full">
                <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <x-icon name="fas-screwdriver-wrench" class="text-warning h-16 w-16 m-auto"></x-icon>
                    <div>
                        <div class="font-bold text-2xl">
                            {{ $user->maintenance_count }}
                        </div>
                        <p class="text-muted font-bds uppercase">
                            Maintenance(s)
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-2 h-full">
                <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <x-icon name="fas-triangle-exclamation" class="text-error h-16 w-16 m-auto"></x-icon>
                    <div>
                        <div class="font-bold text-2xl">
                            {{ $user->incident_count }}
                        </div>
                        <p class="text-muted font-bds uppercase">
                            Incident(s)
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-2 h-full">
                <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <x-icon name="fas-broom" class="text-success h-16 w-16 m-auto"></x-icon>
                    <div>
                        <div class="font-bold text-2xl">
                            {{ $user->cleaning_count }}
                        </div>
                        <p class="text-muted font-bds uppercase">
                            Nettoyage(s)
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-2 h-full">
                <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <x-icon name="fas-gear" class="text-primary h-16 w-16 m-auto"></x-icon>
                    <div>
                        <div class="font-bold text-2xl">
                            {{ $user->part_count }}
                        </div>
                        <p class="text-muted font-bds uppercase">
                            Pièce(s) Détachée(s)
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-2 h-full">
                <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <x-icon name="fas-arrow-right-to-bracket" class="text-primary h-16 w-16 m-auto"></x-icon>
                    <div>
                        <div class="font-bold text-2xl">
                            {{ $user->part_entry_count }}
                        </div>
                        <p class="text-muted font-bds uppercase">
                            Entrée(s) Pièce(s) Détachée(s)
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-2 h-full">
                <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <x-icon name="fas-right-from-bracket" class="text-purple-600 h-16 w-16 m-auto"></x-icon>
                    <div>
                        <div class="font-bold text-2xl">
                            {{ $user->part_exit_count }}
                        </div>
                        <p class="text-muted font-bds uppercase">
                            Sortie(s) Pièce(s) Détachée(s)
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-12 gap-4 mb-7">
            @foreach($sites as $site)
                <div class="col-span-12
                    @if($loop->count >= 3)
                        {{  'xl:col-span-3' }}
                    @elseif($loop->count == 2)
                        {{  'xl:col-span-6' }}
                    @endif
                    shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <div class="flex flex-col gap-4 p-5 items-center content-between">
                        <figure class="px-10">
                            @if ($site['site']->id == settings('site_id_selvah'))
                                <img src="{{ asset('images/logos/selvah.png') }}" alt="Selvah Logo" class="inline-block w-20">
                            @elseif ($site['site']->id == settings('site_id_extrusel'))
                                <img src="{{ asset('images/logos/extrusel.png') }}" alt="Extrusel Logo" class="inline-block w-28">
                            @elseif ($site['site']->id == settings('site_id_moulin_jannet'))
                                <img src="{{ asset('images/logos/moulin_jannet.png') }}" alt="Moulin Jannet Logo" class="inline-block w-16">
                            @elseif ($site['site']->id == settings('site_id_val_union'))
                                <img src="{{ asset('images/logos/bfc_val_union.png') }}" alt="BFC Val Union Logo" class="inline-block dark:hidden h-14">
                                <img src="{{ asset('images/logos/bfc_val_union_blanc.png') }}" alt="BFC Val Union Logo" class="hidden dark:inline-block h-14">
                            @else
                                <img src="{{ asset('images/logos/cbds_32x383.png') }}" alt="Coopérative Bourgogne du Sud Logo" class="inline-block w-20">
                            @endif
                        </figure>
                        <div class="font-bold text-3xl">
                            {{ $site['site']->name }}
                        </div>
                        <div class=" text-center">
                            @foreach($site['roles'] as $role)
                                <span class="block font-bold" style="{{ $role->formatted_color }};">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </section>
@endsection
