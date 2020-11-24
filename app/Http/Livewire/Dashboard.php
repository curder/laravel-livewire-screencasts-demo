<?php

namespace App\Http\Livewire;

use App\Models\Transaction;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $transactions = Transaction::paginate();

        return view('livewire.dashboard', compact('transactions'));
    }
}
