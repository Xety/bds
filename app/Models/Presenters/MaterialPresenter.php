<?php

namespace BDS\Models\Presenters;

trait MaterialPresenter
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

        return route('materials.show', $this);
    }
}
