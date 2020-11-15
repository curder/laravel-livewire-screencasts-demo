<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;

class SayHi extends Component
{
    public $contact;

    public $listeners = [
        'refreshChildren' => '$refresh'
    ];

    public function emitRefreshSelfAndParent()
    {
        $this->emitUp('refreshSelfAndParent');
    }

    public function mount(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function render()
    {
        return view('livewire.say-hi');
    }
}
