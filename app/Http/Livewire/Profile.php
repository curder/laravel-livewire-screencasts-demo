<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $name;
    public $about;
    public $birthday = null;
    public $newAvatar;

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->about = auth()->user()->about;
        $this->birthday = optional(auth()->user()->birthday)->format('m/d/Y');
    }
    public function updatedNewAvatar()
    {
        $this->validate([
            'newAvatar' => 'image|max:10000'
        ]);
    }

    public function save()
    {
        $this->validate([
            'name' => 'max:24',
            'about' => 'max:120',
            'birthday' => 'sometimes',
            'newAvatar' => 'sometimes|image|max:10000'
        ]);

        $filename = $this->newAvatar->store('/', 'avatars');

        auth()->user()->update([
            'name' => $this->name,
            'about' => $this->about,
            'birthday' => $this->birthday,
            'avatar' => $filename,
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
