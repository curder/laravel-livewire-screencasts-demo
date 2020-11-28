<?php
namespace App\Http\Livewire\DataTable;

use Livewire\WithPagination;

trait WithPerPagePagination
{
    use WithPagination;

    public string $perPage = '25';

    public function initializeWithPerPagePagination() : void
    {
        $this->perPage = session()->get('perPage', $this->perPage);
    }
    public function updatedPerPage($value) : void
    {
        session()->put('perPage', $value);
    }
    public function applyPagination($query)
    {
        return $query->paginate($this->perPage);
    }
}
