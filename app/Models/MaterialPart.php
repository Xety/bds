<?php

namespace BDS\Models;

use Eloquence\Behaviours\CountCache\CountedBy;
use Eloquence\Behaviours\CountCache\HasCounts;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MaterialPart extends Pivot
{
    use HasCounts;

    #[CountedBy(as: 'part_count')]
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    #[CountedBy(as: 'material_count')]
    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }
}
