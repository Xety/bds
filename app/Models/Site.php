<?php


namespace BDS\Models;

use BDS\Models\Presenters\SitePresenter;
use BDS\Observers\SiteObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([SiteObserver::class])]
class Site extends Model
{
    use SitePresenter;

    protected $fillable = [
        'name',
        'email',
        'office_phone',
        'cell_phone',
        'address',
        'zip_code',
        'city'
    ];

    /**
     * Get the zones without parent.
     *
     * @return HasMany
     */
    public function zones(): HasMany
    {
        return $this->hasMany(Zone::class)->whereNull('parent_id');
    }

    /**
     * Get the zones created by the user.
     *
     * @return BelongsToMany
     */
    public function managers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('manager')
            ->where('manager',true)
            ->withTrashed();
    }

    /**
     * Get the users assigned to this site.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->withTrashed();
    }
}
