<?php

namespace BDS\Livewire\Traits;

trait WithFilters
{
    /**
     * Reset all filters to their default values.
     *
     * @return void
     */
    public function resetFilters(): void
    {
        $this->reset('filters');
    }

    /**
     * When a filter is updated, reset the page.
     *
     * @return void
     */
    public function updatedFilters(): void
    {
        $this->resetPage();
    }

    /**
     * Function to get filters from URL and remove all NULL value then
     * merge it into the filters array.
     *
     * @return void
     */
    public function applyFilteringOnMount(): void
    {
        // Get the filters from URL and remove all NULL value.
        $filters = array_filter($this->filters, fn ($value) => !is_null($value));
        // Set all filters to their default value.
        $this->reset('filters');
        // Merge the filters from URL after being filtered into the filters array.
        $this->filters = array_merge($this->filters, $filters);
    }
}
