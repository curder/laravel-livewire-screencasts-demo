<?php
namespace App\Http\Livewire\DataTable;

trait WithSorting
{
    public string $sortField = 'date';
    public string $sortDirection = 'desc';

    /**
     * @param  string  $field
     */
    public function sortBy(string $field) : void
    {
        $this->sortDirection = $this->sortField === $field ? ($this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc') : 'asc';
        $this->sortField     = $field;
    }
    public function applySorting($query)
    {
        return $query->orderBy($this->sortField, $this->sortDirection);
    }
}
