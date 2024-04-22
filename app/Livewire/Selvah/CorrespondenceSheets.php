<?php

namespace BDS\Livewire\Selvah;

use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithFilters;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithToast;
use BDS\Models\Selvah\CorrespondenceSheet;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
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
        'compteur_huile_brute' => '',
        'compteur_eau_1' => '',
        'compteur_eau_2' => '',
        'compteur_eau_3' => '',
        'compteur_eau_4' => '',
        'compteur_eau_5' => '',
        'compteur_consommation_eau_1' => '',
        'compteur_consommation_eau_2' => '',
        'compteur_consommation_eau_3' => '',
        'compteur_consommation_eau_4' => '',
        'compteur_consommation_eau_5' => '',
        'filtration_nettoyage_filtre' => '',
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
                ->when($this->filters['description'], fn($query, $search) => $query->where('description', 'LIKE', '%' . $search . '%'))

                ->when($this->filters['responsable_signature_id'], function ($query, $search) {
                    return $query->whereHas('responsable', function ($partQuery) use ($search) {
                        $partQuery->where('first_name', 'LIKE', '%' . $search . '%')
                            ->orWhere('last_name', 'LIKE', '%' . $search . '%');
                    });
                })
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
}
