<?php

namespace BDS\Models;

use Eloquence\Behaviours\CountCache\CountedBy;
use Eloquence\Behaviours\CountCache\HasCounts;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CompanyMaintenance extends Pivot
{
    use HasCounts;

    #[CountedBy(as: 'maintenance_count')]
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    #[CountedBy(as: 'company_count')]
    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
    }

}
