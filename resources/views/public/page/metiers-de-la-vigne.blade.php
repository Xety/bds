@extends('layouts.public')
{!! config(['app.title' => 'Métiers du Vin et de la Vigne']) !!}

@push('meta')
    <x-meta title="Métiers du Vin et de la Vigne"/>
@endpush

@push('scripts')
    <script src="https://unpkg.com/waypoints@4.0.1/lib/noframework.waypoints.min.js"></script>
    <script type="text/javascript">
        new Waypoint({
            element: document.getElementById('vignes'),
            offset: '60%',
            handler: function(direction) {
                const progress = document.getElementsByClassName('progress-bar');

                for (let i = 0; i < progress.length; i++) {
                    progress[i].style.width = progress[i].getAttribute('aria-valuenow') + '%';
                }
            }
        });
    </script>
@endpush


@section('content')
<section class="relative">
    <div class="bg-[url('/images/public/metiers_de_la_vigne.jpg')] bg-fixed bg-center bg-no-repeat bg-cover min-h-dvh">
        <div class="bg-gray-800 opacity-60 absolute h-full w-full top-0 left-0"></div>
        <div class="flex flex-col relative min-h-dvh items-center justify-center">
            <div class="text-center delay-[300ms] duration-[600ms] taos:translate-y-[-200px] taos:opacity-0" data-taos-offset="500">
                <h3 class="text-3xl text-[#A50343] font-bds italic">
                    Metiers du
                </h3>
                <h1 class="text-6xl lg:text-8xl font-bold text-white font-racing text-center uppercase mb-8 drop-shadow-md">
                    Vin & de la <br>Vigne
                </h1>
            </div>

        </div>
    </div>

    <div class="absolute w-full -bottom-0.5 left-0 fill-[#A50343] transform rotate-180">
        <svg class="relative block h-[85px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="#A50343" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path d="M0,6V0h1000v100L0,6z"></path>
        </svg>
    </div>
</section>

<section class="relative">
    <div class="bg-[#A50343] text-white px-[5%] pb-[10%] pt-[10%]">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 mb-5 content-center text-center">
                <div class="flex flex-col">
                    <div class="mb-6 delay-[300ms] duration-[600ms] taos:translate-y-[-100%] taos:opacity-0" data-taos-offset="300">
                        <h2 class="uppercase text-6xl text-white font-racing">
                            Un référencement de qualité
                        </h2>
                    </div>
                    <div class="mb-6 flex flex-col gap-4 text-white italic text-xl delay-[300ms] duration-[600ms] taos:translate-y-[100%] taos:opacity-0" data-taos-offset="200">
                        <p>
                            Les approvisionnements pour la vigne et le vin se font avec
                            l’Union AREA. AREA est une union qui regroupe des coopératives de Champagne,
                            d’Alsace, du Jura, de St Pourçain et de Bourgogne.
                        </p>
                        <p>
                            Les achats pour la cave se font en partenariat avec le Centre
                            Œnologique de Bourgogne (COEB), laboratoire certifié… dont la Coopérative est
                            actionnaire avec le Bureau Interprofessionnel des Vins de Bourgogne (BIVB).
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute w-full -bottom-0.5 left-0 fill-[#A50343] transform rotate-180">
            <svg class="relative block h-[40px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="#A50343" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                <path d="M0,6V0h1000v100L0,6z"></path>
            </svg>
        </div>
    </div>
</section>

<section class="relative">
    <div class="absolute w-full -top-0.5 left-0 fill-[#A50343] z-10">
        <svg class="relative block h-[40px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="#A50343" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path d="M0,6V0h1000v100L0,6z"></path>
        </svg>
    </div>
    <div class="bg-[url('/images/public/metiers_de_la_vigne_2.jpg')] bg-fixed bg-center bg-no-repeat bg-cover min-h-dvh px-[5%] pb-[5%] pt-[10%]">
        <div class="bg-gray-800 opacity-60 absolute h-full w-full top-0 left-0"></div>

        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 mb-5 content-center text-center relative">
                <div class="flex flex-col">
                    <div class="mb-6 delay-[300ms] duration-[600ms] taos:translate-y-[-100%] taos:opacity-0" data-taos-offset="300">
                        <h2 class="uppercase text-6xl text-white font-racing">
                            Un service logistique basé sur la réactivité
                        </h2>
                    </div>
                    <div class="mb-6 flex flex-col gap-6 text-white italic text-xl delay-[300ms] duration-[600ms] taos:translate-y-[100%] taos:opacity-0" data-taos-offset="200">
                        <p>
                            Nous avons des plateformes de distribution spécialisées
                            (matières sèches, produits pour la santé des plantes, fertilisants, palissage).
                            Ainsi nous assurons un approvisionnement dans des délais très courts des exploitations viticoles.
                        </p>
                        <p>
                            Nous avons aussi un site dédié aux produits pour la cave et
                            la vinification. Nous pouvons réaliser une personnalisation des emballages aux couleurs des viticulteurs.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute w-full -bottom-0.5 left-0 fill-[#A50343] transform rotate-180">
        <svg class="relative block h-[40px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="primaryColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path d="M0,6V0h1000v100L0,6z"></path>
        </svg>
    </div>
</section>

<section class="relative">
    <div class="bg-[#1b252f] text-white px-[5%] pb-[10%] pt-[10%]">
        <div class="absolute w-full -top-0.5 left-0 fill-[#A50343] z-10">
            <svg class="relative block h-[40px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="primaryColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                <path d="M0,6V0h1000v100L0,6z"></path>
            </svg>
        </div>

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 mb-5 content-center text-center">
                <div class="flex flex-col">
                    <div class="mb-6 delay-[300ms] duration-[600ms] taos:translate-y-[-100%] taos:opacity-0" data-taos-offset="300">
                        <h2 class="uppercase text-6xl text-white font-racing">
                            Un service de conseil engagé dans la viticulture durable
                        </h2>
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-6 mb-5 content-center delay-[300ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0" data-taos-offset="200">
                <div class="flex flex-col">
                    <div class="mb-6 flex flex-col gap-4 text-justify">
                        <p class="text-white italic text-lg">
                            15 techniciens viticoles sont à l’écoute des viticulteurs pour leur fournir des outils d’aide à la décision, des prévisions
                            et des données météo. C’est ainsi que nous pouvons leur fournir des résultats issus d’une expérimentation locale et
                            des conseils personnalisés. Des contrats de services personnalisés sont proposés aux viticulteurs qui peuvent s’appuyer
                            sur une connaissance précise de l’état du vignoble (56 parcelles de références), des risques sanitaires (modélisation) et
                            des conditions climatiques (60 stations météo de Mâcon à Dijon). Toute notre énergie est au service de la spécificité du
                            vignoble bourguignon avec ses multiples climats, ses itinéraires variés (conventionné, viticulture biologique, biodynamie).
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-6 mb-5 content-center">
                <div id="vignes" class="flex flex-col gap-4">
                    <div>
                        <span class="flex justify-between">
                            Local <span class="italic">100%</span>
                        </span>
                        <div class="bg-white rounded h-8">
                            <div aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar rounded bg-[#A50343] h-8 transition-all duration-1000 ease-linear" style="width: 0; transition: width 0.3s;"></div>
                        </div>
                    </div>
                    <div>
                        <span class="flex justify-between">
                            Qualité <span class="italic">100%</span>
                        </span>
                        <div class="bg-white rounded h-8">
                            <div aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar rounded bg-[#A50343] h-8 transition-all duration-1000 ease-linear" style="width: 0; transition: width 0.6s;"></div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <ul class="text-lg">
                            <li class="mb-3">
                                <x-icon name="fas-users" class="h-8 w-8 inline text-[#A50343] mr-2"></x-icon> 15 techniciens viticoles
                            </li>
                            <li class="mb-3">
                                <x-icon name="fas-map-pin" class="h-8 w-8 inline text-[#A50343] mr-2"></x-icon> 56 parcelles de références
                            </li>
                            <li class="mb-3">
                                <x-icon name="fas-cloud-sun-rain" class="h-8 w-8 inline text-[#A50343] mr-2"></x-icon> 60 stations météo de Mâcon à Dijon
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute w-full -bottom-0.5 left-0 fill-white transform rotate-180">
            <svg class="relative block h-[40px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="primaryColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                <path d="M0,6V0h1000v100L0,6z"></path>
            </svg>
        </div>
    </div>
</section>
@endsection
