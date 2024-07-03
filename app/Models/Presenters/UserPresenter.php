<?php

namespace BDS\Models\Presenters;

use Illuminate\Database\Eloquent\Casts\Attribute;
use BDS\Models\Session;
use Laravolt\Avatar\Facade as Avatar;

trait UserPresenter
{
    /**
     * Get the user's avatar.
     *
     * @return Attribute
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: function() {
                return Avatar::create($this->full_name)->toBase64();
            }
        );
    }

    /**
     * Get the status of the user : online or offline
     *
     * @return Attribute
     */
    protected function online(): Attribute
    {
        $online = Session::expires()->where('user_id', $this->id)->first();

        return Attribute::make(
            get: fn () => !is_null($online)
        );
    }

    /**
     * Get the max role level of the user.
     *
     * @return Attribute
     */
    protected function level(): Attribute
    {
        return Attribute::make(
            get: fn () => ($role = $this->roles->sortByDesc('level')->first()) ? $role->level : 0
        );
    }

    /**
     * Get the account full name. Return the username if the user
     * has not set his first name and last name.
     *
     * @return Attribute
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: function () {
                $fullName = $this->first_name . ' ' . $this->last_name;

                if (empty(trim($fullName))) {
                    return $this->username;
                }

                return $fullName;
            }
        );
    }

    /**
     * Get the user show url.
     *
     * @return string
     */
    public function getShowUrlAttribute(): string
    {
        if ($this->getKey() === null) {
            return '';
        }

        return route('users.show', $this);
    }
}
