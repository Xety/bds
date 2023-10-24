<?php

namespace BDS\Livewire\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Attributes\Reactive;

trait WithBulkActions
{
    /**
     * Whatever the current page of rows are all selected or not.
     *
     * @var bool
     */
    public bool $selectPage = false;

    /**
     * Whatever the user has selected all rows or not.
     *
     * @var bool
     */
    public bool $selectAll = false;

    /**
     * The id array of selected rows.
     *
     * @var array|Collection
     */
    public array|Collection $selected = [];

    /**
     * If the selectAll is true, we need to select (and check the checkbox) of all rows
     * rendering in the current page.
     *
     * @return void
     */
    public function renderingWithBulkActions(): void
    {
        if ($this->selectAll) {
            $this->selectPageRows();
        }
    }

    /**
     * Whenever the user unselect a checkbox, we need to disable the selectAll option and selectPage.
     *
     * @return void
     */
    public function updatedSelected(): void
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    /**
     * Whatever we have selected all rows in the current page.
     *
     * @param mixed $value The current page where all rows get selected.
     *
     * @return void|null
     */
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selectPageRows();

            return;
        }

        $this->selectAll = false;
        $this->selected = [];
    }

    /**
     * Convert the selected rows id into string type.
     *
     * @return void
     */
    public function selectPageRows(): void
    {
        $this->selected = $this->rows->pluck('id')->map(fn($id) => (string) $id);
    }

    /**
     * Set selectAll to true.
     *
     * @return void
     */
    public function setSelectAll(): void
    {
        $this->selectAll = true;
    }

    /**
     * Get all select rows by their id, preparing for deleting them.
     *
     * @eturn Builder
     */
    public function getSelectedRowsQueryProperty() : Builder
    {
        return app($this->model)->unless($this->selectAll, fn($query) => $query->whereKey($this->selected));
    }

    /**
     * Delete all selected rows and display a flash message.
     *
     * @return void
     */
    public function deleteSelected(): void
    {
        $models = collect($this->selectedRowsQuery->get()->pluck('id')->toArray());

        $deleteCount = $models->count();

        if ($deleteCount <= 0) {
            return;
        }

        // For each id, we fetch the model and check the permission related to the model.
        // If one fail, then they all won't be deleted.
        $models->each(function ($id) {
            $model = app($this->model)->where('id', $id)->first();

            $this->authorize('delete', $model);
        });

        if (app($this->model)->destroy($models->toArray())) {
            $this->success($this->flashMessages['delete']['success'], ['count' => $deleteCount]);
            $this->reset('selected');

            redirect(request()->header('Referer')); // Fix when deleting users to refresh the page so we can restore the users
        } else {
            $this->error($this->flashMessages['delete']['error']);
        }
        $this->showDeleteModal = false;
    }
}
