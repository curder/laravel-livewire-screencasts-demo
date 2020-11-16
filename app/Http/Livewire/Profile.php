<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Profile extends Component
{
    public $name;
    public $about;

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->about = auth()->user()->about;
    }

    public function save()
    {
        $this->validate([
            'name' => 'max:24',
            'about' => 'max:120',
        ]);

        auth()->user()->update([
            'name' => $this->name,
            'about' => $this->about,
        ]);

        $this->dispatchBrowserEvent('notify', 'Profile Saved!');
    }

    public function render()
    {
        return view('livewire.profile')
            ->extends('layouts.app');
    }
}
