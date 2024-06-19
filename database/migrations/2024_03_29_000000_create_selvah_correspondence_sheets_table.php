<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('selvah_correspondence_sheets', function (Blueprint $table) {
            $table->id();
            $table->enum('poste_type', ['matin','apres-midi','nuit', 'journee']);
            // BMP1
            $table->tinyText('bmp1_numero_lot')->nullable();
            $table->boolean('bmp1_en_stock')->default(0);
            $table->boolean('bmp1_en_trituration')->default(0);
            $table->timestamp('bmp1_heure_debut')->nullable();
            $table->timestamp('bmp1_heure_fin')->nullable();
            // BMP2
            $table->tinyText('bmp2_numero_lot')->nullable();
            $table->boolean('bmp2_en_stock')->default(0);
            $table->boolean('bmp2_en_trituration')->default(0);
            $table->timestamp('bmp2_heure_debut')->nullable();
            $table->timestamp('bmp2_heure_fin')->nullable();
            // BTF1
            $table->tinyText('btf1_numero_lot')->nullable();
            $table->boolean('btf1_en_stock')->default(0);
            $table->boolean('btf1_en_extrusion')->default(0);
            $table->timestamp('btf1_heure_arret')->nullable();
            $table->timestamp('btf1_heure_redemarrage')->nullable();
            // Chaudières
            $table->boolean('chaudiere_trituration_durete_eau')->default(0);
            $table->boolean('chaudiere_trituration_niveau_glace')->default(0);
            $table->boolean('chaudiere_trituration_niveau_sel')->default(0);
            $table->boolean('chaudiere_extrusion_durete_eau')->default(0);
            $table->boolean('chaudiere_extrusion_niveau_glace')->default(0);
            $table->boolean('chaudiere_extrusion_niveau_sel')->default(0);
            $table->mediumText('chaudiere_commentaire')->nullable();
            // Compteurs
            $table->integer('compteur_huile_brute')->nullable();
            $table->decimal('compteur_eau_1',8, 1)->nullable();
            $table->decimal('compteur_eau_2')->nullable();
            $table->decimal('compteur_eau_3')->nullable();
            $table->decimal('compteur_eau_4')->nullable();
            $table->decimal('compteur_eau_5')->nullable();
            $table->decimal('compteur_consommation_eau_1',8, 1)->nullable();
            $table->decimal('compteur_consommation_eau_2')->nullable();
            $table->decimal('compteur_consommation_eau_3')->nullable();
            $table->decimal('compteur_consommation_eau_4')->nullable();
            $table->decimal('compteur_consommation_eau_5')->nullable();
            // Filtration
            $table->boolean('filtration_nettoyage_plateaux')->default(0);
            $table->enum('filtration_plateaux_conforme', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            $table->mediumText('filtration_commentaire')->nullable();
            // NS1
            $table->tinyText('ns1_numero_lot')->nullable();
            $table->timestamp('ns1_date_changement_lot')->nullable();
            $table->timestamp('ns1_heure_controle')->nullable();
            $table->enum('ns1_grille_conforme', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            // Aimants
            $table->enum('aimant_amont_broyeur_graine_1', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            $table->enum('aimant_broyeur_graine_2', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            $table->enum('aimant_broyeur_ttx_3', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            $table->enum('aimant_refroidisseur_4', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            $table->enum('aimant_tremie_boisseaux_5', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            $table->enum('aimant_tci1_6', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            // Magnétique ensacheuse
            $table->boolean('magnetique_ensachage_en_cours')->default(0);
            $table->enum('magnetique_ensachage_type', ['sacs', 'big-bag', 'non-applicable'])->default('non-applicable');
            $table->timestamp('magnetique_sacs_heure_controle')->nullable();
            $table->enum('magnetique_sacs_etalon_fe', ['detecte', 'non-detecte', 'non-applicable'])->default('non-applicable');
            $table->enum('magnetique_sacs_etalon_nfe', ['detecte', 'non-detecte', 'non-applicable'])->default('non-applicable');
            $table->enum('magnetique_sacs_etalon_ss', ['detecte', 'non-detecte', 'non-applicable'])->default('non-applicable');
            $table->timestamp('magnetique_big_bag_heure_controle')->nullable();
            $table->enum('magnetique_big_bag_etalon_fe', ['detecte', 'non-detecte', 'non-applicable'])->default('non-applicable');
            $table->enum('magnetique_big_bag_etalon_nfe', ['detecte', 'non-detecte', 'non-applicable'])->default('non-applicable');
            $table->enum('magnetique_big_bag_etalon_ss', ['detecte', 'non-detecte', 'non-applicable'])->default('non-applicable');
            $table->enum('magnetique_validation_ccp', ['oui', 'non', 'non-applicable'])->default('non-applicable');
            // BRC1
            $table->tinyText('brc_numero_lot')->nullable();
            $table->enum('brc_grille_conforme', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            $table->enum('brc_couteaux_conforme', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            // BRT1
            $table->tinyText('brt1_numero_lot')->nullable();
            $table->enum('brt1_grille_conforme', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            $table->enum('brt1_couteaux_conforme', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');

            // Echantillons Trituration
            $table->boolean('echantillon_graines_broyees')->default(0);
            $table->enum('echantillon_graines_broyees_controle_visuel', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            $table->boolean('echantillon_coques')->default(0);
            $table->enum('echantillon_coques_controle_visuel', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            $table->boolean('echantillon_huile_brute')->default(0);
            $table->enum('echantillon_huile_brute_controle_visuel', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            $table->boolean('echantillon_ttx')->default(0);
            $table->enum('echantillon_ttx_controle_visuel', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            $table->boolean('echantillon_farine_ttx')->default(0);
            $table->enum('echantillon_farine_ttx_controle_visuel', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            // Echantillons Extrusion
            $table->enum('echantillon_ensachage_circuit', ['bpf1', 'bpf2', 'big-bag', 'non-applicable'])->default('non-applicable');
            $table->boolean('echantillon_pvt_sachet_debut_production')->default(0);
            $table->enum('echantillon_pvt_sachet_debut_production_controle_visuel', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            $table->boolean('echantillon_pvt_sachet_prise_poste')->default(0);
            $table->enum('echantillon_pvt_sachet_prise_poste_controle_visuel', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            $table->boolean('echantillon_pvt_pot_sterile')->default(0);
            $table->enum('echantillon_pvt_pot_sterile_controle_visuel', ['conforme', 'non-conforme', 'non-applicable'])->default('non-applicable');
            // Zones Textes
            $table->mediumText('remarques_apres_visite_usine')->nullable();
            $table->longText('problemes_defauts_rencontrer_pendant_poste')->nullable();
            $table->mediumText('consignes_poste_a_poste')->nullable();
            // Responsable
            $table->mediumText('responsable_commentaire')->nullable();

            // Edited
            $table->integer('edit_count')->default(0);
            $table->boolean('is_edited')->default(false);

            $table->timestamps();
        });

        Schema::table('selvah_correspondence_sheets', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\User::class)->after('id');
            $table->foreignIdFor(\BDS\Models\User::class, 'responsable_signature_id')
                ->after('responsable_commentaire')
                ->index()
                ->nullable();
            $table->foreignIdFor(\BDS\Models\User::class, 'edited_user_id')
                ->after('is_edited')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selvah_correspondence_sheets');
    }
};
