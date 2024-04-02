<?php

namespace BDS\Models\Selvah;

use BDS\Enums\Selvah\Conformes;
use BDS\Enums\Selvah\Postes;
use BDS\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CorrespondenceSheet extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'selvah_correspondence_sheets';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'poste_type' => Postes::class,
        'bmp1_en_stock' => 'boolean',
        'bmp1_en_trituration' => 'boolean',
        'bmp1_heure_debut' => 'datetime',
        'bmp1_heure_fin' => 'datetime',

        'bmp2_en_stock' => 'boolean',
        'bmp2_en_trituration' => 'boolean',
        'bmp2_heure_debut' => 'datetime',
        'bmp2_heure_fin' => 'datetime',

        'btf1_en_stock' => 'boolean',
        'btf1_en_extrusion' => 'boolean',
        'btf1_heure_arret' => 'datetime',
        'btf1_heure_redemarrage' => 'datetime',

        'chaudiere_trituration_durete_eau' => 'boolean',
        'chaudiere_trituration_niveau_glace' => 'boolean',
        'chaudiere_trituration_niveau_sel' => 'boolean',
        'chaudiere_extrusion_durete_eau' => 'boolean',
        'chaudiere_extrusion_niveau_glace' => 'boolean',
        'chaudiere_extrusion_niveau_sel' => 'boolean',

        'filtration_nettoyage_filtre' => 'boolean',
        'filtration_conformite_plateaux' => 'boolean',

        'ns1_date_changement_lot' => 'datetime',
        'ns1_heure_controle' => 'datetime',
        'ns1_grille_conforme' => 'boolean',

        'aimant_amont_broyeur_graine_1' => Conformes::class,
        'aimant_broyeur_graine_2' => Conformes::class,
        'aimant_broyeur_ttx_3' => Conformes::class,
        'aimant_refroidisseur_4' => Conformes::class,
        'aimant_tremie_boisseaux_5' => Conformes::class,
        'aimant_tci1_6' => Conformes::class,
    ];

    /**
     * Get the user that owns the sheet.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
