<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Profile extends Component
{
    public $name;
    public $about;
    public $birthday = null;

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->about = auth()->user()->about;
        $this->birthday = optional(auth()->user()->birthday)->format('m/d/Y');
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
            'birthday' => $this->birthday,
        ]);

//         $this->dispatchBrowserEvent('notify', 'Profile Saved!');

        $this->emitSelf('notify-saved');
        // session()->flash('notify-saved');
    }

    public function render()
    {
        return view('livewire.profile')
            ->extends('layouts.app');
    }
}
