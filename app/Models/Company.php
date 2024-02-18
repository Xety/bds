<?php

namespace BDS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use BDS\Models\Presenters\CompanyPresenter;

class Company extends Model
{
    use CompanyPresenter;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'show_url'
    ];

    /**
     * Get all the maintenances for the company.
     *
     * @return BelongsToMany
     */
    public function maintenances(): BelongsToMany
    {
        return $this->belongsToMany(Maintenance::class)->withTimestamps();
    }
}
