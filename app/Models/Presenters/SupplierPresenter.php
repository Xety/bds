<?php

namespace BDS\Models\Presenters;

trait SupplierPresenter
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

        return route('suppliers.show', $this);
    }
}
