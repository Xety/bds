<?php

namespace BDS\Livewire\Selvah;

use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithFilters;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithToast;
use BDS\Models\Company;
use BDS\Models\Selvah\CorrespondenceSheet;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class CorrespondenceSheets extends Component
{
    use AuthorizesRequests;
    use WithCachedRows;
    use WithFilters;
    use WithPagination;
    use WithPerPagePagination;
    use WithSorting;
    use WithToast;

    /**
     * The field to sort by.
     *
     * @var string
     */
    public string $sortField = 'created_at';

    /**
     * The direction of the ordering.
     *
     * @var string
     */
    public string $sortDirection = 'desc';

    /**
     * Used to update in URL the query string.
     *
     * @var string[]
     */
    protected array $queryString = [
        'sortField' => ['as' => 'f'],
        'sortDirection' => ['as' => 'd'],
        'filters',
    ];

    /**
     * Filters used for advanced search.
     *
     * @var array
     */
    public array $filters = [
        'user_id' => '',
        'poste_type' => '',
        'bmp1_numero_lot' => '',
        'bmp2_numero_lot' => '',
        'btf1_numero_lot' => '',
        'compteur_huile_brute_min' => '',
        'compteur_huile_brute_max' => '',
        'filtration_nettoyage_plateaux' => '',
        'filtration_plateaux_conforme' => '',
        'filtration_commentaire' => '',
        'ns1_numero_lot' => '',
        'ns1_grille_conforme' => '',
        'aimant_amont_broyeur_graine_1' => '',
        'aimant_broyeur_graine_2' => '',
        'aimant_broyeur_ttx_3' => '',
        'aimant_refroidisseur_4' => '',
        'aimant_tremie_boisseaux_5' => '',
        'aimant_tci1_6' => '',
        'magnetique_ensachage_en_cours' => '',
        'magnetique_ensachage_type' => '',
        'magnetique_sacs_etalon_fe' => '',
        'magnetique_sacs_etalon_nfe' => '',
        'magnetique_sacs_etalon_ss' => '',
        'magnetique_big_bag_etalon_fe' => '',
        'magnetique_big_bag_etalon_nfe' => '',
        'magnetique_big_bag_etalon_ss' => '',
        'magnetique_validation_ccp' => '',
        'brc_numero_lot' => '',
        'brc_grille_conforme' => '',
        'brc_couteaux_conforme' => '',
        'brt1_numero_lot' => '',
        'brt1_grille_conforme' => '',
        'brt1_couteaux_conforme' => '',
        'echantillon_graines_broyees' => '',
        'echantillon_graines_broyees_controle_visuel' => '',
        'echantillon_coques' => '',
        'echantillon_coques_controle_visuel' => '',
        'echantillon_huile_brute' => '',
        'echantillon_huile_brute_controle_visuel' => '',
        'echantillon_ttx' => '',
        'echantillon_ttx_controle_visuel' => '',
        'echantillon_farine_ttx' => '',
        'echantillon_farine_ttx_controle_visuel' => '',
        'echantillon_ensachage_circuit' => '',
        'echantillon_pvt_sachet_debut_production' => '',
        'echantillon_pvt_sachet_debut_production_controle_visuel' => '',
        'echantillon_pvt_sachet_prise_poste' => '',
        'echantillon_pvt_sachet_prise_poste_controle_visuel' => '',
        'echantillon_pvt_pot_sterile' => '',
        'echantillon_pvt_pot_sterile_controle_visuel' => '',
        'remarques_apres_visite_usine' => '',
        'problemes_defauts_rencontrer_pendant_poste' => '',
        'consignes_poste_a_poste' => '',
        'responsable_commentaire' => '',
        'responsable_signature_id' => '',
        'created_min' => '',
        'created_max' => '',
    ];

    /**
     * Array of allowed fields.
     *
     * @var array
     */
    public array $allowedFields = [
        'site_id',
        'description',
        'event',
        'subject_type',
        'causer_id',
        'created_at'
    ];

    /**
     * Number of rows displayed on a page.
     *
     * @var int
     */
    public int $perPage = 12;

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.selvah.correspondence-sheets', [
            'sheets' => $this->rows
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = CorrespondenceSheet::query();

        if (Gate::allows('search', CorrespondenceSheet::class)) {
            $query
                ->when($this->filters['user_id'], function ($query, $search) {
                    return $query->whereHas('user', function ($partQuery) use ($search) {
                        $partQuery->where('first_name', 'LIKE', '%' . $search . '%')
                            ->orWhere('last_name', 'LIKE', '%' . $search . '%');
                    });
                })
                ->when($this->filters['poste_type'], fn($query, $search) => $query->where('poste_type', $search))
                // BMP1
                ->when($this->filters['bmp1_numero_lot'], fn($query, $search) => $query->where('bmp1_numero_lot', 'LIKE', '%' . $search . '%'))
                // BMP2
                ->when($this->filters['bmp2_numero_lot'], fn($query, $search) => $query->where('bmp2_numero_lot', 'LIKE', '%' . $search . '%'))
                // BTF1
                ->when($this->filters['btf1_numero_lot'], fn($query, $search) => $query->where('btf1_numero_lot', 'LIKE', '%' . $search . '%'))
                // Compteurs
                ->when($this->filters['compteur_huile_brute_min'], fn($query, $search) => $query->where('compteur_huile_brute', '>=', $search))
                ->when($this->filters['compteur_huile_brute_max'], fn($query, $search) => $query->where('compteur_huile_brute', '<=', $search))
                 // Filtration
                ->when($this->filters['filtration_nettoyage_plateaux'], function ($query, $search) {
                    if ($search === 'yes') {
                        return $query->where('filtration_nettoyage_plateaux', true);
                    }
                    return $query->where('filtration_nettoyage_plateaux', false);
                })
                ->when($this->filters['filtration_plateaux_conforme'], fn($query, $search) => $query->where('filtration_plateaux_conforme', $search))
                ->when($this->filters['filtration_commentaire'], fn($query, $search) => $query->where('filtration_commentaire', 'LIKE', '%' . $search . '%'))
                // NS1
                ->when($this->filters['ns1_numero_lot'], fn($query, $search) => $query->where('ns1_numero_lot', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['ns1_grille_conforme'], fn($query, $search) => $query->where('ns1_grille_conforme', $search))
                // Aimants
                ->when($this->filters['aimant_amont_broyeur_graine_1'], fn($query, $search) => $query->where('aimant_amont_broyeur_graine_1', $search))
                ->when($this->filters['aimant_broyeur_graine_2'], fn($query, $search) => $query->where('aimant_broyeur_graine_2', $search))
                ->when($this->filters['aimant_broyeur_ttx_3'], fn($query, $search) => $query->where('aimant_broyeur_ttx_3', $search))
                ->when($this->filters['aimant_refroidisseur_4'], fn($query, $search) => $query->where('aimant_refroidisseur_4', $search))
                ->when($this->filters['aimant_tremie_boisseaux_5'], fn($query, $search) => $query->where('aimant_tremie_boisseaux_5', $search))
                ->when($this->filters['aimant_tci1_6'], fn($query, $search) => $query->where('aimant_tci1_6', $search))
                // Magnétique ensacheuse
                ->when($this->filters['magnetique_ensachage_en_cours'], function ($query, $search) {
                    if ($search === 'yes') {
                        return $query->where('magnetique_ensachage_en_cours', true);
                    }
                    return $query->where('magnetique_ensachage_en_cours', false);
                })
                ->when($this->filters['magnetique_ensachage_type'], fn($query, $search) => $query->where('magnetique_ensachage_type', $search))
                ->when($this->filters['magnetique_sacs_etalon_fe'], fn($query, $search) => $query->where('magnetique_sacs_etalon_fe', $search))
                ->when($this->filters['magnetique_sacs_etalon_nfe'], fn($query, $search) => $query->where('magnetique_sacs_etalon_nfe', $search))
                ->when($this->filters['magnetique_sacs_etalon_ss'], fn($query, $search) => $query->where('magnetique_sacs_etalon_ss', $search))
                ->when($this->filters['magnetique_big_bag_etalon_fe'], fn($query, $search) => $query->where('magnetique_big_bag_etalon_fe', $search))
                ->when($this->filters['magnetique_big_bag_etalon_nfe'], fn($query, $search) => $query->where('magnetique_big_bag_etalon_nfe', $search))
                ->when($this->filters['magnetique_big_bag_etalon_ss'], fn($query, $search) => $query->where('magnetique_big_bag_etalon_ss', $search))
                ->when($this->filters['magnetique_validation_ccp'], fn($query, $search) => $query->where('magnetique_validation_ccp', $search))
                // BRC1
                ->when($this->filters['brc_numero_lot'], fn($query, $search) => $query->where('brc_numero_lot', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['brc_grille_conforme'], fn($query, $search) => $query->where('brc_grille_conforme', $search))
                ->when($this->filters['brc_couteaux_conforme'], fn($query, $search) => $query->where('brc_couteaux_conforme', $search))
                // BRT1
                ->when($this->filters['brt1_numero_lot'], fn($query, $search) => $query->where('brt1_numero_lot', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['brt1_grille_conforme'], fn($query, $search) => $query->where('brt1_grille_conforme', $search))
                ->when($this->filters['brt1_couteaux_conforme'], fn($query, $search) => $query->where('brt1_couteaux_conforme', $search))
                // Echantillons Trituration
                ->when($this->filters['echantillon_graines_broyees'], function ($query, $search) {
                    if ($search === 'yes') {
                        return $query->where('echantillon_graines_broyees', true);
                    }
                    return $query->where('echantillon_graines_broyees', false);
                })
                ->when($this->filters['echantillon_graines_broyees_controle_visuel'], fn($query, $search) => $query->where('echantillon_graines_broyees_controle_visuel', $search))
                ->when($this->filters['echantillon_coques'], function ($query, $search) {
                    if ($search === 'yes') {
                        return $query->where('echantillon_coques', true);
                    }
                    return $query->where('echantillon_coques', false);
                })
                ->when($this->filters['echantillon_coques_controle_visuel'], fn($query, $search) => $query->where('echantillon_coques_controle_visuel', $search))
                ->when($this->filters['echantillon_huile_brute'], function ($query, $search) {
                    if ($search === 'yes') {
                        return $query->where('echantillon_huile_brute', true);
                    }
                    return $query->where('echantillon_huile_brute', false);
                })
                ->when($this->filters['echantillon_huile_brute_controle_visuel'], fn($query, $search) => $query->where('echantillon_huile_brute_controle_visuel', $search))
                ->when($this->filters['echantillon_ttx'], function ($query, $search) {
                    if ($search === 'yes') {
                        return $query->where('echantillon_ttx', true);
                    }
                    return $query->where('echantillon_ttx', false);
                })
                ->when($this->filters['echantillon_ttx_controle_visuel'], fn($query, $search) => $query->where('echantillon_ttx_controle_visuel', $search))
                ->when($this->filters['echantillon_farine_ttx'], function ($query, $search) {
                    if ($search === 'yes') {
                        return $query->where('echantillon_farine_ttx', true);
                    }
                    return $query->where('echantillon_farine_ttx', false);
                })
                ->when($this->filters['echantillon_farine_ttx_controle_visuel'], fn($query, $search) => $query->where('echantillon_farine_ttx_controle_visuel', $search))
                // Echantillons Extrusion
                ->when($this->filters['echantillon_ensachage_circuit'], fn($query, $search) => $query->where('echantillon_ensachage_circuit', $search))
                ->when($this->filters['echantillon_pvt_sachet_debut_production'], function ($query, $search) {
                    if ($search === 'yes') {
                        return $query->where('echantillon_pvt_sachet_debut_production', true);
                    }
                    return $query->where('echantillon_pvt_sachet_debut_production', false);
                })
                ->when($this->filters['echantillon_pvt_sachet_debut_production_controle_visuel'], fn($query, $search) => $query->where('echantillon_pvt_sachet_debut_production_controle_visuel', $search))
                ->when($this->filters['echantillon_pvt_sachet_prise_poste'], function ($query, $search) {
                    if ($search === 'yes') {
                        return $query->where('echantillon_pvt_sachet_prise_poste', true);
                    }
                    return $query->where('echantillon_pvt_sachet_prise_poste', false);
                })
                ->when($this->filters['echantillon_pvt_sachet_prise_poste_controle_visuel'], fn($query, $search) => $query->where('echantillon_pvt_sachet_prise_poste_controle_visuel', $search))
                ->when($this->filters['echantillon_pvt_pot_sterile'], function ($query, $search) {
                    if ($search === 'yes') {
                        return $query->where('echantillon_pvt_pot_sterile', true);
                    }
                    return $query->where('echantillon_pvt_pot_sterile', false);
                })
                ->when($this->filters['echantillon_pvt_pot_sterile_controle_visuel'], fn($query, $search) => $query->where('echantillon_pvt_pot_sterile_controle_visuel', $search))
                // Zones Textes
                ->when($this->filters['remarques_apres_visite_usine'], fn($query, $search) => $query->where('remarques_apres_visite_usine', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['problemes_defauts_rencontrer_pendant_poste'], fn($query, $search) => $query->where('problemes_defauts_rencontrer_pendant_poste', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['consignes_poste_a_poste'], fn($query, $search) => $query->where('consignes_poste_a_poste', 'LIKE', '%' . $search . '%'))
                // Responsable
                ->when($this->filters['responsable_signature_id'], function ($query, $search) {
                    return $query->whereHas('responsable', function ($partQuery) use ($search) {
                        $partQuery->where('first_name', 'LIKE', '%' . $search . '%')
                            ->orWhere('last_name', 'LIKE', '%' . $search . '%');
                    });
                })
                ->when($this->filters['responsable_commentaire'], fn($query, $search) => $query->where('responsable_commentaire', 'LIKE', '%' . $search . '%'))
                // Dates
                ->when($this->filters['created_min'], fn($query, $date) => $query->where('created_at', '>=', Carbon::parse($date)))
                ->when($this->filters['created_max'], fn($query, $date) => $query->where('created_at', '<=', Carbon::parse($date)));
        }

        return $this->applySorting($query);
    }

    /**
     * Build the query or get it from the cache and paginate it.
     *
     * @return LengthAwarePaginator
     */
    public function getRowsProperty(): LengthAwarePaginator
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    /**
     * @return void
     */
    public function create()
    {
        $this->authorize('create', CorrespondenceSheet::class);

        // Check the user has not created a sheet in the last 8 hours.
        $sheet = CorrespondenceSheet::query()
            ->where('user_id', Auth::id())
            ->whereDate('created_at', '>=', Carbon::now()->addHours(8))
            ->first();

        if (!is_null($sheet)) {
            $this->error('Vous avez créé une fiche de correspondance (N°:id) il y a moins de 8 heures, vous ne pouvez pas en créer une nouvelle.', ['id' => $sheet->getKey()]);

            return;
        }

        $this->redirect(route('correspondence-sheets.create'));
    }
}
