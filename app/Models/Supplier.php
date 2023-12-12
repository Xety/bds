<?php

namespace BDS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Supplier extends Model
{
    use HasFactory;

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
     * @return BelongsToMany
     */
    public function parts(): BelongsToMany
    {
        return $this->belongsToMany(Part::class)->withTimestamps();
    }
}
