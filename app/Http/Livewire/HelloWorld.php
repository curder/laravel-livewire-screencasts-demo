<?php
namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;

class HelloWorld extends Component
{
    public $contacts;

    public $listeners = [
        'refreshSelfAndParent' => '$refresh',
    ];

    public function refreshChildren() : void
    {
        $this->emit('refreshChildren');
    }

    public function mount()
    {
        $this->contacts = Contact::all();
    }

    public function render()
    {
        return view('livewire.hello-world');
    }
}
