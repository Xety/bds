<?php

namespace BDS\Models\Presenters;

trait SitePresenter
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

        return route('sites.show', $this);
    }
}
