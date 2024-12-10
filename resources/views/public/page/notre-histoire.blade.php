@extends('layouts.public')
{!! config(['app.title' => 'Notre Histoire']) !!}

@push('meta')
    <x-meta title="Notre Histoire"/>
@endpush

@push('scripts')
    <script>
        function scrollToForm(id) {
            document.querySelector(id).scrollIntoView({behavior: 'smooth'});
        }
    </script>
@endpush


@section('content')
<section class="relative">
    <div class="bg-primary px-[5%] py-[10%]">
        <div class="bg-[url('/images/bds/overlay_2.png')] bg-no-repeat opacity-20 absolute h-full w-full top-0 left-0 z-0"></div>
        <div class="grid grid-cols-12 gap-4 z-10 relative">
            <div class="col-span-12 lg:col-span-6 mb-5 content-center delay-[300ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0" data-taos-offset="400">
                <div class="flex flex-col">
                    <div class="mb-6">
                        <h1 class="uppercase text-6xl text-white font-racing text-center">
                            L'histoire De la Coopérative Bourgogne du sud
                        </h1>
                    </div>
                    <div class="mb-6 hidden lg:flex flex-row lg:flex-row lg:gap-4 text-justify">
                        <p class="text-white italic">
                            Première coopérative céréalière constituée en France, la Coopérative Bourgogne du Sud tire ses origines du syndicalisme viticole. Les règles de fonctionnement
                            originales modèlent l’entreprise dans la durée, le respect de l’Homme et du travail.
                        </p>
                    </div>
                    <div>
                        <a href="javascript: scrollToForm('#timeline');" class="btn text-primary">
                            A propos <x-icon name="fas-arrow-down" class="h-5 w-5"></x-icon>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-6">
                <img
                    class="lg:mb-[-100%] inline-block shadow-xl rounded-[300px_100px_100px_100px] delay-[300ms] duration-[600ms] taos:[transform:translate3d(200px,200px,0)] taos:opacity-0" data-taos-offset="200"
                    src="{{ asset('images/bds/siege-verdun.jpg') }}"
                    alt="Siège Verdun">
            </div>
        </div>
        <div class="absolute w-full -bottom-0.5 left-0 fill-white transform rotate-180">
            <svg class="relative block h-[40px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="primaryColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                <path d="M0,6V0h1000v100L0,6z"></path>
            </svg>
        </div>
    </div>
</section>

<section class="relative overflow-hidden" id="timeline">
    <div class="bg-[#1b252f] text-white px-[5%] pb-[15%] pt-[10%]">
        <div class="absolute w-full -top-0.5 left-0 fill-white">
            <svg class="relative block h-[40px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="primaryColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                <path d="M0,6V0h1000v100L0,6z"></path>
            </svg>
        </div>

        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 mb-5 content-center delay-[300ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0" data-taos-offset="200">
                <div class="flex flex-col text-center">
                    <div class="mb-6">
                        <h2 class="uppercase text-4xl text-white font-racing text-center">
                            A propos de notre Coopérative
                        </h2>
                    </div>
                    <div class="mb-6">
                        <p class="text-white italic">
                            Il faut savoir que le mouvement coopératif est né des grandes crises de l’agriculture.
                            <br/>
                            Et c’est en 1930, à Verdun-sur-le-Doubs, que la première coopérative Céréalière est créée.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <ul class="timeline timeline-snap-icon max-md:timeline-compact timeline-vertical">
            <li>
                <div class="timeline-middle">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-5 w-5">
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="timeline-start mb-10 md:text-end delay-[300ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0" data-taos-offset="300">
                    <time class="text-lg font-mono italic">
                        1886
                    </time>
                    <div class="font-black">
                        Création du Syndicat Agricole et Viticole de Beaune.
                    </div>
                </div>
                <hr />
            </li>
            <li>
                <hr />
                <div class="timeline-middle">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-5 w-5">
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="timeline-end mb-10 delay-[300ms] duration-[600ms] taos:translate-x-[200px] taos:opacity-0" data-taos-offset="300">
                    <time class="text-lg font-mono italic">
                        1930
                    </time>
                    <div class="font-black">
                        Création de la 1ère Coopérative Céréalière française à Verdun s/Doubs.
                    </div>
                </div>
                <hr />
            </li>
            <li>
                <hr />
                <div class="timeline-middle">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-5 w-5">
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="timeline-start mb-10 md:text-end delay-[300ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0" data-taos-offset="300">
                    <time class="text-lg font-mono italic">
                        1934
                    </time>
                    <div class="font-black">
                        Fondation des Coopératives de Seurre, Bligny sur Ouche, St Gengoux le National, Chalon sur Saône et Sennecey le Grand.
                    </div>
                </div>
                <hr />
            </li>
            <li>
                <hr />
                <div class="timeline-middle">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-5 w-5">
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="timeline-end mb-10 delay-[300ms] duration-[600ms] taos:translate-x-[200px] taos:opacity-0" data-taos-offset="300">
                    <time class="text-lg font-mono italic">
                        1936
                    </time>
                    <div class="font-black">
                        Fondation des coopératives de Pierre de Bresse et Tournus
                    </div>
                </div>
                <hr />
            </li>
            <li>
                <hr />
                <div class="timeline-middle">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-5 w-5">
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="timeline-start mb-10 md:text-end delay-[300ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0" data-taos-offset="300">
                    <time class="text-lg font-mono italic">
                        1972
                    </time>
                    <div class="font-black">
                        Constitution de l’Union de Coopératives UCOSEL.
                    </div>
                </div>
                <hr />
            </li>
            <li>
                <hr />
                <div class="timeline-middle">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-5 w-5">
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="timeline-end mb-10 delay-[300ms] duration-[600ms] taos:translate-x-[200px] taos:opacity-0" data-taos-offset="300">
                    <time class="text-lg font-mono italic">
                        1991
                    </time>
                    <div class="font-black">
                        Fusion de la Coopérative Verdun-Chalon-Pierre avec celle de St Gengoux le National.
                    </div>
                </div>
                <hr />
            </li>
            <li>
                <hr />
                <div class="timeline-middle">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-5 w-5">
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="timeline-start mb-10 md:text-end delay-[300ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0" data-taos-offset="300">
                    <time class="text-lg font-mono italic">
                        1993
                    </time>
                    <div class="font-black">
                        Fusion de la Coopérative de Verdun avec celle de Beaune.
                    </div>
                </div>
                <hr />
            </li>
            <li>
                <hr />
                <div class="timeline-middle">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-5 w-5">
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="timeline-end mb-10 delay-[300ms] duration-[600ms] taos:translate-x-[200px] taos:opacity-0" data-taos-offset="300">
                    <time class="text-lg font-mono italic">
                        1999
                    </time>
                    <div class="font-black">
                        Fusion de la Coopérative Beaune-Verdun avec celle de Seurre.
                    </div>
                </div>
                <hr />
            </li>
            <li>
                <hr />
                <div class="timeline-middle">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-5 w-5">
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="timeline-start mb-10 md:text-end delay-[300ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0" data-taos-offset="300">
                    <time class="text-lg font-mono italic">
                        2006
                    </time>
                    <div class="font-black">
                        Fusion de la Coopérative Beaune-Verdun-Seurre avec la Coopérative CAVS : constitution de la <span class="italic text-primary">Coopérative</span> <span class="italic text-[#A50343]">Bourgogne</span> <span class="italic text-[#97B816]">du</span> <span class="italic text-[#FFCC00]">Sud</span>.
                    </div>
                </div>
            </li>
        </ul>

        <div class="absolute w-full -bottom-0.5 left-0 fill-white transform rotate-180">
            <svg class="relative block h-[40px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="primaryColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                <path d="M0,6V0h1000v100L0,6z"></path>
            </svg>
        </div>
    </div>
</section>

<section class="relative break-words overflow-hidden">
    <div class="px-[5%] py-[10%]">
        <div class="bg-[url('/images/bds/overlay_3.png')] bg-no-repeat opacity-40 absolute h-full w-full top-0 left-0 z-0"></div>
        <div class="absolute w-full -top-0.5 left-0 fill-white">
            <svg class="relative block h-[40px] w-full left-1/2" style="transform: translateX(-50%) rotateY(180deg);" fill="primaryColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                <path d="M0,6V0h1000v100L0,6z"></path>
            </svg>
        </div>

        <div class="grid grid-cols-12 gap-4 z-10 relative">
            <div class="col-span-12 lg:col-span-6">
                <img
                    class="lg:mb-[-100%] inline-block shadow-xl rounded-[100px_100px_300px_100px] delay-[300ms] duration-[600ms] taos:translate-x-[-200px] taos:opacity-0" data-taos-offset="200"
                    src="{{ asset('images/bds/verdun-vue-drone.png') }}"
                    alt="Silo Verdun">
            </div>
            <div class="col-span-12 lg:col-span-6 mb-5 content-center">
                <div class="flex flex-col">
                    <div class="mb-6 delay-[300ms] duration-[600ms] taos:translate-y-[-200px] taos:opacity-0" data-taos-offset="200">
                        <h2 class="uppercase text-5xl text-primary font-racing text-center">
                            Stockage, Séchage et Commercialisation de Céréales et Produits Agricoles de Qualité
                        </h2>
                    </div>
                    <div class="mb-6 flex flex-col gap-4 text-justify delay-[300ms] duration-[600ms] taos:translate-x-[200px] taos:opacity-0" data-taos-offset="200">
                        <p class="italic">
                            La Coopérative Agricole et Viticole Bourgogne du Sud relève de la branche des Coopératives Agricoles, de céréales, de meunerie,
                            d’approvisionnement, d’alimentation du bétail et d’oléagineux, dite   « V Branches » et dépend du syndicat de La Coopération
                            Agricole (LCA).
                        </p>
                        <p class="italic">
                            Elle stocke, sèche et commercialise les céréales produites dans nos régions, fabrique et commercialise des semences, commercialise
                            tous les produits nécessaires et liés à la culture, la viticulture et l’élevage (traitements phytosanitaires, matériaux et outils divers…).
                        </p>
                        <p class="italic">
                            La Coopérative Bourgogne du Sud a un esprit d’amélioration continue, soucieuse de répondre parfaitement aux attentes de ses
                            clients meuniers, amidonniers et industriels.
                        </p>
                        <p class="italic">
                            La Coopérative donne une place importante à la production contractuelle de qualité et met en œuvre les moyens pour connaître
                            parfaitement les caractéristiques de toutes les marchandises stockées avec l’application d’un vaste plan d’échantillonnage.
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

@endsection
