<header>
    <!-- Navbar -->
    <nav class="navbar bg-base-100 dark:bg-base-300 dark:text-slate-300 lg:pr-5">
            <div class="navbar-start lg:hidden">
                <label for="bds-drawer" class="btn btn-square btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current md:h-6 md:w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </label>
            </div>
            {{-- Logo Alliance --}}
            <div class="navbar-start hidden lg:flex justify-start">
                <img class="block dark:hidden h-12" src="{{ asset('images/logos/alliance_bfc.png') }}" alt="Alliance BFC Logo">
                <img class="hidden dark:block h-12" src="{{ asset('images/logos/alliance_bfc_blanc.png') }}" alt="Alliance BFC Logo">
            </div>
            {{-- Logo Site --}}
            <div class="navbar-center lg:hidden">
                <a class="font-light text-3xl font-bds text-center" href="{{ route('dashboard.index') }}">
                    @if (session('current_site_id') == 2)
                        <img src="{{ asset('images/logos/selvah.png') }}" alt="Selvah Logo" class="inline-block w-20">
                        <span class="block">SELVAH</span>
                    @elseif (session('current_site_id') == 3)
                        <img src="{{ asset('images/logos/extrusel.png') }}" alt="Extrusel Logo" class="inline-block w-24">
                        <span class="block">EXTRUSEL</span>
                    @elseif (session('current_site_id') == 4)
                        <img src="{{ asset('images/logos/moulin_jannet.png') }}" alt="Moulin Jannet Logo" class="inline-block w-16">
                    @elseif (session('current_site_id') == 51)
                        <img src="{{ asset('images/logos/bfc_val_union.png') }}" alt="BFC Val Union Logo" class="inline-block dark:hidden h-14">
                        <img src="{{ asset('images/logos/bfc_val_union_blanc.png') }}" alt="BFC Val Union Logo" class="hidden dark:inline-block h-14">
                    @else
                        <img src="{{ asset('images/logos/cbds_32x383.png') }}" alt="Coopérative Bourgogne du Sud Logo" class="inline-block w-20">
                    @endif
                </a>
            </div>

        <div class="navbar-start hidden lg:block"></div>

            {{-- Notifications --}}
            <div class="navbar-end lg:hidden">
                <x-notifications/>
            </div>

            <div class="navbar-end hidden lg:flex justify-end gap-2">
                {{-- Select Site --}}
                <div class="">
                    {{ session('current_site_id') }}
                </div>

                <livewire:site />

                {{-- Switch Dark Mode --}}
                <x-theme-toggle />

                {{-- User Notifications Menu --}}
                <livewire:users.notifications />

                {{-- User Avatar and Menu --}}
                <x-dropdown right class=" w-52">
                    <x-slot:trigger>
                        <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full">
                                <img src="{{ asset(Auth::user()->avatar) }}"  alt="User avatar" />
                            </div>
                        </label>
                    </x-slot:trigger>

                    <x-menu-item wire:navigate title="Mes Paramètres" link="{{ route('profile.edit') }}" icon="iconsax-bol-setting-5" tooltip tooltip-content="Gérer les paramètres de votre compte." />
                    <x-menu-item title="Déconnexion" icon="fas-sign-out-alt" tooltip tooltip-content="A plus tard !" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-red-500" />
                    <x-form method="post" action="{{ route('auth.logout') }}" id="logout-form" style="display:none;"></x-form>
                </x-dropdown>

                {{-- Username --}}
                <div class="my-auto font-bold min-w-fit">
                    {{ Auth::user()->full_name }}
                </div>
            </div>

    </nav>
</header>
