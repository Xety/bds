<div class="border-b-primary border-b-4">
    <div class="navbar w-full min-h-24 mx-auto lg:max-w-7xl">
        <div class="navbar-start lg:hidden">
            <label for="my-drawer-3" aria-label="open sidebar" class="btn btn-square btn-ghost">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    class="inline-block h-6 w-6 stroke-current">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </label>
        </div>
        <div class="navbar-start hidden lg:inline-flex">
            <a href="{{ route('public.page.index') }}">
                <img src="{{ asset('images/logos/cbds_324x383.png') }}" alt="Coopérative Bourgogne du Sud Logo" class="inline-block w-20">
            </a>
            <div class="divider lg:divider-horizontal"></div>
            <a href="#">
                <img src="{{ asset('images/logos/alliance_bfc.png') }}" alt="Alliance BFC Logo" class="inline-block h-10">
            </a>
        </div>
        <!-- Center -->
        <div class="navbar-center lg:hidden">
            <a href="{{ route('public.page.index') }}">
                <img src="{{ asset('images/logos/cbds_324x383.png') }}" alt="Coopérative Bourgogne du Sud Logo" class="inline-block w-20">
            </a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal text-xl z-10 text-primary">
                <!-- Navbar menu content here -->
                <li>
                    <div class="dropdown dropdown-bottom dropdown-hover">
                        <div tabindex="0" class="font-racing">Le Groupe</div>
                        <div
                            tabindex="0"
                            class="dropdown-content card card-compact bg-primary text-primary-content z-[1] p-2 shadow">
                            <div class="card-body">
                                <div class="flex flex-row">
                                    <nav class="flex flex-col min-w-40">
                                        <h6 class="uppercase opacity-80 font-bold mb-2">
                                            <a class="link link-hover" href="#">
                                                Qui sommes-nous ?
                                            </a>
                                        </h6>
                                        <a class="link link-hover">Chiffres clés</a>
                                    </nav>
                                    <nav class="flex flex-col min-w-40">
                                        <h6 class="uppercase opacity-80 font-bold mb-2">
                                            <a class="link link-hover" href="#">
                                                Gouvernance
                                            </a>
                                        </h6>
                                        <a class="link link-hover">
                                            Le Comité de Direction
                                        </a>
                                    </nav>
                                    <nav class="flex flex-col min-w-40">
                                        <h6 class="uppercase opacity-80 font-bold mb-2">
                                            <a class="link link-hover" href="#">
                                                Nos Filiales
                                            </a>
                                        </h6>
                                        <a class="link link-hover">Filiales Vin & Vignes</a>
                                        <a class="link link-hover">Filiales Elevages</a>
                                        <a class="link link-hover">Filiales Agroalimentaires</a>
                                        <a class="link link-hover">Filiales Grandes Cultures</a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="font-racing"><a>Notre politique RSE</a></li>
                <li class="font-racing"><a>Contact</a></li>
                <li class="font-racing">
                    <a href="https://alliancebfc.softy.pro/offres" target="_blank">
                        Nous Rejoindre
                    </a>
                </li>
            </ul>
        </div>

        <!-- End -->
        <div class="navbar-end hidden lg:inline-flex">
            <a class="btn btn-ghost text-[#00A099] font-bold">
                MaCoopEnLigne <x-icon name="bx-right-arrow-alt" class="h-5 w-5 inline"></x-icon>
            </a>
        </div>
        <div class="navbar-end lg:hidden">

        </div>
    </div>
</div>


