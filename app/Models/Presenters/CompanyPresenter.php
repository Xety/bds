<?php

namespace BDS\Models\Presenters;

trait CompanyPresenter
{
    /**
     * Get the material show url.
     *
     * @return string
     */
    public function getShowUrlAttribute(): string
    {
        if ($this->getKey() === null) {
            return '';
        }

        return route('companies.show', $this);
    }
}
