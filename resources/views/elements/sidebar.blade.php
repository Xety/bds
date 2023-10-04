<aside class="drawer-side z-10">
    <label for="bds-drawer" class="drawer-overlay"></label>
    <!--Website Menu-->
    <div class="menu w-80 min-h-full bg-neutral dark:bg-base-300 text-neutral-content dark:text-slate-300">
        <ul>
            <li class="hidden lg:block">
                <a class="flex flex-col items-center font-light text-3xl font-bds  hover:!bg-transparent focus:!bg-transparent active:!bg-transparent" href="{{ route('dashboard.index') }}">
                    @if (session('current_site_id') == 2)
                        <img src="{{ asset('images/logos/selvah_570x350.png') }}" alt="Selvah Logo" class="inline-block w-20">
                        <span class="block">SELVAH</span>
                    @elseif (session('current_site_id') == 3)
                        <img src="{{ asset('images/logos/extrusel_166x110.png') }}" alt="Extrusel Logo" class="inline-block w-24">
                        <span class="block">EXTRUSEL</span>
                    @else
                        <img src="{{ asset('images/logos/cbds_32x383.png') }}" alt="Coopérative Bourgogne du Sud Logo" class="inline-block w-20">
                    @endif
                </a>
            </li>
            <li class="lg:hidden">
                <div class="tooltip tooltip-bottom normal-case flex items-center justify-center hover:!bg-transparent focus:!bg-transparent active:!bg-transparent cursor-default" data-tip="Changer de thème">
                    <label class="swap swap-rotate mr-2">
                        <input id="nightMode" class="nightmode toggle text-current checked:bg-none focus:bg-none" type="checkbox" v-model="nightMode"/>

                        <!-- Moon icon -->
                        <svg class="swap-on text-base-300 w-4 h-4 translate-x-7 my-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/></svg>
                        <!-- Sun icon -->
                        <svg class="swap-off fill-current w-4 h-4 text-yellow-600 my-1 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/></svg>

                    </label>
                </div>
            </li>

            <li class="lg:hidden items-center">
                {{-- Select Site --}}
                <livewire:site />
            </li>
        </ul>

        <div class="hidden lg:flex divider px-4 my-0"></div>


        <ul class="p-4" role="list">
            <li class="menu-title">
                @if (auth()->user()->hasRole('Saisonnier'))
                    <span>Bienvenue</span>
                @else
                    <span>Administration</span>
                @endif
            </li>
            <li>
                {!! Menu::{'dashboard'}() !!}
            </li>


            @can('viewAny', \BDS\Models\Material::class)
                <li class="menu-title">
                    <span>Matériels</span>
                </li>
                <li>
                    {!! Menu::{'material'}() !!}
                </li>
            @endcan

            @can('viewAny', \BDS\Models\Cleaning::class)
                <li class="menu-title">
                    <span>Nettoyages</span>
                </li>
                <li>
                    {!! Menu::{'cleaning'}() !!}
                </li>
            @endcan

            @can('viewAny', \BDS\Models\Zone::class)
                <li class="menu-title">
                    <span>Zones</span>
                </li>
                <li>
                    {!! Menu::{'zone'}() !!}
                </li>
            @endcan

            @can('viewAny', \BDS\Models\User::class)
                <li class="menu-title">
                    <span>Utilisateurs</span>
                </li>
                <li>
                    {!! Menu::{'user'}() !!}
                </li>
            @endcan

            @canany(['viewAny role', 'viewAny permission'])
                <li class="menu-title">
                    <span>Rôles & Permissions</span>
                </li>
                <li>
                    {!! Menu::{'role'}() !!}
                </li>
            @endcanany

            @can('viewAny', \BDS\Models\Setting::class)
                <li class="menu-title">
                    <span>Paramètres</span>
                </li>
                <li>
                    {!! Menu::{'setting'}() !!}
                </li>
            @endcan
        </ul>


        <div class="divider px-4 my-0 lg:hidden"></div>

        @auth
            <!-- User Menu-->
            <div class="group flex items-center lg:hidden px-4 w-full h-16 min-h-16 mt-auto shadow-md rounded-md bg-base-100 text-neutral dark:bg-base-100 dark:text-neutral-content">
                {{-- User Avatar --}}
                <div class="dropdown dropdown-hover dropdown-right dropdown-top">
                    <label tabindex="0" class="avatar btn btn-ghost btn-circle">
                        <div class="w-10 rounded-full">
                            <img src="{{ asset(Auth::user()->avatar) }}"  alt="Avatar de l'utilisateur" class="rounded-full" />
                        </div>
                    </label>
                    <ul tabindex="0" class="menu dropdown-content p-2 shadow bg-base-100 rounded-box w-52 mt-4">
                        <li>
                            <div data-tip="Gérer les paramètres de votre compte." class="tooltip tooltip-top">
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-6 w-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                    <span>Mes Paramètres</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <a href="{{ route('auth.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"  class="hover:shadow text-red-500 active:text-[color:hsl(var(--pc))] active:bg-red-500 rounded-[var(--rounded-btn)]">
                                <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Déconnexion</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- User Name --}}
                <div class="flex flex-col text-left items-left justify-center w-full">
                    <span class="font-bold text-primary">{{ Auth::user()->full_name }}</span>
                    <small class="">{{  Auth::user()->email }}</small>
                </div>
            </div>
        @endauth

    </div>
</aside>
