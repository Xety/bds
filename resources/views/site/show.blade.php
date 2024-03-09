@extends('layouts.app')
{!! config(['app.title' => $site->name]) !!}

@push('meta')
    <x-meta title="{{ $site->name }}"/>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">
        <div class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-12 xl:col-span-6">
                <div class="flex flex-col text-center shadow-md border rounded-lg p-6 w-full h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <div class="w-full">
                        <div class="mb-4">
                            <figure class="px-10">
                                @if ($site->id == settings('site_id_selvah'))
                                    <img src="{{ asset('images/logos/selvah.png') }}" alt="Selvah Logo" class="inline-block w-20">
                                @elseif ($site->id == settings('site_id_extrusel'))
                                    <img src="{{ asset('images/logos/extrusel.png') }}" alt="Extrusel Logo" class="inline-block w-28">
                                @elseif ($site->id == settings('site_id_moulin_jannet'))
                                    <img src="{{ asset('images/logos/moulin_jannet.png') }}" alt="Moulin Jannet Logo" class="inline-block w-16">
                                @elseif ($site->id == settings('site_id_val_union'))
                                    <img src="{{ asset('images/logos/bfc_val_union.png') }}" alt="BFC Val Union Logo" class="inline-block dark:hidden h-14">
                                    <img src="{{ asset('images/logos/bfc_val_union_blanc.png') }}" alt="BFC Val Union Logo" class="hidden dark:inline-block h-14">
                                @else
                                    <img src="{{ asset('images/logos/cbds_32x383.png') }}" alt="Coopérative Bourgogne du Sud Logo" class="inline-block w-20">
                                @endif
                            </figure>
                        </div>
                    </div>

                    <div class="w-full">
                        <h1 class="text-2xl xl:text-4xl font-bds pb-2 mx-5 border-dotted border-b border-slate-500 mb-4 uppercase">
                            {{ $site->name }}
                        </h1>

                        <h2 class="inline-flex items-center text-xl xl:text-3xl">
                            <x-icon name="fas-user-tie" class="w-6 h-6 mr-2 inline"></x-icon> Responsable(s)
                        </h2>
                        <div class="grid grid-cols-12 gap-4 mb-7">
                            @forelse($managers as $manager)
                                <div class="col-span-12
                                @if($loop->count >= 4)
                                    {{  'xl:col-span-3' }}
                                @elseif($loop->count == 3)
                                    {{  'xl:col-span-4' }}
                                @elseif($loop->count == 2)
                                    {{  'xl:col-span-6' }}
                                @endif
                                ">
                                    <div class="flex flex-col p-5 items-center content-between">
                                        <div class="w-full">
                                                @php $online = $manager->online; @endphp
                                                <div class="tooltip" data-tip="{{ $online ? $manager->full_name.' est en ligne' : $manager->full_name.' est hors ligne' }}" >
                                                    <div class="avatar {{ $online ? 'online' : 'offline' }}">
                                                        <div class="mask mask-squircle w-12 h-12 {{ $online ? 'tooltip' : '' }}">
                                                            <img src="{{ asset($manager->avatar) }}" alt="Avatar de {{ $manager->full_name }}"/>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>

                                        <div class="xl:text-xl font-bds pb-2 mx-5 border-dotted border-b border-slate-500 mb-2">
                                            <a class="link link-hover link-primary font-bold" href="{{ $manager->show_url }}">
                                                {{ $manager->full_name }}
                                            </a>
                                        </div>
                                        <div class=" text-center">
                                            @foreach($manager->roles as $role)
                                                <span class="block font-bold" style="{{ $role->formatted_color }};">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-12">
                                    Il n'y aucun responsable sur ce site.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-6">
                <div class="shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <div class="flex flex-col h-full justify-between gap-4">
                        <div class="flex flex-col xl:flex-row items-center">
                            <div class="flex gap-1 font-bold xl:min-w-[200px] items-center">
                                <x-icon name="fas-at" class="w-4 h-4 inline"></x-icon>
                                Email :
                            </div>
                            <div class="inline-block">
                                @if($site->email)
                                    <code class="code rounded-sm">
                                        <a href="mailto:{{ $site->email }}" target="_blank">{{ $site->email }}</a>
                                    </code>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col xl:flex-row items-center">
                            <div class="flex gap-1 font-bold xl:min-w-[200px] items-center">
                                <x-icon name="fas-phone" class="w-4 h-4 inline"></x-icon>
                                Téléphone bureau :
                            </div>
                            <div class="inline-block">
                                @if($site->office_phone)
                                    <code class="code rounded-sm">
                                        <a href="tel:{{ str_replace(' ', '', $site->office_phone) }}" target="_blank">{{ $site->office_phone }}</a>
                                    </code>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col xl:flex-row items-center">
                            <div class="flex gap-1 font-bold xl:min-w-[200px] items-center">
                                <x-icon name="fas-mobile-alt" class="w-4 h-4 inline"></x-icon>
                                Téléphone portable :
                            </div>
                            <div class="inline-block">
                                @if($site->cell_phone)
                                    <code class="code rounded-sm">
                                        <a href="tel:{{ str_replace(' ', '', $site->cell_phone) }}" target="_blank">{{ $site->cell_phone }}</a>
                                    </code>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col xl:flex-row items-center">
                            <div class="flex gap-1 font-bold xl:min-w-[200px] items-center">
                                <x-icon name="fas-map-signs" class="w-4 h-4 inline"></x-icon>
                                Adresse :
                            </div>
                            <div class="inline-block">
                                @if($site->address)
                                    <code class="code rounded-sm">
                                        {{ $site->address }}
                                    </code>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col xl:flex-row items-center">
                            <div class="flex gap-1 font-bold xl:min-w-[200px] items-center">
                                <x-icon name="fas-map-pin" class="w-4 h-4 inline"></x-icon>
                                Ville :
                            </div>
                            <div class="inline-block">
                                @if($site->city)
                                    <code class="code rounded-sm">
                                        {{ $site->zip_code }} {{ $site->city }}
                                    </code>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-12 gap-6 mb-7">
            <div class="col-span-12 shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">

                <x-tabs selected="users">
                    <x-tab name="users" label="Collaborateurs" icon="fas-users">
                        <x-table.table class="mb-6">
                            <x-slot name="head">
                                <x-table.heading>#Id</x-table.heading>
                                <x-table.heading>Nom</x-table.heading>
                                <x-table.heading>Email</x-table.heading>
                                <x-table.heading>Rôles</x-table.heading>
                                <x-table.heading>Supprimé</x-table.heading>
                                <x-table.heading>Dernière connexion</x-table.heading>
                                <x-table.heading>Créé le</x-table.heading>
                            </x-slot>

                            <x-slot name="body">
                                @forelse($users as $user)
                                    <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $user->getKey() }}">
                                        <x-table.cell>{{ $user->getKey() }}</x-table.cell>
                                        <x-table.cell>
                                            @php $online = $user->online; @endphp
                                            <div class="flex items-center space-x-3">
                                                <div class="tooltip" data-tip="{{ $online ? $user->full_name.' est en ligne' : $user->full_name.' est hors ligne' }}" >
                                                    <div class="avatar {{ $online ? 'online' : 'offline' }}">
                                                        <div class="mask mask-squircle w-12 h-12 {{ $online ? 'tooltip' : '' }}">
                                                            <img src="{{ asset($user->avatar) }}" alt="Avatar de {{ $user->full_name }}"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a href="{{ route('users.show', $user) }}" class="link link-hover link-primary font-bold">
                                                        {{ $user->full_name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </x-table.cell>
                                        <x-table.cell>{{ $user->email }}</x-table.cell>
                                        <x-table.cell>
                                            @forelse ($user->roles as $role)
                                                <span class="block font-bold" style="{{ $role->formatted_color }};">
                                                    {{ $role->name }}
                                                </span>
                                            @empty
                                                Cet utilisateur n'a pas de rôle pour le site {{ $site->name }}.
                                            @endforelse
                                        </x-table.cell>
                                        <x-table.cell>
                                            @if ($user->deleted_at)
                                                <span class="text-error font-bold tooltip tooltip-top" datat-tip="Supprimé le {{ $user->deleted_at }}">
                                                    Oui
                                                </span>
                                            @else
                                                <span class="text-success font-bold">
                                                    Non
                                                </span>
                                            @endif
                                        </x-table.cell>
                                        <x-table.cell class="capitalize">
                                            {{ $user->last_login_date?->translatedFormat( 'D j M Y H:i') }}
                                        </x-table.cell>
                                        <x-table.cell class="capitalize">
                                            {{ $user->created_at->translatedFormat( 'D j M Y H:i') }}
                                        </x-table.cell>
                                    </x-table.row>
                                @empty
                                    <x-table.row>
                                        <x-table.cell colspan="9">
                                            <div class="text-center p-2">
                                                <span class="text-muted">Aucun utilisateur trouvé pour ce site...</span>
                                            </div>
                                        </x-table.cell>
                                    </x-table.row>
                                @endforelse
                            </x-slot>
                        </x-table.table>

                        <div class="grid grid-cols-1">
                            {{ $users->fragment('users')->links() }}
                        </div>
                    </x-tab>
                </x-tabs>

            </div>
        </div>
    </section>
@endsection
