<?php

namespace App\Http\Livewire;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public function render()
    {
        $transactions = Transaction::paginate(10);

        return view('livewire.dashboard', compact('transactions'));
    }
}
