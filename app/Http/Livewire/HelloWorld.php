<?php
namespace App\Http\Livewire;

use Livewire\Component;

class HelloWorld extends Component
{
    public $name = 'Jenny';
    public $loud = false;
    public $greeting = ['Hello'];
    public function render()
    {
        return view('livewire.hello-world');
    }
}
