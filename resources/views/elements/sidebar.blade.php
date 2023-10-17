<aside class="drawer-side z-10">
    <label for="bds-drawer" class="drawer-overlay"></label>
    <!--Website Menu-->
    <div class="menu w-80 min-h-full bg-neutral dark:bg-base-300 text-neutral-content dark:text-slate-300">
        <ul>
            <li class="hidden lg:block">
                <a class="flex flex-col items-center font-light text-3xl font-bds  hover:!bg-transparent focus:!bg-transparent active:!bg-transparent" href="{{ route('dashboard.index') }}">
                    @if (session('current_site_id') == 2)
                        <img src="{{ asset('images/logos/selvah.png') }}" alt="Selvah Logo" class="inline-block w-20">
                        <span class="block">SELVAH</span>
                    @elseif (session('current_site_id') == 3)
                        <img src="{{ asset('images/logos/extrusel.png') }}" alt="Extrusel Logo" class="inline-block w-24">
                        <span class="block">EXTRUSEL</span>
                    @elseif (session('current_site_id') == 4)
                        <img src="{{ asset('images/logos/moulin_jannet.png') }}" alt="Moulin Jannet Logo" class="inline-block w-20">
                    @elseif (session('current_site_id') == 51)
                        <img src="{{ asset('images/logos/bfc_val_union_blanc.png') }}" alt="BFC Val Union Logo" class="inline-block h-20">
                    @else
                        <img src="{{ asset('images/logos/cbds_32x383.png') }}" alt="Coopérative Bourgogne du Sud Logo" class="inline-block w-20">
                    @endif
                </a>
            </li>
            <li class="lg:hidden">
                {{-- Switch Dark Mode --}}
                <x-theme-toggle />
            </li>

            <li class="lg:hidden items-center">
                {{-- Select Site --}}
                <livewire:site :sidebar="true" />
            </li>
        </ul>

        <div class="hidden lg:flex divider px-4 my-0"></div>

        {{-- Sidebar Menu --}}
        <x-menu activate-by-route>
            <x-menu-sub :title="auth()->user()->hasRole('Saisonnier') ? 'Bienvenue' : 'Administration'" icon="bxs-dashboard">
                <x-menu-item title="Tableau de bord" icon="fas-gauge" link="{{ route('dashboard.index') }}" />
            </x-menu-sub>

            @can('viewAny', \BDS\Models\Cleaning::class)
                <x-menu-separator  />
                <x-menu-sub title="Nettoyages" icon="fas-broom">
                    <x-menu-item title="Gérer les Nettoyages" icon="fas-broom" link="{{ route('cleanings.index') }}" wire:navigate />
                </x-menu-sub>
            @endcan

            @can('viewAny', \BDS\Models\Material::class)
                <x-menu-separator  />
                <x-menu-sub title="Matériels" icon="fas-microchip">
                    <x-menu-item title="Gérer les Matériels" icon="fas-microchip" link="{{ route('materials.index') }}" wire:navigate />
                    <x-menu-item title="Voir l'arbre des Matériels" icon="fas-folder-tree" link="{{ route('materials.arbre') }}" wire:navigate />
                </x-menu-sub>
            @endcan

            @can('viewAny', \BDS\Models\Zone::class)
                <x-menu-separator  />
                <x-menu-sub title="Zones" icon="fas-map-signs">
                    <x-menu-item title="Gérer les Zones" icon="fas-map-pin" link="{{ route('zones.index') }}" wire:navigate />
                </x-menu-sub>
            @endcan

            @can('viewAny', \BDS\Models\Site::class)
                <x-menu-separator  />
                <x-menu-sub title="Sites" icon="fas-map-marker-alt">
                    <x-menu-item title="Gérer les Sites" icon="fas-map-marked-alt" link="{{ route('sites.index') }}" wire:navigate />
                    <x-menu-item title="Gérer les Accès aux Sites" icon="fas-building-shield" link="#" wire:navigate />
                </x-menu-sub>
            @endcan

            @can('viewAny', \BDS\Models\User::class)
                <x-menu-separator  />
                <x-menu-sub title="Utilisateurs" icon="fas-users">
                    <x-menu-item title="Gérer les Utilisateurs" icon="fas-users-gear" link="{{ route('users.index') }}" />
                </x-menu-sub>
            @endcan

            @canany(['viewAny role', 'viewAny permission', 'viewAny direct permission'])
                <x-menu-separator  />
                <x-menu-sub title="Rôles & Permissions" icon="fas-shield-alt">
                    @can('viewAny', \BDS\Models\Role::class)
                        <x-menu-item title="Gérer les Rôles" icon="fas-user-tie" link="{{ route('roles.roles.index') }}" wire:navigate />
                    @endcan

                    @can('viewAny', \BDS\Models\Permission::class)
                        <x-menu-item title="Gérer les Permissions" icon="fas-user-shield" link="{{ route('roles.permissions.index') }}" wire:navigate />
                    @endcan

                    <x-menu-item title="Voir l'arbre des Permissions" icon="fas-folder-tree" link="{{ route('users.permissions') }}" wire:navigate />
                </x-menu-sub>
            @endcanany

            @can('viewAny', \BDS\Models\Setting::class)
                <x-menu-separator  />
                <x-menu-sub title="Paramètres" icon="fas-cog">
                    <x-menu-item title="Gérer les Paramètres" icon="fas-cog" link="{{ route('settings.index') }}" />
                </x-menu-sub>
            @endcan

            <x-menu-separator hr-class="lg:hidden my-0" />
        </x-menu>

        {{-- User Avatar and Menu --}}
        <div class="group flex items-center lg:hidden px-4 w-full h-16 min-h-16 mt-auto shadow-md rounded-md bg-base-100 text-neutral dark:bg-base-100 dark:text-neutral-content">
            {{-- User Avatar --}}
            <x-dropdown top hover class=" w-52">
                <x-slot:trigger>
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img src="{{ asset(Auth::user()->avatar) }}"  alt="User avatar" />
                        </div>
                    </label>
                </x-slot:trigger>

                <x-menu-item wire:navigate title="Mes Paramètres" link="{{ route('profile.edit') }}" icon="iconsax-bol-setting-5" tooltip tooltip-content="Gérer les paramètres de votre compte." />
                <x-menu-item title="Déconnexion" icon="fas-sign-out-alt" tooltip tooltip-content="A plus tard !" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-red-500" />
            </x-dropdown>

            {{-- Username --}}
            <div class="flex flex-col text-left items-left justify-center w-full">
                <span class="font-bold text-primary">{{ Auth::user()->full_name }}</span>
                <small class="">{{  Auth::user()->email }}</small>
            </div>
        </div>

    </div>
</aside>
