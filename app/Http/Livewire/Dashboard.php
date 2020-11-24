<?php

namespace App\Http\Livewire;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $transactions = Transaction::search('title', $this->search)->paginate(10);

        return view('livewire.dashboard', compact('transactions'));
    }
}
