@extends('layouts.app')
{!! config(['app.title' => 'Gérer les Fiches de Correspondances Selvah']) !!}

@push('meta')
    <x-meta title="Gérer les Fiches de Correspondances Selvah"/>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">
        <hgroup class="text-center px-5 pb-5">
            <h1 class="text-4xl">
                <x-icon name="fas-file-invoice" class="h-10 w-10 inline"></x-icon> Gérer les Fiches de Correspondances
            </h1>
            <p class="text-gray-400 ">
                Gérer les Fiches de Correspondances de Selvah.
            </p>
        </hgroup>

        <div class="grid grid-cols-12 gap-6 mb-7">
            @forelse($sheets as $sheet)
                <div class="col-span-12 xl:col-span-6 shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                    <h2 class="text-2xl text-center mb-3">
                        Fiche de Correspondance N°{{  $sheet->id }}
                    </h2>
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
                            Poste : {{ $sheet->poste_type->label() }}
                        </div>
                        <div>
                            Date : {{ $sheet->created_at->translatedFormat( 'D j M Y') }}
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
                        <h3 class="font-bold mb-2">
                            Suivi des chaudières
                        </h3>
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
                        <h3 class="font-bold mb-2">
                            Relevé des compteurs
                        </h3>
                        <div class="grid grid-cols-12 xl:gap-4 mb-5 xl:mb-0">
                            <div class="col-span-12">
                                Huile brute : @if($sheet->compteur_huile_brute) <code class="code rounded-sm">{{ $sheet->compteur_huile_brute }}</code> @endif
                            </div>
                            <div class="col-span-12 xl:col-span-7">
                                Eau brute N°1 (Général chaufferie) : @if($sheet->compteur_eau_1) <code class="code rounded-sm">{{ $sheet->compteur_eau_1 }}</code> @endif
                            </div>
                            <div class="col-span-12 xl:col-span-5">
                                Consommation N°1 : @if($sheet->compteur_consommation_eau_1) <code class="code rounded-sm">{{ $sheet->compteur_consommation_eau_1 }}</code> @endif
                            </div>
                            <div class="col-span-12 xl:col-span-7">
                                Eau brute N°2 (Chaudière trituration) : @if($sheet->compteur_eau_2) <code class="code rounded-sm">{{ $sheet->compteur_eau_2 }}</code> @endif
                            </div>
                            <div class="col-span-12 xl:col-span-5">
                                Consommation N°2 : @if($sheet->compteur_consommation_eau_2) <code class="code rounded-sm">{{ $sheet->compteur_consommation_eau_2 }}</code> @endif
                            </div>
                            <div class="col-span-12 xl:col-span-7">
                                Eau brute N°3 (Chaudière extrusion) : @if($sheet->compteur_eau_3) <code class="code rounded-sm">{{ $sheet->compteur_eau_3 }}</code> @endif
                            </div>
                            <div class="col-span-12 xl:col-span-5">
                                Consommation N°3 : @if($sheet->compteur_consommation_eau_3) <code class="code rounded-sm">{{ $sheet->compteur_consommation_eau_3 }}</code> @endif
                            </div>
                            <div class="col-span-12 xl:col-span-7">
                                Eau brute N°4 (Pompe à eau Extrudeur) : @if($sheet->compteur_eau_4) <code class="code rounded-sm">{{ $sheet->compteur_eau_4 }}</code> @endif
                            </div>
                            <div class="col-span-12 xl:col-span-5">
                                Consommation N°4 : @if($sheet->compteur_consommation_eau_4) <code class="code rounded-sm">{{ $sheet->compteur_consommation_eau_4 }}</code> @endif
                            </div>
                            <div class="col-span-12 xl:col-span-7">
                                Eau brute N°5 (Pompe à eau Préconditionneur) : @if($sheet->compteur_eau_5) <code class="code rounded-sm">{{ $sheet->compteur_eau_5 }}</code> @endif
                            </div>
                            <div class="col-span-12 xl:col-span-5">
                                Consommation N°5 : @if($sheet->compteur_consommation_eau_5) <code class="code rounded-sm">{{ $sheet->compteur_consommation_eau_5 }}</code> @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex-col xl:flex xl:flex-row justify-between border border-t-0 border-gray-200 dark:border-gray-700 p-4">
                        <div>
                            <h3 class="font-bold mb-2">
                                Fonctionnement Filtration
                            </h3>
                            <div class="flex-col mb-4">
                                <div>
                                    Nettoyage des plateaux de filtration :
                                    @if($sheet->filtration_nettoyage_filtre)
                                        <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                                    @else
                                        <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                                    @endif
                                </div>
                                <div>
                                    Conformité de l'état des plateaux de filtration :
                                    @if($sheet->filtration_conformite_plateaux)
                                        <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                                    @else
                                        <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                                    @endif
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
                                    @if($sheet->ns1_grille_conforme)
                                        <x-icon name="fas-check" class="inline h-4 w-4 text-success"></x-icon>
                                    @else
                                        <x-icon name="fas-xmark" class="inline h-4 w-4 text-danger"></x-icon>
                                    @endif
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            @empty

            @endforelse
        </div>
    </section>
@endsection
