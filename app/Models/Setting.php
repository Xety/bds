<?php

namespace BDS\Models;

use BDS\Models\Presenters\SettingPresenter;

class Setting extends Model
{
    use SettingPresenter;

    protected $fillable = [
        'site_id',
        'key',
        'value'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    /*protected $casts = [
        'value' => 'array'
    ];*/

    /*protected $appends = [
        'value_unserialize',
    ];*/
}
