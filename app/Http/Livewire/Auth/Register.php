<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

/**
 * Class Register
 * @property string email
 * @property string password
 * @property string passwordConformation
 *
 * @package App\Http\Livewire\Auth
 */
class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $passwordConformation = '';

    public function register()
    {
        $this->validate([
           'name' => 'required|unique:users',
           'email' => 'required|email|unique:users',
           'password' => 'required|min:6|same:passwordConformation',
           'passwordConformation' => 'required|min:6'
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // $this->reset();
        return redirect(route('dashboard'));
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
