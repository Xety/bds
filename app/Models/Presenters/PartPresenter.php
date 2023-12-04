<?php

namespace BDS\Models\Presenters;

trait PartPresenter
{
    /**
     * Get the current stock of the part.
     *
     * @return int
     */
    public function getStockTotalAttribute(): int
    {
        return $this->part_entry_total - $this->part_exit_total;
    }

    /**
     * Get the part show url.
     *
     * @return string
     */
    public function getShowUrlAttribute(): string
    {
        if ($this->getKey() === null) {
            return '';
        }

        return route('parts.show', $this);
    }
}
