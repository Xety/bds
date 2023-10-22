<?php

namespace BDS\Models\Presenters;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait SettingPresenter
{
    public function value(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => unserialize($value),
            set: fn (mixed $value) => serialize($value),
        );
    }

    /*public function getValueAttribute($value)
    {
        return unserialize($value);
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = serialize($value);
    }*/

    /**
     * Attribute the value regardless to the type.
     *
     * @return int|bool|string
     */
    /*public function getValueAttribute()
    {
        if (!is_null($this->value_int)) {
            return intval($this->value_int);
        }

        if (!is_null($this->value_bool)) {
            return boolval($this->value_bool);
        }

        if (!is_null($this->value_str)) {
            return $this->value_str;
        }

        return null;
    }*/

    /**
     * Get the type of the value.
     *
     * @return int|bool|string
     */
    /*public function getTypeAttribute()
    {
        if (!is_null($this->value_int)) {
            return $this->type = "value_int";
        }

        if (!is_null($this->value_bool)) {
            return $this->type = "value_bool";
        }

        if (!is_null($this->value_str)) {
            return $this->type = "value_str";
        }

        return null;
    }*/
}
