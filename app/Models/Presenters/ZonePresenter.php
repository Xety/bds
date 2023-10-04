<?php

namespace BDS\Models\Presenters;

trait ZonePresenter
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

        return route('zones.show', $this);
    }
}
