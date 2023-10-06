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
                <i class="fa-solid fa-users"></i> Voir les Sites et Permissions
            </h1>
            <p class="text-gray-400 ">
                Gérer les utilisateurs du site.
            </p>
        </hgroup>

        <div class="grid grid-cols-12 gap-6 mb-7">
            <div class="col-span-12 shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">

                <ul class="menu menu-xs bg-base-200 rounded-lg w-full">
                    @foreach($sites as $site)
                        <li>
                            <details>
                                <summary>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                    </svg>
                                    {{ $site->name }}
                                </summary>

                                <ul>
                                @foreach($site->users as $user)
                                    <li>
                                        <details>
                                            <summary>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                                </svg>
                                                {{ $user->full_name }}
                                            </summary>
                                            <ul>
                                                @foreach($user->roles as $role)
                                                    <li>
                                                        <details>
                                                            <summary>
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                                                </svg>
                                                                {{ $role->name }}
                                                            </summary>
                                                            <ul>
                                                                @foreach($role->permissions as $permission)
                                                                        <li>
                                                                            <a>
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                                                                                </svg>
                                                                                {{ $permission->name }}
                                                                            </a>
                                                                        </li>
                                                                @endforeach
                                                            </ul>
                                                        </details>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </details>
                                    </li>
                                @endforeach
                               </ul>

                            </details>
                        </li>
                    @endforeach
                </ul>

            </div>
        </div>
    </section>
@endsection
