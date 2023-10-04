<?php

namespace BDS\Livewire\Traits;

use Illuminate\Contracts\Database\Query\Builder;

trait WithSorting
{
    /**
     * Determine the direction regarding of the field.
     *
     * @param string $field The field to sort to.
     *
     * @return void
     */
    public function sortBy(string $field): void
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        if (
            empty($this->allowedFields) ||
            in_array($field, $this->allowedFields) ||
            $this->sortField === $field
        ) {
            $this->sortField = $field;
        }
    }

    /**
     * Apply the orderBy condition with the field and the direction to the query.
     *
     * @param Builder $query The query to apply the orderBy close.
     *
     * @return Builder
     */
    public function applySorting(Builder $query): Builder
    {
        return $query->orderBy($this->sortField, $this->sortDirection);
    }

    /**
     * Filter the field regarding the allowed fields.
     *
     * @param string $field The new field to check.
     *
     * @return void
     */
    public function updatedSortField(string $field): void
    {
        if (!empty($this->allowedFields) && !in_array($field, $this->allowedFields)) {
            $this->sortField = 'created_at';
        }
    }

    /**
     * Filter the field on component mount regarding the allowed fields.
     *
     * @return void
     */
    public function applySortingOnMount()
    {
        // Check if the field is allowed before setting it.
        if (!in_array($this->sortField, $this->allowedFields)) {
            $this->sortField = 'created_at';
        }
    }
}
