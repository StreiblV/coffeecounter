<?php

namespace App\Livewire;

use App\Livewire\Forms\LoginForm;
use App\Models\User;
use Auth;
use Livewire\Component;

class Login extends Component
{
    public LoginForm $form;

    public function render()
    {
        return view('livewire.login');
    }

    public function login() {
        $this->form->validate();
        
        $credentials = [
            "name" => $this->form->email,
            "password" => $this->form->password
        ];

        if (Auth::attempt($credentials)) {
            session()->regenerate();
 
            return redirect()->intended('dashboard');
        }

        $credentials = [
            "email" => $this->form->email,
            "password" => $this->form->password
        ];

        if (Auth::attempt($credentials)) {
            session()->regenerate();
 
            return redirect()->intended('dashboard');
        }

        $this->addError('login', 'invalid credentials');
    }
}
