<?php

namespace App\Livewire\Preferences;

use Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ChangePassword extends Component
{
    public $user;

    #[Validate("required")]
    public $password = "";

    #[Validate("required|required_with:password|same:password")]
    public $passwordConfirmation = "";

    public function save() {
        $this->validate();

        $this->user->password = Hash::make($this->password);
        $this->user->save();

        redirect("/preferences");
    }

    public function render()
    {
        return view('livewire.preferences.change-password');
    }
}
