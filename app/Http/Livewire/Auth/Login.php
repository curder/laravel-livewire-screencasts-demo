<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password = '';

    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6',
        ]);

        if (!auth()->attempt($credentials)) {
            $this->addError('email', trans('auth.failed'));

            return;
        }

        return redirect()->intended();
    }
    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.auth');
    }
}
