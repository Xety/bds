@extends('layouts.app')
{!! config(['app.title' => 'Fiche de Correspondance N°' . $sheet->getKey()]) !!}

@push('meta')
    <x-meta title="{{ 'Fiche de Correspondance N°' . $sheet->getKey()}}"/>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">
        <hgroup class="text-center px-5 pb-5">
            <h1 class="text-4xl font-selvah">
                <x-icon name="fas-file-invoice" class="h-10 w-10 inline"></x-icon> Fiche de Correspondance N°
                <span class="prose text-4xl">
                    <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                        {{ $sheet->getKey() }}
                    </code>
                </span>
            </h1>
        </hgroup>

        <div class="shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
            @php $online = $sheet->user->online; @endphp
            <div class="flex-col xl:flex xl:flex-row justify-between items-center border border-gray-200 dark:border-gray-700 rounded-tl-lg rounded-tr-lg p-4">
                <div class="flex items-center space-x-3">
                    <div class="tooltip" data-tip="{{ $online ? $sheet->user->full_name.' est en ligne' : $sheet->user->full_name.' est hors ligne' }}" >
                        <div class="avatar {{ $online ? 'online' : 'offline' }}">
                            <div class="mask mask-squircle w-12 h-12 {{ $online ? 'tooltip' : '' }}">
                                <img src="{{ asset($sheet->user->avatar) }}" alt="Avatar de {{ $sheet->user->full_name }}"/>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a class="link link-hover link-primary font-bold" href="{{ $sheet->user->show_url }}">
                            {{ $sheet->user->full_name }}
                        </a>
                    </div>
                </div>

                <div>
                    <span class="font-bold">Poste</span> : {{ $sheet->poste_type->label() }}
                </div>
                <div>
                    <span class="font-bold">Date</span> : {{ $sheet->created_at->translatedFormat( 'D j M Y') }}
                </div>
            </div>


            <div class="flex-col xl:flex xl:flex-row justify-between items-center border border-t-0 border-gray-200 dark:border-gray-700 p-4">
                <div class="flex-col mb-4">
                    <div>
                        <span class="font-bold">N° LOT BMP1 : </span>@if($sheet->bmp1_numero_lot) <code class="code rounded-sm">{{ $sheet->bmp1_numero_lot }}</code>@endif
                    </div>
                    <div>
                        En stock :
                        @if($sheet->bmp1_en_stock)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div>
                        En cours de trituration :
                        @if($sheet->bmp1_en_trituration)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div>
                        Heure début : {{ $sheet->bmp1_heure_debut?->translatedFormat( 'H:i') }}
                    </div>
                    <div>
                        Heure fin : {{ $sheet->bmp1_heure_fin?->translatedFormat( 'H:i') }}
                    </div>
                </div>

                <div class="flex-col mb-4">
                    <div>
                        <span class="font-bold">N° LOT BMP2 : </span>@if($sheet->bmp2_numero_lot) <code class="code rounded-sm">{{ $sheet->bmp2_numero_lot }}</code>@endif
                    </div>
                    <div>
                        En stock :
                        @if($sheet->bmp2_en_stock)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div>
                        En cours de trituration :
                        @if($sheet->bmp2_en_trituration)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div>
                        Heure début : {{ $sheet->bmp2_heure_debut?->translatedFormat( 'H:i') }}
                    </div>
                    <div>
                        Heure fin : {{ $sheet->bmp2_heure_fin?->translatedFormat( 'H:i') }}
                    </div>
                </div>

                <div class="flex-col mb-4">
                    <div>
                        <span class="font-bold">N° LOT BTF1 : </span>@if($sheet->btf1_numero_lot) <code class="code rounded-sm">{{ $sheet->btf1_numero_lot }}</code>@endif
                    </div>
                    <div>
                        En stock :
                        @if($sheet->btf1_en_stock)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div>
                        En cours d'extrusion :
                        @if($sheet->btf1_en_extrusion)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div>
                        Heure d'arrêt : {{ $sheet->btf1_heure_arret?->translatedFormat( 'H:i') }}
                    </div>
                    <div>
                        Heure redémarrage : {{ $sheet->btf1_heure_redemarrage?->translatedFormat( 'H:i') }}
                    </div>
                </div>
            </div>

            <div class="flex-col justify-between items-center border border-t-0 border-gray-200 dark:border-gray-700 p-4">
                <hgroup>
                    <h3 class="font-bold mb-2">
                        Suivi des chaudières
                    </h3>
                    <p class="text-gray-400">
                        A CHAQUE DÉBUT DE POSTE SI CHAUDIÈRES EN FONCTIONNEMENT
                    </p>
                </hgroup>
                <div class="grid grid-cols-12 xl:gap-4 mb-5 xl:mb-0">
                    <div class="col-span-12 xl:col-span-4">
                        Vérification de la dureté de l'eau :
                    </div>
                    <div class="col-span-12 xl:col-span-4">
                        Chaudière trituration :
                        @if($sheet->chaudiere_trituration_durete_eau)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div class="col-span-12 xl:col-span-4">
                        Chaudière extrusion :
                        @if($sheet->chaudiere_extrusion_durete_eau)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-12 xl:gap-4 mb-5 xl:mb-0">
                    <div class="col-span-12 xl:col-span-4">
                        Vérification des niveaux à glace :
                    </div>
                    <div class="col-span-12 xl:col-span-4">
                        Chaudière trituration :
                        @if($sheet->chaudiere_trituration_niveau_glace)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div class="col-span-12 xl:col-span-4">
                        Chaudière extrusion :
                        @if($sheet->chaudiere_extrusion_niveau_glace)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-12 xl:gap-4 mb-5 xl:mb-0">
                    <div class="col-span-12 xl:col-span-4">
                        Vérification du niveau de sel :
                    </div>
                    <div class="col-span-12 xl:col-span-4">
                        Chaudière trituration :
                        @if($sheet->chaudiere_trituration_niveau_sel)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div class="col-span-12 xl:col-span-4">
                        Chaudière extrusion :
                        @if($sheet->chaudiere_extrusion_niveau_sel)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                </div>
                <div>
                    <h4 class="font-bold my-2">
                        Remarques :
                    </h4>
                    <p class="prose">
                        {{ $sheet->chaudiere_commentaire }}
                    </p>
                </div>
            </div>

            <div class="flex-col justify-between items-center border border-t-0 border-gray-200 dark:border-gray-700 p-4">
                <hgroup>
                    <h3 class="font-bold mb-2">
                        Relevé des compteurs
                    </h3>
                    <p class="text-gray-400">
                        A CHAQUE POSTE
                    </p>
                </hgroup>
                <div class="grid grid-cols-12 xl:gap-4 mb-5 xl:mb-0">
                    <div class="col-span-12 mb-2">
                        Huile brute : @if($sheet->compteur_huile_brute) <code class="code rounded-sm">{{ $sheet->compteur_huile_brute }}</code> @endif
                    </div>
                    <p class="col-span-12 text-gray-400">
                        AU 1ER DÉMARRAGE TRITURATION DE LA SEMAINE
                    </p>
                    <div class="col-span-12 xl:col-span-7">
                        Eau brute N°1
                        <div class="dropdown dropdown-hover dropdown-bottom">
                            <label tabindex="0" class="hover:cursor-pointer text-info">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </label>
                            <div tabindex="0" class="card compact dropdown-content z-[1] shadow bg-base-100 dark:bg-base-200 rounded-box w-64">
                                <div class="card-body">
                                    <p>Général chaufferie</p>
                                </div>
                            </div>
                        </div> :
                        @if($sheet->compteur_eau_1) <code class="code rounded-sm">{{ $sheet->compteur_eau_1 }}</code> @endif
                    </div>
                    <div class="col-span-12 xl:col-span-5 mb-2">
                        Consommation N°1 : @if($sheet->compteur_consommation_eau_1) <code class="code rounded-sm">{{ $sheet->compteur_consommation_eau_1 }}</code> @endif
                    </div>
                    <div class="col-span-12 xl:col-span-7">
                        Eau brute N°2
                        <div class="dropdown dropdown-hover dropdown-bottom">
                            <label tabindex="0" class="hover:cursor-pointer text-info">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </label>
                            <div tabindex="0" class="card compact dropdown-content z-[1] shadow bg-base-100 dark:bg-base-200 rounded-box w-64">
                                <div class="card-body">
                                    <p>Chaudière trituration</p>
                                </div>
                            </div>
                        </div> :
                        @if($sheet->compteur_eau_2) <code class="code rounded-sm">{{ $sheet->compteur_eau_2 }}</code> @endif
                    </div>
                    <div class="col-span-12 xl:col-span-5 mb-2">
                        Consommation N°2 : @if($sheet->compteur_consommation_eau_2) <code class="code rounded-sm">{{ $sheet->compteur_consommation_eau_2 }}</code> @endif
                    </div>
                    <div class="col-span-12 xl:col-span-7">
                        Eau brute N°3
                        <div class="dropdown dropdown-hover dropdown-bottom">
                            <label tabindex="0" class="hover:cursor-pointer text-info">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </label>
                            <div tabindex="0" class="card compact dropdown-content z-[1] shadow bg-base-100 dark:bg-base-200 rounded-box w-64">
                                <div class="card-body">
                                    <p>Chaudière extrusion</p>
                                </div>
                            </div>
                        </div> :
                        @if($sheet->compteur_eau_3) <code class="code rounded-sm">{{ $sheet->compteur_eau_3 }}</code> @endif
                    </div>
                    <div class="col-span-12 xl:col-span-5 mb-2">
                        Consommation N°3 : @if($sheet->compteur_consommation_eau_3) <code class="code rounded-sm">{{ $sheet->compteur_consommation_eau_3 }}</code> @endif
                    </div>
                    <div class="col-span-12 xl:col-span-7">
                        Eau brute N°4
                        <div class="dropdown dropdown-hover dropdown-bottom">
                            <label tabindex="0" class="hover:cursor-pointer text-info">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </label>
                            <div tabindex="0" class="card compact dropdown-content z-[1] shadow bg-base-100 dark:bg-base-200 rounded-box w-64">
                                <div class="card-body">
                                    <p>Pompe à eau Extrudeur</p>
                                </div>
                            </div>
                        </div> :
                        @if($sheet->compteur_eau_4) <code class="code rounded-sm">{{ $sheet->compteur_eau_4 }}</code> @endif
                    </div>
                    <div class="col-span-12 xl:col-span-5 mb-2">
                        Consommation N°4 : @if($sheet->compteur_consommation_eau_4) <code class="code rounded-sm">{{ $sheet->compteur_consommation_eau_4 }}</code> @endif
                    </div>
                    <div class="col-span-12 xl:col-span-7">
                        Eau brute N°5
                        <div class="dropdown dropdown-hover dropdown-bottom">
                            <label tabindex="0" class="hover:cursor-pointer text-info">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </label>
                            <div tabindex="0" class="card compact dropdown-content z-[1] shadow bg-base-100 dark:bg-base-200 rounded-box w-64">
                                <div class="card-body">
                                    <p>Pompe à eau Préconditionneur</p>
                                </div>
                            </div>
                        </div> :
                        @if($sheet->compteur_eau_5) <code class="code rounded-sm">{{ $sheet->compteur_eau_5 }}</code> @endif
                    </div>
                    <div class="col-span-12 xl:col-span-5">
                        Consommation N°5 : @if($sheet->compteur_consommation_eau_5) <code class="code rounded-sm">{{ $sheet->compteur_consommation_eau_5 }}</code> @endif
                    </div>
                </div>
            </div>

            <div class="flex-col xl:flex xl:flex-row justify-between border border-t-0 border-gray-200 dark:border-gray-700 p-4">
                <div>
                    <hgroup>
                        <h3 class="font-bold mb-2">
                            Fonctionnement Filtration
                        </h3>
                        <p class="text-gray-400">
                            A CHAQUE FILTRATION
                        </p>
                    </hgroup>
                    <div class="flex-col mb-4">
                        <div>
                            Nettoyage des plateaux de filtration :
                            @if($sheet->filtration_nettoyage_plateaux)
                                <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                            @else
                                <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                            @endif
                        </div>
                        <div>
                            Conformité de l'état des plateaux de filtration :
                            <span class="tooltip" data-tip="{{ $sheet->filtration_plateaux_conforme->label() }}">{!! $sheet->filtration_plateaux_conforme->icon() !!}</span>
                        </div>
                        <div>
                            <h4 class="font-bold my-2">
                                Remarques :
                            </h4>
                            <p class="prose">
                                {{ $sheet->filtration_commentaire }}
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <hgroup>
                        <h3 class="font-bold mb-2">
                            Fonctionnement Nettoyeur/Séparateur 1
                        </h3>
                        <p class="text-gray-400">
                            A CHAQUE CHANGEMENT DE LOT
                        </p>
                    </hgroup>
                    <div class="flex-col mb-4">
                        <div>
                            N° de lot : @if($sheet->ns1_numero_lot) <code class="code rounded-sm">{{ $sheet->ns1_numero_lot }}</code> @endif
                        </div>
                        <div>
                            Date changement de lot : {{ $sheet->ns1_date_changement_lot?->translatedFormat( 'D j M Y') }}
                        </div>
                        <div>
                            Heure du contrôle : {{ $sheet->ns1_heure_controle?->translatedFormat( 'H:i') }}
                        </div>
                        <div>
                            Intégrité de la grille conforme :
                            <span class="tooltip" data-tip="{{ $sheet->ns1_grille_conforme->label() }}">{!! $sheet->ns1_grille_conforme->icon() !!}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 xl:gap-4 mb-5 xl:mb-0 border border-t-0 border-gray-200 dark:border-gray-700 p-4">
                <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                    <hgroup>
                        <h3 class="font-bold mb-2">
                            Fonctionnement des aimants
                        </h3>
                        <p class="underline">
                            Salle Grise
                        </p>
                        <p class="text-gray-400">
                            1 FOIS PAR POSTE
                        </p>
                    </hgroup>
                    <div>
                        Aimant amont broyeur graines N°1 : <span class="tooltip" data-tip="{{ $sheet->aimant_amont_broyeur_graine_1->label() }}">{!! $sheet->aimant_amont_broyeur_graine_1->icon() !!}</span>
                    </div>
                    <div>
                        Aimant broyeur graines N°2 : <span class="tooltip" data-tip="{{ $sheet->aimant_broyeur_graine_2->label() }}">{!! $sheet->aimant_broyeur_graine_2->icon() !!}</span>
                    </div>
                    <div>
                        Aimant broyeur TTX N°3 : <span class="tooltip" data-tip="{{ $sheet->aimant_broyeur_ttx_3->label() }}">{!! $sheet->aimant_broyeur_ttx_3->icon() !!}</span>
                    </div>
                    <p class="text-gray-400 mt-4">
                        A CHAQUE DÉMARRAGE TRITURATION
                    </p>
                    <div>
                        Aimant TCI1 N°6 : <span class="tooltip" data-tip="{{ $sheet->aimant_tci1_6->label() }}">{!! $sheet->aimant_tci1_6->icon() !!}</span>
                    </div>
                    <p class="underline mt-4">
                        Salle Blanche
                    </p>
                    <p class="text-gray-400">
                        A CHAQUE DÉMARRAGE EXTRUSION
                    </p>
                    <div>
                        Aimant derrière refroidisseur N°4 : <span class="tooltip" data-tip="{{ $sheet->aimant_refroidisseur_4->label() }}">{!! $sheet->aimant_refroidisseur_4->icon() !!}</span>
                    </div>
                    <div>
                        Aimant trémie boisseaux N°5 : <span class="tooltip" data-tip="{{ $sheet->aimant_tremie_boisseaux_5->label() }}">{!! $sheet->aimant_tremie_boisseaux_5->icon() !!}</span>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-6">
                    <hgroup>
                        <h3 class="font-bold mb-2">
                            Fonctionnement des magnétiques ensacheuse sacs et/ou big-bag CCP1
                        </h3>
                        <p class="text-gray-400">
                            A CHAQUE DÉBUT DE PRODUCTION ET A CHAQUE DÉBUT DE POSTE
                        </p>
                    </hgroup>
                    <div>
                        Ensachage en cours :
                        @if($sheet->magnetique_ensachage_en_cours)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div>
                        Type d'ensachage : <span class="tooltip" data-tip="{{ $sheet->magnetique_ensachage_type->label() }}">{!! $sheet->magnetique_ensachage_type->icon() !!}</span>
                    </div>
                    <div class="border border-dotted border-b-0 border-r-0 border-l-0 border-gray-200 my-2">
                        <p class="underline">
                            Ensacheuse sacs
                        </p>
                        <div>
                            Heure contrôle : {{ $sheet->magnetique_sacs_heure_controle?->translatedFormat( 'H:i') }}
                        </div>
                        <div class="flex items-center gap-1">
                            Étalon FE : <span class="tooltip" data-tip="{{ $sheet->magnetique_sacs_etalon_fe->label() }}">{!! $sheet->magnetique_sacs_etalon_fe->icon() !!}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            Étalon NFE : <span class="tooltip" data-tip="{{ $sheet->magnetique_sacs_etalon_nfe->label() }}">{!! $sheet->magnetique_sacs_etalon_nfe->icon() !!}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            Étalon SS : <span class="tooltip" data-tip="{{ $sheet->magnetique_sacs_etalon_ss->label() }}">{!! $sheet->magnetique_sacs_etalon_ss->icon() !!}</span>
                        </div>
                    </div>
                    <div class="border border-dotted border-b-0 border-r-0 border-l-0 border-gray-200 my-2">
                        <p class="underline">
                            Station remplissage Big-bag
                        </p>
                        <div>
                            Heure contrôle : {{ $sheet->magnetique_big_bag_heure_controle?->translatedFormat( 'H:i') }}
                        </div>
                        <div class="flex items-center gap-1">
                            Étalon FE : <span class="tooltip" data-tip="{{ $sheet->magnetique_big_bag_etalon_fe->label() }}">{!! $sheet->magnetique_big_bag_etalon_fe->icon() !!}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            Étalon NFE : <span class="tooltip" data-tip="{{ $sheet->magnetique_big_bag_etalon_nfe->label() }}">{!! $sheet->magnetique_big_bag_etalon_nfe->icon() !!}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            Étalon SS : <span class="tooltip" data-tip="{{ $sheet->magnetique_big_bag_etalon_ss->label() }}">{!! $sheet->magnetique_big_bag_etalon_ss->icon() !!}</span>
                        </div>
                    </div>
                    <div class="border border-dotted border-b-0 border-r-0 border-l-0 border-gray-200 my-2">
                        <div class="flex items-center gap-1">
                            Validation du CCP
                            <div class="dropdown dropdown-hover dropdown-bottom">
                                <label tabindex="0" class="hover:cursor-pointer text-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </label>
                                <div tabindex="0" class="card compact dropdown-content z-[1] shadow bg-base-100 dark:bg-base-200 rounded-box w-64">
                                    <div class="card-body">
                                        <p>Tous les étalons doivent être détectés</p>
                                    </div>
                                </div>
                            </div> :
                            <span class="tooltip" data-tip="{{ $sheet->magnetique_validation_ccp->label() }}">{!! $sheet->magnetique_validation_ccp->icon() !!}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 xl:gap-4 mb-5 xl:mb-0 border border-t-0 border-gray-200 dark:border-gray-700 p-4">
                <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                    <hgroup>
                        <h3 class="font-bold mb-2">
                            Fonctionnement du BRC
                        </h3>
                        <p class="text-gray-400">
                            A CHAQUE CHANGEMENT DE LOT
                        </p>
                    </hgroup>

                    <div>
                        N° de lot : @if($sheet->brc_numero_lot) <code class="code rounded-sm">{{ $sheet->brc_numero_lot }}</code> @endif
                    </div>
                    <div>
                        Intégrité de la grille conforme :
                        @if($sheet->brc_numero_lot)
                            @if($sheet->brc_grille_conforme)
                                <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                            @else
                                <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                            @endif
                        @endif
                    </div>
                    <div>
                        État des couteaux conforme :
                        @if($sheet->brc_numero_lot)
                            @if($sheet->brc_couteaux_conforme)
                                <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                            @else
                                <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                    <hgroup>
                        <h3 class="font-bold mb-2">
                            Fonctionnement du BRT1
                        </h3>
                        <p class="text-gray-400">
                            A CHAQUE CHANGEMENT DE LOT
                        </p>
                    </hgroup>

                    <div>
                        N° de lot : @if($sheet->brt1_numero_lot) <code class="code rounded-sm">{{ $sheet->brt1_numero_lot }}</code> @endif
                    </div>
                    <div>
                        Intégrité des grilles conformes :
                        @if($sheet->brt1_numero_lot)
                            @if($sheet->brt1_grille_conforme)
                                <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                            @else
                                <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                            @endif
                        @endif
                    </div>
                    <div>
                        État des couteaux conforme :
                        @if($sheet->brt1_numero_lot)
                            @if($sheet->brt1_couteaux_conforme)
                                <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                            @else
                                <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex-col justify-between border border-t-0 border-gray-200 dark:border-gray-700 p-4">
                <hgroup>
                    <h3 class="font-bold mb-2">
                        Réalisation échantillons production zone Trituration
                    </h3>
                    <p class="text-gray-400">
                        Suivant le <a class="link link-primary" href="http://qualios.ads.corp/servlet/qualios.index?mod=0&Tri=120&Ref=27&Chap=111&LienlDClic=1489&NavPortail=0" target="_blank">MOP-SEL-010</a>
                    </p>
                </hgroup>

                <div class="grid grid-cols-12">
                    <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                        Graines Broyées :
                        @if($sheet->echantillon_graines_broyees)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                        <div>
                            Contrôle visuel : <span class="tooltip" data-tip="{{ $sheet->echantillon_graines_broyees_controle_visuel->label() }}">{!! $sheet->echantillon_graines_broyees_controle_visuel->icon() !!}</span>
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                        Coques :
                        @if($sheet->echantillon_coques)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                        <div>
                            Contrôle visuel : <span class="tooltip" data-tip="{{ $sheet->echantillon_coques_controle_visuel->label() }}">{!! $sheet->echantillon_coques_controle_visuel->icon() !!}</span>
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                        Huile Brute :
                        @if($sheet->echantillon_huile_brute)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                        <div>
                            Contrôle visuel : <span class="tooltip" data-tip="{{ $sheet->echantillon_huile_brute_controle_visuel->label() }}">{!! $sheet->echantillon_huile_brute_controle_visuel->icon() !!}</span>
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                        TTX :
                        @if($sheet->echantillon_ttx)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                        <div>
                            Contrôle visuel : <span class="tooltip" data-tip="{{ $sheet->echantillon_ttx_controle_visuel->label() }}">{!! $sheet->echantillon_ttx_controle_visuel->icon() !!}</span>
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                        Farine TTX :
                        @if($sheet->echantillon_farine_ttx)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                        <div>
                            Contrôle visuel : <span class="tooltip" data-tip="{{ $sheet->echantillon_farine_ttx_controle_visuel->label() }}">{!! $sheet->echantillon_farine_ttx_controle_visuel->icon() !!}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-col justify-between border border-t-0 border-gray-200 dark:border-gray-700 p-4">
                <hgroup>
                    <h3 class="font-bold mb-2">
                        Réalisation échantillons production et analyses manuelles zone Extrusion/Ensachage
                    </h3>
                    <p class="text-gray-400">
                        Suivant le <a class="link link-primary" href="http://qualios.ads.corp/servlet/qualios.index?mod=0&Tri=120&Ref=27&Chap=111&LienlDClic=1489&NavPortail=0" target="_blank">MOP-SEL-010</a> et <a class="link link-primary" href="http://qualios.ads.corp/servlet/qualios.index?mod=0&Tri=120&Ref=27&Chap=111&LienlDClic=1489&NavPortail=0" target="_blank">ENR-SEL-021</a>
                    </p>
                </hgroup>

                <div class="grid grid-cols-12">
                    <div class="col-span-12">
                        PVT à l'ensachage :
                        <span class="tooltip" data-tip="{{ $sheet->echantillon_ensachage_circuit->label() }}">{!! $sheet->echantillon_ensachage_circuit->icon() !!}</span>
                    </div>
                    <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                        PVT <span class="font-bold">SACHET</span> début de production (+1 heure) :
                        @if($sheet->echantillon_pvt_sachet_debut_production)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                        <div>
                            Contrôle visuel : <span class="tooltip" data-tip="{{ $sheet->echantillon_pvt_sachet_debut_production_controle_visuel->label() }}">{!! $sheet->echantillon_pvt_sachet_debut_production_controle_visuel->icon() !!}</span>
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                        PVT <span class="font-bold">SACHET</span> prise de poste et milieu de poste :
                        @if($sheet->echantillon_pvt_sachet_prise_poste)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                        <div>
                            Contrôle visuel : <span class="tooltip" data-tip="{{ $sheet->echantillon_pvt_sachet_prise_poste_controle_visuel->label() }}">{!! $sheet->echantillon_pvt_sachet_prise_poste_controle_visuel->icon() !!}</span>
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                        PVT <span class="font-bold">POT STERILE</span> début de poste (+4 heures et 24 heures plus tard) :
                        @if($sheet->echantillon_pvt_pot_sterile)
                            <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                        @else
                            <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                        @endif
                    </div>
                    <div class="col-span-12 xl:col-span-6 mb-4 xl:mb-0">
                        <div>
                            Contrôle visuel : <span class="tooltip" data-tip="{{ $sheet->echantillon_pvt_pot_sterile_controle_visuel->label() }}">{!! $sheet->echantillon_pvt_pot_sterile_controle_visuel->icon() !!}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-col justify-between border border-t-0 border-gray-200 dark:border-gray-700 p-4">
                <hgroup>
                    <h3 class="font-bold mb-2">
                        Remarques suite à la visite de l'usine
                    </h3>
                    <p class="text-gray-400">
                        Obligatoire en début de poste
                    </p>
                </hgroup>

                <p>
                    {{ $sheet->remarques_apres_visite_usine }}
                </p>
            </div>

            <div class="flex-col justify-between border border-t-0 border-gray-200 dark:border-gray-700 p-4">
                <hgroup>
                    <h3 class="font-bold mb-2">
                        Problèmes / défauts rencontrés pendant le poste
                    </h3>
                    <p class="text-gray-400">
                        Travail réalisé durant le poste
                    </p>
                </hgroup>

                <p class="mt-4">
                    {{ $sheet->problemes_defauts_rencontrer_pendant_poste }}
                </p>
            </div>

            <div class="flex-col justify-between border border-t-0 border-gray-200 dark:border-gray-700 p-4">
                <hgroup>
                    <h3 class="font-bold mb-2">
                        Consignes poste à poste
                    </h3>
                    <p class="text-gray-400">
                        Travail restant à faire
                    </p>
                </hgroup>

                <p class="mt-4">
                    {{ $sheet->consignes_poste_a_poste }}
                </p>
            </div>

            <div class="flex-col justify-between border border-t-0 border-gray-200 dark:border-gray-700 p-4">
                <hgroup>
                    <h3 class="font-bold mb-2">
                        Visa responsable production ou adjoint et remarques éventuelles
                    </h3>
                </hgroup>

                <div class="flex justify-between">
                    @if($sheet->responsable_signature_id)
                        <div>
                            {{ $sheet->responsable_commentaire }}
                        </div>
                        <div>
                            <p class="text-gray-400">
                                Signé par :
                            </p>
                            <a class="link link-hover link-primary font-bold" href="{{ $sheet->responsable->show_url }}">
                                {{ $sheet->responsable->full_name }}
                            </a>
                        </div>
                    @else
                        <div>
                            Cette fiche n'a pas encore été signé par un responsable.
                        </div>
                        <div>
                            <livewire:selvah.sign-correspondence-sheet :$sheet />
                        </div>
                    @endif

                </div>
            </div>

        </div>

    </section>
@endsection
