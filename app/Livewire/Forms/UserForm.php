<?php

namespace App\Livewire\Forms;

use Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\User;

class UserForm extends Form
{
    #[Validate("required")]
    public $name = "";

    #[Validate("required")]
    public $email = "";

    #[Validate("required")]
    public $password = "";

    #[Validate("required|required_with:password|same:password")]
    public $passwordConfirmation = "";

    public function store() {
        $this->validate();

        $user = User::create(
            $this->all()
        );

        Auth::login($user);
    }
}
