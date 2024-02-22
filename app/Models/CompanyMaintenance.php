<?php

namespace BDS\Models;

use Eloquence\Behaviours\CountCache\Countable;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CompanyMaintenance extends Pivot
{
    use Countable;

    /**
     * Return the count cache configuration.
     *
     * @return array
     */
    public function countCaches(): array
    {
        return [
            [
                'model'      => Company::class,
                'field'      => 'maintenance_count',
                'foreignKey' => 'company_id',
                'key'        => 'id'
            ],
            [
                'model'      => Maintenance::class,
                'field'      => 'company_count',
                'foreignKey' => 'maintenance_id',
                'key'        => 'id'
            ]
        ];
    }

}
