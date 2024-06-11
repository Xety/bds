@can('search', \BDS\Models\Selvah\CorrespondenceSheet::class)
    <div class="shadow-md border rounded-lg p-3 mb-4 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
        <x-tabs selected="operateur">
            <x-tab name="operateur" label="Opérateur / Poste">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 xl:col-span-4">
                        <x-input
                            class="min-w-max"
                            wire:model.live.debounce.400ms="filters.user_id"
                            name="filters.user_id"
                            type="text"
                            label="Opérateur"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Postes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.poste_type"
                            name="filters.poste_type"
                            label="Type de poste"
                        />
                    </div>
                </div>
            </x-tab>

            <x-tab name="bmp1" label="BMP1">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 xl:col-span-4">
                        <x-input
                            class="min-w-max"
                            wire:model.live.debounce.400ms="filters.bmp1_numero_lot"
                            name="filters.bmp1_numero_lot"
                            type="text"
                            label="Numéro lot BMP1"
                        />
                    </div>
                </div>
            </x-tab>

            <x-tab name="bmp2" label="BMP2">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 xl:col-span-4">
                        <x-input
                            class="min-w-max"
                            wire:model.live.debounce.400ms="filters.bmp2_numero_lot"
                            name="filters.bmp2_numero_lot"
                            type="text"
                            label="Numéro lot BMP2"
                        />
                    </div>
                </div>
            </x-tab>

            <x-tab name="btf1" label="BTF1">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 xl:col-span-4">
                        <x-input
                            class="min-w-max"
                            wire:model.live.debounce.400ms="filters.btf1_numero_lot"
                            name="filters.btf1_numero_lot"
                            type="text"
                            label="Numéro lot BTF1"
                        />
                    </div>
                </div>
            </x-tab>

            <x-tab name="compteurs" label="Compteurs">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 xl:col-span-4">
                        <x-input
                            class="min-w-max"
                            wire:model.live.debounce.250ms="filters.compteur_huile_brute_min"
                            name="filters.compteur_huile_brute_min"
                            class="input-sm"
                            placeholder="Mini"
                            type="number"
                            min="0"
                            step="1"
                            label="Compteur huile brute Min/Max"
                        />
                        <x-input
                            class="min-w-max"
                            wire:model.live.debounce.250ms="filters.compteur_huile_brute_max"
                            name="filters.compteur_huile_brute_max"
                            class="input-sm mt-2"
                            placeholder="Maxi"
                            type="number"
                            min="0"
                            step="1"
                        />
                    </div>
                </div>
            </x-tab>

            <x-tab name="filtration" label="Filtration">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 xl:col-span-4">
                        @php
                            $options = [
                                [
                                    'id' => '',
                                    'name' => 'Tous'
                                ],
                                [
                                    'id' => 'yes',
                                    'name' => 'Oui'
                                ],
                                [
                                    'id' => 'no',
                                    'name' => 'Non'
                                ]
                            ];
                        @endphp
                        <x-select
                            :options="$options"
                            class="select-primary min-w-max"
                            wire:model.live="filters.filtration_nettoyage_plateaux"
                            name="filters.filtration_nettoyage_plateaux"
                            label="Nettoyage plateaux de filtration"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.filtration_plateaux_conforme"
                            name="filters.filtration_plateaux_conforme"
                            label="Conformité des plateaux de filtration"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-input
                            class="min-w-max"
                            wire:model.live.debounce.400ms="filters.filtration_commentaire"
                            name="filters.filtration_commentaire"
                            type="text"
                            label="Filtration remarques"
                        />
                    </div>
                </div>
            </x-tab>

            <x-tab name="ns1" label="NS1">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 xl:col-span-4">
                        <x-input
                            class="min-w-max"
                            wire:model.live.debounce.400ms="filters.ns1_numero_lot"
                            name="filters.ns1_numero_lot"
                            type="text"
                            label="Numéro lot NS1"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.ns1_grille_conforme"
                            name="filters.ns1_grille_conforme"
                            label="Conformité des grilles du NS1"
                        />
                    </div>
                </div>
            </x-tab>

            <x-tab name="aimants" label="Aimants">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.aimant_amont_broyeur_graine_1"
                            name="filters.aimant_amont_broyeur_graine_1"
                            label="Aimant N°1 Amont EMT1"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.aimant_broyeur_graine_2"
                            name="filters.aimant_broyeur_graine_2"
                            label="Aimant N°2 EMT1"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.aimant_broyeur_ttx_3"
                            name="filters.aimant_broyeur_ttx_3"
                            label="Aimant N°3 BRT1"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.aimant_refroidisseur_4"
                            name="filters.aimant_refroidisseur_4"
                            label="Aimant N°4 Sortie refroidisseur"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.aimant_tremie_boisseaux_5"
                            name="filters.aimant_tremie_boisseaux_5"
                            label="Aimant N°5 Sortie vis VPF1/VPF2"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.aimant_tci1_6"
                            name="filters.aimant_tci1_6"
                            label="Aimant N°6 Sortie TCI1"
                        />
                    </div>
                </div>
            </x-tab>

            <x-tab name="magnetiques" label="Magnétiques Ensacheuse/BB">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 xl:col-span-4">
                        @php
                            $options = [
                                [
                                    'id' => '',
                                    'name' => 'Tous'
                                ],
                                [
                                    'id' => 'yes',
                                    'name' => 'Oui'
                                ],
                                [
                                    'id' => 'no',
                                    'name' => 'Non'
                                ]
                            ];
                        @endphp
                        <x-select
                            :options="$options"
                            class="select-primary min-w-max"
                            wire:model.live="filters.magnetique_ensachage_en_cours"
                            name="filters.magnetique_ensachage_en_cours"
                            label="Ensachage en cours"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\EnsachageType::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.magnetique_ensachage_type"
                            name="filters.magnetique_ensachage_type"
                            label="Type d'ensachage"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Validations::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.magnetique_validation_ccp"
                            name="filters.magnetique_validation_ccp"
                            label="Validation CCP"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 mt-4">
                        <hgroup>
                            <h3 class="font-bold mb-2">
                                Etalons magnétique
                            </h3>
                            <p class="text-gray-400">
                                Ensacheuse
                            </p>
                        </hgroup>
                    </div>
                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Detections::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.magnetique_sacs_etalon_fe"
                            name="filters.magnetique_sacs_etalon_fe"
                            label=" Etalon FE Sacs"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Detections::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.magnetique_sacs_etalon_nfe"
                            name="filters.magnetique_sacs_etalon_nfe"
                            label=" Etalon NFE Sacs"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Detections::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.magnetique_sacs_etalon_ss"
                            name="filters.magnetique_sacs_etalon_ss"
                            label=" Etalon SS Sacs"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 mt-4">
                        <hgroup>
                            <h3 class="font-bold mb-2">
                                Etalons magnétique
                            </h3>
                            <p class="text-gray-400">
                                Big-Bag
                            </p>
                        </hgroup>
                    </div>
                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Detections::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.magnetique_big_bag_etalon_fe"
                            name="filters.magnetique_big_bag_etalon_fe"
                            label=" Etalon FE BB"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Detections::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.magnetique_big_bag_etalon_nfe"
                            name="filters.magnetique_big_bag_etalon_nfe"
                            label=" Etalon NFE BB"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Detections::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.magnetique_big_bag_etalon_ss"
                            name="filters.magnetique_big_bag_etalon_ss"
                            label=" Etalon SS BB"
                        />
                    </div>
                </div>
            </x-tab>

            <x-tab name="brcbrt1" label="BRC/BRT1">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 mt-4">
                        <h3 class="font-bold mb-2">
                            Fonctionnement BRC
                        </h3>
                    </div>
                    <div class="col-span-12 xl:col-span-4">
                        <x-input
                            class="min-w-max"
                            wire:model.live.debounce.400ms="filters.brc_numero_lot"
                            name="filters.brc_numero_lot"
                            type="text"
                            label="Numéro lot"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.brc_grille_conforme"
                            name="filters.brc_grille_conforme"
                            label="Intégrité grille conforme"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.brc_couteaux_conforme"
                            name="filters.brc_couteaux_conforme"
                            label=" Etat des couteaux conforme"
                        />
                    </div>

                    <div class="col-span-12 mt-4">
                        <h3 class="font-bold mb-2">
                            Fonctionnement BRT1
                        </h3>
                    </div>
                    <div class="col-span-12 xl:col-span-4">
                        <x-input
                            class="min-w-max"
                            wire:model.live.debounce.400ms="filters.brt1_numero_lot"
                            name="filters.brt1_numero_lot"
                            type="text"
                            label="Numéro lot"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.brc_grille_conforme"
                            name="filters.brc_grille_conforme"
                            label="Intégrité grille conforme"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.brc_couteaux_conforme"
                            name="filters.brc_couteaux_conforme"
                            label=" Etat des couteaux conforme"
                        />
                    </div>
                </div>
            </x-tab>

            <x-tab name="echantillontrituration" label="Echantillon Trituration">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 mt-4">
                        <h3 class="font-bold">
                            Graine Broyées
                        </h3>
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        @php
                            $options = [
                                [
                                    'id' => '',
                                    'name' => 'Tous'
                                ],
                                [
                                    'id' => 'yes',
                                    'name' => 'Oui'
                                ],
                                [
                                    'id' => 'no',
                                    'name' => 'Non'
                                ]
                            ];
                        @endphp
                        <x-select
                            :options="$options"
                            class="select-primary min-w-max"
                            wire:model.live="filters.echantillon_graines_broyees"
                            name="filters.echantillon_graines_broyees"
                            label="Echantillon"
                        />
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.echantillon_graines_broyees_controle_visuel"
                            name="filters.echantillon_graines_broyees_controle_visuel"
                            label="Conformité"
                        />
                    </div>

                    <div class="col-span-12 mt-4">
                        <h3 class="font-bold">
                            Coques
                        </h3>
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        @php
                            $options = [
                                [
                                    'id' => '',
                                    'name' => 'Tous'
                                ],
                                [
                                    'id' => 'yes',
                                    'name' => 'Oui'
                                ],
                                [
                                    'id' => 'no',
                                    'name' => 'Non'
                                ]
                            ];
                        @endphp
                        <x-select
                            :options="$options"
                            class="select-primary min-w-max"
                            wire:model.live="filters.echantillon_coques"
                            name="filters.echantillon_coques"
                            label="Echantillon"
                        />
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.echantillon_coques_controle_visuel"
                            name="filters.echantillon_coques_controle_visuel"
                            label="Conformité"
                        />
                    </div>

                    <div class="col-span-12 mt-4">
                        <h3 class="font-bold">
                            Huile Brute
                        </h3>
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        @php
                            $options = [
                                [
                                    'id' => '',
                                    'name' => 'Tous'
                                ],
                                [
                                    'id' => 'yes',
                                    'name' => 'Oui'
                                ],
                                [
                                    'id' => 'no',
                                    'name' => 'Non'
                                ]
                            ];
                        @endphp
                        <x-select
                            :options="$options"
                            class="select-primary min-w-max"
                            wire:model.live="filters.echantillon_huile_brute"
                            name="filters.echantillon_huile_brute"
                            label="Echantillon"
                        />
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.echantillon_huile_brute_controle_visuel"
                            name="filters.echantillon_huile_brute_controle_visuel"
                            label="Conformité"
                        />
                    </div>

                    <div class="col-span-12 mt-4">
                        <h3 class="font-bold">
                            TTX
                        </h3>
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        @php
                            $options = [
                                [
                                    'id' => '',
                                    'name' => 'Tous'
                                ],
                                [
                                    'id' => 'yes',
                                    'name' => 'Oui'
                                ],
                                [
                                    'id' => 'no',
                                    'name' => 'Non'
                                ]
                            ];
                        @endphp
                        <x-select
                            :options="$options"
                            class="select-primary min-w-max"
                            wire:model.live="filters.echantillon_ttx"
                            name="filters.echantillon_ttx"
                            label="Echantillon"
                        />
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.echantillon_ttx_controle_visuel"
                            name="filters.echantillon_ttx_controle_visuel"
                            label="Conformité"
                        />
                    </div>

                    <div class="col-span-12 mt-4">
                        <h3 class="font-bold">
                            Farine TTX
                        </h3>
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        @php
                            $options = [
                                [
                                    'id' => '',
                                    'name' => 'Tous'
                                ],
                                [
                                    'id' => 'yes',
                                    'name' => 'Oui'
                                ],
                                [
                                    'id' => 'no',
                                    'name' => 'Non'
                                ]
                            ];
                        @endphp
                        <x-select
                            :options="$options"
                            class="select-primary min-w-max"
                            wire:model.live="filters.echantillon_farine_ttx"
                            name="filters.echantillon_farine_ttx"
                            label="Echantillon"
                        />
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.echantillon_farine_ttx_controle_visuel"
                            name="filters.echantillon_farine_ttx_controle_visuel"
                            label="Conformité"
                        />
                    </div>
                </div>
            </x-tab>

            <x-tab name="echantillonextrusion" label="Echantillon Extrusion/Ensachage">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 mt-4">
                        <h3 class="font-bold">
                            PVT SACHET début de production (+1 heure)
                        </h3>
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        @php
                            $options = [
                                [
                                    'id' => '',
                                    'name' => 'Tous'
                                ],
                                [
                                    'id' => 'yes',
                                    'name' => 'Oui'
                                ],
                                [
                                    'id' => 'no',
                                    'name' => 'Non'
                                ]
                            ];
                        @endphp
                        <x-select
                            :options="$options"
                            class="select-primary min-w-max"
                            wire:model.live="filters.echantillon_pvt_sachet_debut_production"
                            name="filters.echantillon_pvt_sachet_debut_production"
                            label="Echantillon"
                        />
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.echantillon_pvt_sachet_debut_production_controle_visuel"
                            name="filters.echantillon_pvt_sachet_debut_production_controle_visuel"
                            label="Conformité"
                        />
                    </div>

                    <div class="col-span-12 mt-4">
                        <h3 class="font-bold">
                            PVT SACHET prise de poste et milieu de poste
                        </h3>
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        @php
                            $options = [
                                [
                                    'id' => '',
                                    'name' => 'Tous'
                                ],
                                [
                                    'id' => 'yes',
                                    'name' => 'Oui'
                                ],
                                [
                                    'id' => 'no',
                                    'name' => 'Non'
                                ]
                            ];
                        @endphp
                        <x-select
                            :options="$options"
                            class="select-primary min-w-max"
                            wire:model.live="filters.echantillon_pvt_sachet_prise_poste"
                            name="filters.echantillon_pvt_sachet_prise_poste"
                            label="Echantillon"
                        />
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.echantillon_pvt_sachet_prise_poste_controle_visuel"
                            name="filters.echantillon_pvt_sachet_prise_poste_controle_visuel"
                            label="Conformité"
                        />
                    </div>

                    <div class="col-span-12 mt-4">
                        <h3 class="font-bold">
                            PVT POT STERILE début de poste (+4 heures et 24 heures plus tard)
                        </h3>
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        @php
                            $options = [
                                [
                                    'id' => '',
                                    'name' => 'Tous'
                                ],
                                [
                                    'id' => 'yes',
                                    'name' => 'Oui'
                                ],
                                [
                                    'id' => 'no',
                                    'name' => 'Non'
                                ]
                            ];
                        @endphp
                        <x-select
                            :options="$options"
                            class="select-primary min-w-max"
                            wire:model.live="filters.echantillon_pvt_pot_sterile"
                            name="filters.echantillon_pvt_pot_sterile"
                            label="Echantillon"
                        />
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        <x-select
                            :options="\BDS\Enums\Selvah\Conformes::toSelectArray()"
                            class="select-primary min-w-max"
                            wire:model.live="filters.echantillon_pvt_pot_sterile_controle_visuel"
                            name="filters.echantillon_pvt_pot_sterile_controle_visuel"
                            label="Conformité"
                        />
                    </div>
                </div>
            </x-tab>

            <x-tab name="recherchetexte" label="Recherche par texte">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 xl:col-span-4">
                        <x-input
                            class="min-w-max"
                            wire:model.live.debounce.400ms="filters.remarques_apres_visite_usine"
                            name="filters.remarques_apres_visite_usine"
                            type="text"
                            label="Remarques suite à la visite de l'usine"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-input
                            class="min-w-max"
                            wire:model.live.debounce.400ms="filters.problemes_defauts_rencontrer_pendant_poste"
                            name="filters.problemes_defauts_rencontrer_pendant_poste"
                            type="text"
                            label="Problèmes / défauts rencontrés pendant le poste"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-input
                            class="min-w-max"
                            wire:model.live.debounce.400ms="filters.consignes_poste_a_poste"
                            name="filters.consignes_poste_a_poste"
                            type="text"
                            label="Consignes poste à poste"
                        />
                    </div>
                </div>
            </x-tab>

            <x-tab name="responsables" label="Responsables">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 xl:col-span-4">
                        <x-input
                            class="min-w-max"
                            wire:model.live.debounce.400ms="filters.responsable_signature_id"
                            name="filters.responsable_signature_id"
                            type="text"
                            label="Rechercher par signataire"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-input
                            class="min-w-max"
                            wire:model.live.debounce.400ms="filters.responsable_commentaire"
                            name="filters.responsable_commentaire"
                            type="text"
                            label="Commentaire responsable"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-4">
                        <x-input
                            class="min-w-max"
                            wire:model.live.debounce.400ms="filters.consignes_poste_a_poste"
                            name="filters.consignes_poste_a_poste"
                            type="text"
                            label="Consignes poste à poste"
                        />
                    </div>
                </div>
            </x-tab>

            <x-tab name="dates" label="Date Création">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 xl:col-span-6">
                        <x-date-picker
                            wire:model.live="filters.created_min"
                            name="filters.created_min"
                            icon="fas-calendar"
                            icon-class="h-4 w-4"
                            label="Date minimum de création de la fiche"
                        />
                    </div>

                    <div class="col-span-12 xl:col-span-6">
                        <x-date-picker
                            wire:model.live="filters.created_max"
                            name="filters.created_max"
                            icon="fas-calendar"
                            icon-class="h-4 w-4"
                            label="Date maximum de création de la fiche"
                        />
                    </div>
                </div>
            </x-tab>

        </x-tabs>
    </div>
@endcan
