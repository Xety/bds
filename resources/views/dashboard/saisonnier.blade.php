@extends('layouts.app')
{!! config(['app.title' => 'Tableau de bord']) !!}

@push('meta')
    <x-meta title="Tableau de bord"/>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">
        <div class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-12">
                <div
                    class="relative p-6 shadow-md border rounded-lg h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300 text-center bg-[url('/images/bds/bds.jpg')] bg-center bg-cover bg-no-repeat">
                    <span
                        class="absolute top-0 left-0 w-full h-full bg-repeat rounded-xl opacity-40 bg-[url('/images/bds/overlay.png')]"></span>
                    <span
                        class="absolute top-0 left-0 w-full h-full bg-cover rounded-xl opacity-40 bg-gradient-to-tl from-gray-900 to-gray-900"></span>
                    <h1 class="relative text-5xl mb-4 text-base-100 dark:text-primary-content uppercase font-racing z-1">
                        Bienvenue<br>
                        à la<br>
                        <img src="{{ asset('images/logos/bds_blanc2.png') }}" alt="Coopérative Bourgogne du Sud Logo"
                             class="inline-block w-28 relative z-1 mb-4 mt-4">
                    </h1>
                    <span class="text-base-100 font-bold dark:text-primary-content relative z-1">
                        Pour vous accompagner au mieux dans votre arrivée et votre intégration au sein de l'entreprise, merci de consulter les informations ci-dessous.
                    </span>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-6">
                <div
                    class="p-6 shadow-md border rounded-lg h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <h2 class="text-xl font-bold">
                        <x-icon name="fas-shield-halved" class="h-6 w-6 inline"></x-icon> Les règles de sécurité au sein des silos
                    </h2>
                    <div class="divider"></div>

                    <ul class="steps steps-vertical">
                        <li data-content="●" class="step step-neutral !text-left mb-3">Les chaussures de sécurité sont
                            obligatoires dès lors que vous prenez votre poste, et ce, jusqu'à la fin de votre poste.
                        </li>
                        <li data-content="●" class="step step-neutral !text-left mb-3">Les masques respiratoires sont
                            fortement recommandés lorsque vous effectuez des opérations de nettoyage dans les silos.
                        </li>
                        <li data-content="●" class="step step-neutral !text-left mb-3">Zone ATEX : En période
                            d’exploitation, beaucoup de poussières sont en suspension. Il suffit d’une étincelle ou une
                            élévation locale de température trop importante pour qu’ait lieu une explosion. Les flammes
                            se propagent alors très rapidement. Veillez à respecter strictement les zones fumeurs du
                            site.
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-6">
                <div
                    class="p-6 shadow-md border rounded-lg h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <h2 class="text-xl font-bold">
                        <x-icon name="fas-code-fork" class="h-6 w-6 inline"></x-icon> Les règles de circulation au sein des silos
                    </h2>
                    <div class="divider"></div>

                    <ul class="steps steps-vertical">
                        <li data-content="●" class="step step-neutral !text-left mb-3">Un plan de circulation est
                            disponible dans l'ensemble des sites de la Coopérative Bourgogne du Sud, veuillez prendre
                            connaissance de ce plan en demandant à votre responsable où il se situe.
                        </li>
                        <li data-content="●" class="step step-neutral !text-left mb-3">Lorsque vous vous déplacez sur un
                            site, veuillez porter votre chasuble que la Coopérative vous a fournie à votre arrivée afin
                            d'être vue par les adhérents et les chauffeurs présents sur le site et donc garantir votre
                            sécurité.
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-6">
                <div
                    class="p-6 shadow-md border rounded-lg h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <h2 class="text-xl font-bold">
                        <x-icon name="fas-users" class="h-6 w-6 inline"></x-icon> Les règles de bonne conduite dans l'entreprise
                    </h2>
                    <div class="divider"></div>

                    <ul class="steps steps-vertical">
                        <li data-content="●" class="step step-neutral !text-left mb-3">Chaque salarié doit adopter un
                            comportement fondé sur l'honnêteté, l'équité, le respect de la personne dans ses rapports
                            avec ses collègues, mais également avec les adhérents, les chauffeurs et les partenaires.
                        </li>
                        <li data-content="●" class="step step-neutral !text-left mb-3">Il appartient à chaque salarié
                            d'acquérir les connaissances en matière de loi et de réglementation nécessaires à l'exercice
                            de ses fonctions, et à sa hiérarchie de s’assurer qu’il a bien été en mesure de les
                            acquérir.
                        </li>
                        <li data-content="●" class="step step-neutral !text-left mb-3">L'image de l'entreprise est
                            essentielle au développement de ses activités et à sa prospérité. Chaque salarié participe à
                            la réputation de l'entreprise par son comportement ou ses déclarations, il doit donc veiller
                            à observer un comportement professionnel.
                        </li>
                        <li data-content="●" class="step step-neutral !text-left mb-3">La Coopérative Bourgogne du Sud
                            veille à limiter l'impact de ses activités et celles des utilisateurs de ses services par la
                            mise en œuvre d'une politique RSE. L'implication quotidienne des salariés est essentielle
                            pour concrétiser les résultats attendus de cette politique.
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-6">
                <div
                    class="p-6 shadow-md border rounded-lg h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <h2 class="text-xl font-bold">
                        <x-icon name="fas-phone" class="h-6 w-6 inline"></x-icon> Les numéros utiles en cas de problème
                    </h2>
                    <div class="divider"></div>

                    <ul class="steps steps-vertical">
                        <li data-content="●" class="step step-neutral !text-left mb-3">
                            Responsable(s) de site : <br>
                            @forelse($managers as $manager)
                                - {{ $manager->full_name }} : {{ $manager->cell_phone }}<br>
                            @empty
                                Il n'y a pas de responsable sur ce site.
                            @endforelse
                        </li>
                        <li data-content="●" class="step step-neutral !text-left">
                            Site de {{ $site->name }} : {{ $site->office_phone }} @if($site->cell_phone) {{ $site->cell_phone }} @endif
                        </li>
                        <li data-content="●" class="step step-neutral !text-left">Pompier : 18 - 112</li>
                        <li data-content="●" class="step step-neutral !text-left">SAMU : 15</li>
                    </ul>
                </div>
            </div>

            <div class="col-span-12">
                <div
                    class="p-6 shadow-md border rounded-lg h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <h2 class="text-xl font-bold">
                        <x-icon name="fas-handshake" class="h-6 w-6 inline"></x-icon> Nous recrutons !
                    </h2>
                    <div class="divider"></div>
                    <div class="text-center">
                        <p class="mb-3">
                            Envie de transformer votre expérience saisonnière en une opportunité à long terme ? Nous recrutons pour des postes évolutifs. Intégrez notre entreprise et grandissez avec nous !
                        </p>
                        <a href="https://alliancebfc.softy.pro/offres" target="_blank" class="btn btn-primary">
                            <x-icon name="fas-file-alt" class="h-5 w-5"></x-icon>
                            Consulter les offres
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- QrCode Modal --}}
    <livewire:qr-code-modal>
@endsection
