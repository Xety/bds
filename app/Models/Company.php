<?php

namespace BDS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use BDS\Models\Presenters\CompanyPresenter;

class Company extends Model
{
    use CompanyPresenter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'site_id',
        'name',
        'description'
    ];

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
        return $this->belongsToMany(Material::class)
            ->using(CompanyMaintenance::class)
            ->withTimestamps();
    }

    /**
     * Get the site that owns the supplier.
     *
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the user that created the supplier.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
