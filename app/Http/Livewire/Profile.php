<?php
namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public User $user;
    public $upload;

    protected $rules = [
        'user.name' => 'max:24',
        'user.about' => 'max:120',
        'user.birthday' => 'sometimes',
        'upload'    => 'nullable|image|max:1000'
    ];

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function updatedUpload()
    {
        $this->validate([
            'upload' => 'nullable|image|max:1000'
        ]);
    }

    public function save()
    {
        $this->validate();

        $this->user->save();

        $this->upload && $this->user->update([
            'avatar' => $this->upload->store('/', 'avatars'),
        ]);

        // $this->dispatchBrowserEvent('notify', 'Profile Saved!');
        $this->emitSelf('notify-saved');
        // session()->flash('notify-saved');
    }
    public function render()
    {
        return view('livewire.profile');
    }
}
