<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SelvahCorrespondenceSheetTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $correspondenceSheets = [
            [
                'id' => 1,
                'site_id' => 2,
                'user_id'=> 1,
                'poste_type' => 'matin',

                'bmp1_numero_lot' => '149-5-65-54887',
                'bmp1_en_stock' => 1,
                'bmp1_en_trituration' => 1,
                'bmp1_heure_debut' => now(),
                'bmp1_heure_fin' => null,

                'bmp2_numero_lot' => '149-5-65-55187',
                'bmp2_en_stock' => 1,
                'bmp2_en_trituration' => 0,
                'bmp2_heure_debut' => null,
                'bmp2_heure_fin' => null,

                'btf1_numero_lot' => '519-037',
                'btf1_en_stock' => 1,
                'btf1_en_extrusion' => 1,
                'btf1_heure_arret' => null,
                'btf1_heure_redemarrage' => now(),

                'chaudiere_trituration_durete_eau' => 1,
                'chaudiere_trituration_niveau_glace' => 1,
                'chaudiere_trituration_niveau_sel' => 1,
                'chaudiere_extrusion_durete_eau' => 1,
                'chaudiere_extrusion_niveau_glace' => 1,
                'chaudiere_extrusion_niveau_sel' => 1,
                'chaudiere_commentaire' => 'Fuite sur la chaudière n°3',

                'compteur_huile_brute' => 345985,
                'compteur_eau_1' => 3459.8,
                'compteur_eau_2' => 159.85,
                'compteur_eau_3' => 259.56,
                'compteur_eau_4' => 59.49,
                'compteur_eau_5' => 45.85,
                'compteur_consommation_eau_1' => 5.8,
                'compteur_consommation_eau_2' => 5.85,
                'compteur_consommation_eau_3' => 5.85,
                'compteur_consommation_eau_4' => 3.96,
                'compteur_consommation_eau_5' => 2.78,

                'filtration_nettoyage_filtre' => 0,
                'filtration_conformite_plateaux' => 0,
                'filtration_commentaire' => null,

                'ns1_numero_lot' => '519-037',
                'ns1_date_changement_lot' => now(),
                'ns1_heure_controle' => now(),
                'ns1_grille_conforme' => 1,

                'aimant_amont_broyeur_graine_1' => 'conforme',
                'aimant_broyeur_graine_2' => 'conforme',
                'aimant_broyeur_ttx_3' => 'conforme',
                'aimant_refroidisseur_4' => 'non-applicable',
                'aimant_tremie_boisseaux_5' => 'non-applicable',
                'aimant_tci1_6' => 'conforme',

                'magnetique_ensachage_en_cours' => 0,
                'magnetique_ensachage_type' => 'non-applicable',
                'magnetique_sacs_heure_controle' => now(),
                'magnetique_sacs_etalon_fe' => 'detecte',
                'magnetique_sacs_etalon_nfe' => 'detecte',
                'magnetique_sacs_etalon_ss' => 'detecte',
                'magnetique_big_bag_heure_controle' => now(),
                'magnetique_big_bag_etalon_fe' => 'non-applicable',
                'magnetique_big_bag_etalon_nfe' => 'non-applicable',
                'magnetique_big_bag_etalon_ss' => 'non-applicable',
                'magnetique_validation_ccp' => 'oui',

                'echantillon_graines_broyees' => 1,
                'echantillon_graines_broyees_controle_visuel' => 'conforme',
                'echantillon_coques' => 1,
                'echantillon_coques_controle_visuel' => 'conforme',
                'echantillon_huile_brute_broyees' => 0,
                'echantillon_huile_brute_controle_visuel' => 'non-applicable',
                'echantillon_farine_ttx_broyees' => 1,
                'echantillon_farine_ttx_controle_visuel' => 'conforme',

                'echantillon_ensachage_circuit' => 'bpf1',
                'echantillon_pvt_sachet_debut_production' => 1,
                'echantillon_pvt_sachet_debut_production_controle_visuel' => 'conforme',
                'echantillon_pvt_sachet_prise_poste' => 0,
                'echantillon_pvt_sachet_prise_poste_controle_visuel' => 'non-applicable',
                'echantillon_pvt_pot_sterile' => 1,
                'echantillon_pvt_pot_sterile_controle_visuel' => 'conforme',

                'remarques_apres_visite_usine' => 'Usine à l\'arrêt',
                'problemes_defauts_rencontrer_pendant_poste' => '-Démarrage de la zone Broyage à 6h00',
                'consignes_poste_a_poste' => null,

                'created_at' => now()->subMinutes(),
                'updated_at' => now()->subMinutes(),
            ],
            [
                'id' => 2,
                'site_id' => 2,
                'user_id'=> 3,
                'poste_type' => 'apres-midi',

                'bmp1_numero_lot' => '149-5-65-54887',
                'bmp1_en_stock' => 0,
                'bmp1_en_trituration' => 1,
                'bmp1_heure_debut' => null,
                'bmp1_heure_fin' => null,

                'bmp2_numero_lot' => '149-5-65-55187',
                'bmp2_en_stock' => 1,
                'bmp2_en_trituration' => 0,
                'bmp2_heure_debut' => null,
                'bmp2_heure_fin' => null,

                'btf1_numero_lot' => '519-037',
                'btf1_en_stock' => 1,
                'btf1_en_extrusion' => 1,
                'btf1_heure_arret' => null,
                'btf1_heure_redemarrage' => null,

                'chaudiere_trituration_durete_eau' => 1,
                'chaudiere_trituration_niveau_glace' => 1,
                'chaudiere_trituration_niveau_sel' => 1,
                'chaudiere_extrusion_durete_eau' => 1,
                'chaudiere_extrusion_niveau_glace' => 1,
                'chaudiere_extrusion_niveau_sel' => 1,
                'chaudiere_commentaire' => 'Fuite sur la chaudière n°3',

                'compteur_huile_brute' => 345985,
                'compteur_eau_1' => null,
                'compteur_eau_2' => null,
                'compteur_eau_3' => null,
                'compteur_eau_4' => null,
                'compteur_eau_5' => null,
                'compteur_consommation_eau_1' => null,
                'compteur_consommation_eau_2' => null,
                'compteur_consommation_eau_3' => null,
                'compteur_consommation_eau_4' => null,
                'compteur_consommation_eau_5' => null,

                'filtration_nettoyage_filtre' => 1,
                'filtration_conformite_plateaux' => 0,
                'filtration_commentaire' => '1 filtre percé',

                'ns1_numero_lot' => null,
                'ns1_date_changement_lot' => null,
                'ns1_heure_controle' => null,
                'ns1_grille_conforme' => 0,

                'aimant_amont_broyeur_graine_1' => 'conforme',
                'aimant_broyeur_graine_2' => 'conforme',
                'aimant_broyeur_ttx_3' => 'conforme',
                'aimant_refroidisseur_4' => 'non-applicable',
                'aimant_tremie_boisseaux_5' => 'non-applicable',
                'aimant_tci1_6' => 'conforme',

                'magnetique_ensachage_en_cours' => 0,
                'magnetique_ensachage_type' => 'non-applicable',
                'magnetique_sacs_heure_controle' => now(),
                'magnetique_sacs_etalon_fe' => 'detecte',
                'magnetique_sacs_etalon_nfe' => 'detecte',
                'magnetique_sacs_etalon_ss' => 'detecte',
                'magnetique_big_bag_heure_controle' => now(),
                'magnetique_big_bag_etalon_fe' => 'non-applicable',
                'magnetique_big_bag_etalon_nfe' => 'non-applicable',
                'magnetique_big_bag_etalon_ss' => 'non-applicable',
                'magnetique_validation_ccp' => 'oui',

                'echantillon_graines_broyees' => 1,
                'echantillon_graines_broyees_controle_visuel' => 'conforme',
                'echantillon_coques' => 1,
                'echantillon_coques_controle_visuel' => 'conforme',
                'echantillon_huile_brute_broyees' => 0,
                'echantillon_huile_brute_controle_visuel' => 'non-applicable',
                'echantillon_farine_ttx_broyees' => 1,
                'echantillon_farine_ttx_controle_visuel' => 'conforme',

                'echantillon_ensachage_circuit' => 'bpf1',
                'echantillon_pvt_sachet_debut_production' => 1,
                'echantillon_pvt_sachet_debut_production_controle_visuel' => 'conforme',
                'echantillon_pvt_sachet_prise_poste' => 0,
                'echantillon_pvt_sachet_prise_poste_controle_visuel' => 'non-applicable',
                'echantillon_pvt_pot_sterile' => 1,
                'echantillon_pvt_pot_sterile_controle_visuel' => 'conforme',

                'remarques_apres_visite_usine' => 'Usine à l\'arrêt',
                'problemes_defauts_rencontrer_pendant_poste' => '-Démarrage de la zone Broyage à 6h00',
                'consignes_poste_a_poste' => null,

                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('selvah_correspondence_sheets')->insert($correspondenceSheets);
    }
}
