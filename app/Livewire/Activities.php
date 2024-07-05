<?php

namespace BDS\Livewire;

use BDS\Livewire\Forms\CompanyForm;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithFilters;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithToast;
use BDS\Models\Activity;
use BDS\Models\Company;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Activities extends Component
{
    use AuthorizesRequests;
    use WithBulkActions;
    use WithCachedRows;
    use WithFilters;
    use WithPagination;
    use WithPerPagePagination;
    use WithSorting;
    use WithToast;

    /**
     * Bind the main model used in the component to be used in traits.
     *
     * @var string
     */
    public string $model = Activity::class;

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
        'site' => '',
        'description' => '',
        'event' => '',
        'subject' => '',
        'causer' => '',
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
     * Flash messages for the model.
     *
     * @var array
     */
    protected array $flashMessages = [
        'delete' => [
            'success' => "<b>:count</b> activités(s) ont été supprimée(s) avec succès !",
            'danger' => "Une erreur s'est produite lors de la suppression des activités !"
        ]
    ];

    /**
     * Used to show the delete modal.
     *
     * @var bool
     */
    public bool $showDeleteModal = false;

    /**
     * Number of rows displayed on a page.
     *
     * @var int
     */
    public int $perPage = 25;

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.activities', [
            'activities' => $this->rows
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = Activity::query()
            ->with('site');

        if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
            $query->where('site_id', getPermissionsTeamId());
        }

        if (Gate::allows('search', Activity::class)) {
            // This filter is only present on Verdun Siege site.
            if(getPermissionsTeamId() === settings('site_id_verdun_siege')){
                $query->when($this->filters['site'], function ($query, $search) {
                    return $query->whereHas('site', function ($partQuery) use ($search) {
                        $partQuery->where('name', 'LIKE', '%' . $search . '%');
                    });
                });
            }

            $query
                ->when($this->filters['description'], fn($query, $search) => $query->where('description', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['event'], fn($query, $search) => $query->where('event', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['causer'], function ($query, $search) {
                    return $query->whereHas('causer', function ($partQuery) use ($search) {
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
