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
    public $email = '';
    public $password = '';

    public function register()
    {
        User::create([
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
