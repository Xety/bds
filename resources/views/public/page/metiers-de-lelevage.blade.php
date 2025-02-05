@extends('layouts.public')
{!! config(['app.title' => 'Metiers de L\'élevage']) !!}

@push('meta')
    <x-meta title="Metiers de L'élevage"/>
@endpush

@push('scripts')
    <script src="https://unpkg.com/waypoints@4.0.1/lib/noframework.waypoints.min.js"></script>
    <script type="text/javascript">
        new Waypoint({
            element: document.getElementById('nutricoop'),
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
    <div class="bg-[url('/images/public/metiers_de_elevage.jpg')] bg-fixed bg-center bg-no-repeat bg-cover min-h-dvh">
        <div class="bg-gray-800 opacity-60 absolute h-full w-full top-0 left-0"></div>
        <div class="flex flex-col relative min-h-dvh items-center justify-center">
            <div class="delay-[300ms] duration-[600ms] taos:translate-y-[-200px] taos:opacity-0" data-taos-offset="500">
                <h3 class="text-3xl text-[#97B816] font-bds italic">
                    Metiers De
                </h3>
                <h1 class="text-6xl lg:text-8xl font-bold text-white font-racing text-center uppercase mb-8 drop-shadow-md">
                    l'élevage
                </h1>
            </div>

        </div>
    </div>

    <div class="absolute w-full -bottom-0.5 left-0 fill-[#97B816] transform rotate-180">
        <svg class="relative block h-[85px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="#97B816" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path d="M0,6V0h1000v100L0,6z"></path>
        </svg>
    </div>
</section>

<section class="relative">
    <div class="bg-[#97B816] text-white px-[5%] pb-[15%] pt-[10%]">

        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 mb-5 content-center delay-[300ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0" data-taos-offset="200">
                <div class="flex flex-col">
                    <div class="mb-2">
                        <h4 class="text-white text-2xl italic">L'élevage Au Sein De La Coopérative Bourgogne Du Sud</h4>
                    </div>
                    <div class="mb-6">
                        <h2 class="uppercase text-6xl text-white font-racing">propose une approche globale des exploitations</h2>
                    </div>
                    <div class="mb-6 flex flex-col lg:flex-row gap-4 text-justify">
                        <p class="text-white italic text-xl">
                            En effet ce service ne cesse de se développer. Les experts du service travaillent sur plusieurs problématiques. Les problématiques de productions et conservations des fourrages,
                            mais aussi les problématiques de suivi zootechnique des élevages, en passant par des solutions d’hygiène pour les élevages.
                        </p>
                        <p class="text-white italic text-xl">
                            Nous proposons une offre importante en équipement et matériel d’élevage. Tout ça associé à un conseil personnalisé, qui vient compléter les prestations du service.
                        </p>
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

<section class="relative">
    <div class="bg-[#1b252f] text-white px-[5%] pb-[15%] pt-[10%]">
        <div class="absolute w-full -top-0.5 left-0 fill-white">
            <svg class="relative block h-[40px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="primaryColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                <path d="M0,6V0h1000v100L0,6z"></path>
            </svg>
        </div>

        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 lg:col-span-6 mb-5 content-center delay-[300ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0" data-taos-offset="200">
                <div class="flex flex-col">
                    <div class="mb-6">
                        <h2 class="uppercase text-6xl text-white font-racing">chez bourgogne du sud</h2>
                    </div>
                    <div class="mb-6 flex flex-col lg:flex-row gap-4 text-justify">
                        <p class="text-white italic text-xl">
                            Nous proposons aussi une offre très complète en aliments. Elle comprend nos partenaires locaux (PHILICOT et SANDERS).
                            Mais aussi une offre Mash spécifique de qualité, NUTRICOOP, créée et développée par notre coopérative.
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="uppercase text-6xl text-white font-racing">nutricoop</h2>
                    </div>
                    <div class="mb-6 flex flex-col lg:flex-row gap-4 text-justify">
                        <p class="text-white italic text-xl">
                            NUTRICOOP respecte des cahiers des charges des filières locales, et s’appuie sur nos ressources locales et originales :
                            les Expellors de colza et soja, issus de notre unité de trituration de Chalon-sur-Saône (EXTRUSEL).
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-6 mb-5 content-center">
                <img
                    class="inline-block delay-[300ms] duration-[600ms] taos:[transform:translate3d(200px,200px,0)] taos:opacity-0" data-taos-offset="200"
                    src="{{ asset('images/bds/nutricoop-1024x750.png') }}"
                    alt="Nutricoop">
            </div>
            <div class="col-span-12 lg:col-span-6 mb-5 content-center">
                <div id="nutricoop" class="flex flex-col gap-4">
                    <div>
                        <span class="flex justify-between">
                            Local <span class="italic">100%</span>
                        </span>
                        <div class="bg-white rounded h-4">
                            <div aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar rounded bg-[#97B816] h-4 transition-all duration-1000 ease-linear" style="width: 0; transition: width 0.3s;"></div>
                        </div>
                    </div>
                    <div>
                        <span class="flex justify-between">
                            Qualité <span class="italic">100%</span>
                        </span>
                        <div class="bg-white rounded h-4">
                            <div aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar rounded bg-[#97B816] h-4 transition-all duration-1000 ease-linear" style="width: 0; transition: width 0.6s;"></div>
                        </div>
                    </div>
                    <div>
                        <span class="flex justify-between">
                            Engagement <span class="italic">100%</span>
                        </span>
                        <div class="bg-white rounded h-4">
                            <div aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar rounded bg-[#97B816] h-4 transition-all duration-1000 ease-linear" style="width: 0; transition: width 0.9s;"></div>
                        </div>
                    </div>
                </div>
                <div class="mt-16 italic">
                    Une unité de stockage de matières premières au cœur de la zone de notre coopérative permet de fournir également de manière efficace,
                    une large gamme de matières premières et de céréales aux éleveurs.
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
