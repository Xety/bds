@extends('layouts.public')
{!! config(['app.title' => 'Métier Des Grandes Cultures']) !!}

@push('meta')
    <x-meta title="Métier Des Grandes Cultures"/>
@endpush


@section('content')
<section class="relative">
    <div class="bg-[url('/images/public/metiers_des_grandes_cultures.jpg')] bg-fixed bg-center bg-no-repeat bg-cover min-h-dvh">
        <div class="bg-gray-800 opacity-60 absolute h-full w-full top-0 left-0"></div>
        <div class="flex flex-col relative min-h-dvh items-center justify-center">
            <div class="text-center delay-[300ms] duration-[600ms] taos:translate-y-[-200px] taos:opacity-0" data-taos-offset="500">
                <h3 class="text-3xl text-[#FFCC00] font-bds italic">
                    Metiers Des
                </h3>
                <h1 class="text-6xl lg:text-8xl font-bold text-white font-racing text-center uppercase mb-8 drop-shadow-md">
                    Grandes <br>Cultures
                </h1>
                <div class="font-bold text-6xl text-[#FFCC00] font-bds italic">
                    + 1500
                </div>
                <div class="text-white text-xl">
                    Exploitations Agricoles en Grandes Cultures
                </div>
            </div>

        </div>
    </div>

    <div class="absolute w-full -bottom-0.5 left-0 fill-[#FFCC00] transform rotate-180">
        <svg class="relative block h-[85px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="#FFCC00" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path d="M0,6V0h1000v100L0,6z"></path>
        </svg>
    </div>
</section>

<section class="relative">
    <div class="bg-[#FFCC00] text-white px-[5%] pb-[15%] pt-[10%]">

        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 mb-5 content-center text-center">
                <div class="flex flex-col">
                    <div class="mb-6 delay-[300ms] duration-[600ms] taos:translate-y-[-100%] taos:opacity-0" data-taos-offset="300">
                        <h2 class="uppercase text-6xl text-white font-racing">
                            Une approche des marchés bâtie avec les autres coopératives de la région
                        </h2>
                    </div>
                    <div class="mb-6 flex flex-col gap-4 text-white italic text-xl delay-[300ms] duration-[600ms] taos:translate-y-[100%] taos:opacity-0" data-taos-offset="200">
                        <p>
                            L’Union AREA mutualise les approvisionnements. Cette Union regroupe des coopératives d’Alsace, de Champagne, de Lorraine, de Rhône-Alpes,
                            de Franche-Comté, d’Auvergne et de Bourgogne. L’Union CEREVIA est présente pour la commercialisation des céréales. Cette union regroupe les
                            ventes de 3 Coopératives implantées en Bourgogne Franche-Comté et Rhône-Alpes.
                        </p>
                        <p>
                            CEREVIA est un des acteurs majeurs du marché français. Il est très engagé sur les débouchés méditerranéens grâce à son site de Fos-sur-Mer.
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
            <div class="col-span-12 mb-5 content-center text-center">
                <div class="flex flex-col">
                    <div class="mb-6 delay-[300ms] duration-[600ms] taos:translate-y-[-100%] taos:opacity-0" data-taos-offset="300">
                        <h2 class="uppercase text-6xl text-white font-racing">
                            Un service logistique avec de nombreux atouts pour les grandes cultures
                        </h2>
                    </div>
                    <div class="mb-6 flex flex-col gap-4 text-white italic text-xl delay-[300ms] duration-[600ms] taos:translate-y-[100%] taos:opacity-0" data-taos-offset="200">
                        <p>
                            Grâce à sa position géographique centrale dans le Val de Saône, la coopérative tire parti de la voie fluviale pour optimiser ses coûts de transport.
                            Au port fluvial Sud de Chalon-sur-Saône, une plateforme pour les fertilisants reçoit les engrais par bateau ou par train. Elle permet également de
                            les mélanger, de les ensacher ou de les mettre à disposition des adhérents en vrac.
                        </p>
                        <p>
                            Le réseau de stockage des céréales est principalement situé le long de la Saône, avec une capacité de stockage à Saint-Usage, Pagny,
                            Verdun-sur-le-Doubs, Chalon Nord et Chalon Sud.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute w-full -bottom-0.5 left-0 fill-[#FFCC00] transform rotate-180">
            <svg class="relative block h-[40px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="#FFCC00" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                <path d="M0,6V0h1000v100L0,6z"></path>
            </svg>
        </div>
    </div>
</section>

<section class="relative">
    <div class="absolute w-full -top-0.5 left-0 fill-[#FFCC00] z-10">
        <svg class="relative block h-[40px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="#FFCC00" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path d="M0,6V0h1000v100L0,6z"></path>
        </svg>
    </div>
    <div class="bg-[url('/images/public/metiers_des_grandes_cultures2.jpg')] bg-fixed bg-center bg-no-repeat bg-cover min-h-dvh px-[5%] pb-[15%] pt-[10%]">
        <div class="bg-gray-800 opacity-60 absolute h-full w-full top-0 left-0"></div>

        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 mb-5 content-center text-center relative">
                <div class="flex flex-col">
                    <div class="mb-6 delay-[300ms] duration-[600ms] taos:translate-y-[-100%] taos:opacity-0" data-taos-offset="300">
                        <h2 class="uppercase text-6xl text-white font-racing">
                            Pour nos adhérents
                        </h2>
                    </div>
                    <div class="mb-6 flex flex-col gap-6 text-white italic text-xl delay-[300ms] duration-[600ms] taos:translate-y-[100%] taos:opacity-0" data-taos-offset="200">
                        <p>
                            Pour aider les adhérents dans la conduite de leurs cultures, une vingtaine de techniciens les accompagnent. Leur connaissance du secteur renforce leur expertise de conseil, ainsi que les résultats du réseau d’expérimentation de la Coopérative.
                        </p>
                        <p>
                            De même que notre réseau d’observation de parcelles de références et de station météo qui alimentent les outils d’aides à la décision. Depuis 10 ans maintenant, Bourgogne du Sud contribue au réseau Artemis de parcelles d’essais longue durée. Tout en intégrant à l’échelle de la rotation différents leviers pour la gestion du capital sol (fertilité, désherbage…)
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute w-full -bottom-0.5 left-0 fill-white transform rotate-180">
        <svg class="relative block h-[40px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="primaryColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path d="M0,6V0h1000v100L0,6z"></path>
        </svg>
    </div>
</section>
@endsection
