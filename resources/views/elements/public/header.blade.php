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
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-primary btn-outline btn-md">
                    <x-icon name="fas-arrow-right-to-city" class="h-5 w-5 inline"></x-icon> Espace Connexion
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-64 p-2 shadow">
                    <li class="menu-title text-center">
                        Adhérent
                    </li>
                    <li>
                        <a class="text-[#00A099] font-bold" href="https://www.macoopenligne.fr/coop/" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Calque_1" x="0px" y="0px" width="30px" height="30px" viewBox="0 0 198 198" enable-background="new 0 0 198 198" xml:space="preserve">
                                <g id="Calque_2_1_">
                                    <g id="DESKTOP">
                                        <g id="Video">
                                            <path fill="#00A099" d="M90.5,12.6c38.9,0.1,71.8,28.7,77.2,67.2l12.9,2.1c-4.8-49.8-49-86.2-98.8-81.4s-86.2,49-81.4,98.8     c1.5,15.3,6.8,30,15.6,42.7l4.4-4.8l2.8-7.3C1.4,92.7,13.9,45,51.1,23.2C63.1,16.2,76.7,12.5,90.5,12.6z"/>
                                            <path fill="#00A099" d="M161.6,122.6c-11.4,25.3-35.5,42.7-63.1,45.5L85.8,181c1.6,0.1,3.2,0.1,4.8,0.1     c35.8,0,68.3-21.2,82.8-53.9L161.6,122.6z"/>
                                            <path fill="#00A099" d="M57.5,106.6c9.1-0.1,18.1,0.5,27.1,1.7c0,0,29.3,5,40.3,11.7l-4.7,18.6c-4.8-2.4-25.4-11-30.8-13.1     c-10.4-3.9-21-6.8-31.9-8.8L57.5,106.6z"/>
                                            <path fill="#00A099" d="M89.5,71c29-3.5,62.2,0.2,71,1.3c-2-7.5-5.2-14.6-9.4-21.1c-22.5-2.8-60.5,3.9-60.5,3.9     c-36.6,9.3-53.9,17.7-70.4,26.8c-0.2,1.3-0.3,2.6-0.4,3.9C38.2,79.8,52.6,75.4,89.5,71z"/>
                                            <path fill="#00A099" d="M64.4,149.1h55.3c3.8,0,6.9-3.1,6.9-6.9V40.8c0-3.8-3.1-6.9-6.9-6.9H64.4c-3.8,0-6.9,3.1-6.9,6.9l0,0     v28.3c-0.1,1.9,1.4,3.5,3.3,3.6c1.9,0.1,3.5-1.4,3.6-3.3c0-0.1,0-0.2,0-0.4V42.7h55.3v83H64.4V117c0.1-1.9-1.4-3.5-3.3-3.6     c-1.9-0.1-3.5,1.4-3.6,3.3c0,0.1,0,0.2,0,0.4v25.2C57.4,146,60.5,149.1,64.4,149.1C64.4,149.1,64.4,149.1,64.4,149.1z M81,134h22     v6.3H81V134z M15,164.4L46.5,196c2.9,2.8,7.5,2.7,10.3-0.2c2.7-2.8,2.7-7.3,0-10.1l-31.5-31.5c-2.7-3-7.4-3.2-10.3-0.4     c-3,2.7-3.2,7.4-0.4,10.3C14.7,164.2,14.9,164.3,15,164.4z"/>
                                            <path fill="#00A099" d="M31.8,113c-3.4-0.3-6-0.6-8.8-0.8c-0.4-1.2-0.8-2.5-1.1-3.7c3.4-0.4,6.7-0.8,11-1.1L31.8,113z"/>
                                            <path fill="#00A099" d="M161.6,86.1c0,0,0,0.1-0.1,0.2c-45.3-8-69.6-5-69.6-5l0,0c-2.8,0.1-4.5,0.2-4.5,0.2     c-25.3,0.9-50.1,7.1-67.7,13c0.1,1.8,0.3,3.5,0.5,5.3c4.7-0.6,10.1-1.3,15.9-1.9c0.9-0.9,1.9-1.5,3.1-2l23.1-9.7     c4.9-2,10.4,0.3,12.5,5.2c0.6,1.5,0.9,3.1,0.7,4.8l0,0l5.9,0.2c29.1,1.5,56.9,9.3,76.6,16.3c14.4,5.4,28.7,11.8,28.7,11.8     c4.6-9.7,8.2-19.8,10.6-30.2C186.3,91.2,170.8,87.8,161.6,86.1z"/>
                                            <path fill="#00A099" d="M33,149l30.6,30.6c2.7,2.7,7.1,2.7,9.8,0c0,0,0,0,0,0l24.8-24.8H64.3c-3.6,0-7-1.4-9.5-4l0,0     c-2.5-2.5-4-6-4-9.6v-23.4l1.1-7.6l17.3-7.2c4.4-1.8,6.5-6.9,4.7-11.3c-1.8-4.4-6.9-6.5-11.3-4.7l0,0l-22.6,9.5     c-3.2,1.3-5.3,4.5-5.3,7.9l-5.7,29.2C27.6,138.4,29.5,145.4,33,149z"/>
                                        </g>
                                    </g>
                                </g>
                                </svg>
                            MaCoopEnLigne
                        </a>
                    </li>
                    <li>
                        <div class="divider my-1"></div>
                    </li>
                    <li class="menu-title text-center">
                        Salarié
                    </li>
                    <li>
                        <a class="text-primary font-bold" href="{{ route('auth.login') }}" target="_blank">
                            <x-icon name="fas-right-to-bracket" class="h-7 w-7 inline"></x-icon> Espace Bourgogne du Sud
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="navbar-end lg:hidden"></div>
    </div>
</div>


