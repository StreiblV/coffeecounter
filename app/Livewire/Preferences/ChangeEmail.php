<?php

namespace App\Livewire\Preferences;

use Livewire\Attributes\Validate;
use Livewire\Component;

class ChangeEmail extends Component
{
    public $user;

    #[Validate("required")]
    public $email = "";

    public function boot() {
        $this->email = $this->user->email;
    }

    public function save() {
        $this->validate();

        $this->user->email = $this->email;
        $this->user->save();

        redirect("/preferences");
    }

    public function render()
    {
        return view('livewire.preferences.change-email');
    }
}
