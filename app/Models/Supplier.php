<?php

namespace BDS\Models;

use BDS\Models\Presenters\SupplierPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;
    use SupplierPresenter;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'show_url'
    ];

    /**
     * Get all the parts for the supplier.
     *
     * @return hasMany
     */
    public function parts(): HasMany
    {
        return $this->hasMany(Part::class);
    }
}
