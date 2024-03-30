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
            $table->float('compteur_eau_1',8, 1)->nullable();
            $table->float('compteur_eau_2')->nullable();
            $table->float('compteur_eau_3')->nullable();
            $table->float('compteur_eau_4')->nullable();
            $table->float('compteur_eau_5')->nullable();
            $table->float('compteur_consommation_eau_1',8, 1)->nullable();
            $table->float('compteur_consommation_eau_2')->nullable();
            $table->float('compteur_consommation_eau_3')->nullable();
            $table->float('compteur_consommation_eau_4')->nullable();
            $table->float('compteur_consommation_eau_5')->nullable();
            //



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
