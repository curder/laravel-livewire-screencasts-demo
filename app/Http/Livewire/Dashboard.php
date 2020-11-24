<?php
namespace App\Http\Livewire;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'date';
    public string $sortDirection = 'desc';
    protected $queryString = [
        'search', 'sortField', 'sortDirection'
    ];

    /**
     * @param  string  $field
     */
    public function sortBy(string $field) : void
    {
        $this->sortDirection = $this->sortField === $field ? ($this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc') : 'asc';

        $this->sortField     = $field;
    }
    public function render()
    {
        $transactions = Transaction::search('title', $this->search)
                                   ->orderBy($this->sortField, $this->sortDirection)
                                   ->paginate(10);

        return view('livewire.dashboard', compact('transactions'));
    }
}
