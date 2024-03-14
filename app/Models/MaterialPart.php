<?php

namespace BDS\Models;

use Eloquence\Behaviours\CountCache\Countable;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MaterialPart extends Pivot
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
                'model'      => Material::class,
                'field'      => 'part_count',
                'foreignKey' => 'material_id',
                'key'        => 'id'
            ],
            [
                'model'      => Part::class,
                'field'      => 'material_count',
                'foreignKey' => 'part_id',
                'key'        => 'id'
            ]
        ];
    }
}
