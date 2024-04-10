<?php

namespace BDS\Models\Presenters\Selvah;

trait CorrespondenceSheetPresenter
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

        return route('correspondence-sheets.show', $this);
    }
}
