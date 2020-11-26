<?php
namespace App\Http\Livewire\DataTable;

trait WithBulkActions
{
    public bool $selectPage = false;
    public array $selected = [];
    public bool $selectAll = false;

    public function initializeWithBulkActions()
    {
        //
    }

    public function renderingWithBulkActions()
    {
        if ($this->selectAll) $this->selectPageRows();
    }

    public function updatedSelectPage($value) : void
    {
        if ($value) {
            $this->selectPageRows();
        }
    }
    public function selectPageRows()
    {
        $this->selected = $this->rows->pluck('id')->map(fn($id) => (string) $id)->toArray();
    }
    public function updatedSelected() : void
    {
        $this->selectAll  = false;
        $this->selectPage = false;
    }
    public function selectAll() : void
    {
        $this->selectAll = true;
    }
    public function getSelectedRowsQuery()
    {
        return (clone $this->rowsQuery)->unless($this->selectAll, fn($query) => $query->whereKey($this->selected));
    }
}
