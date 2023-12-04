<?php

namespace BDS\Models\Presenters;

trait MaintenancePresenter
{
    /**
     * Get the maintenance show url.
     *
     * @return string
     */
    public function getShowUrlAttribute(): string
    {
        if ($this->getKey() === null) {
            return '';
        }

        return route('maintenances.show', $this);
    }
}
