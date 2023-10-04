<?php

namespace BDS\Models;

use BDS\Models\Presenters\SettingPresenter;

class Setting extends Model
{
    use SettingPresenter;

    /**
     * All type with their labels. (Used for radio buttons)
     */
    public const TYPES = [
        'value_int' => 'Valeur Integer',
        'value_str' => 'Valeur String',
        'value_bool' => 'Valeur Boolean'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'value_int',
        'value_str',
        'value_bool',
        'value',
        'description',
        'last_updated_user_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'value',
        'type'
    ];

    /**
     * Function to set the value regarding the type to the model and return it.
     *
     * @param string $value The value to assign.
     * @param string $type The type of the value.
     * @param Setting $model The model where the value will be assigned.
     *
     * @return mixed
     */
    protected static function castValue(string $value, string $type, Setting $model)
    {
        switch ($type) {
            case "value_int":
                $model->value_int = intval($value);
                $model->value_bool = null;
                $model->value_str = null;
                break;

            case "value_bool":
                $model->value_bool = boolval($value);
                $model->value_int = null;
                $model->value_str = null;
                break;

            case "value_str":
                $model->value_str = $value;
                $model->value_int = null;
                $model->value_bool = null;
                break;
        }
        return $model;
    }
}
