<?php

namespace App\Livewire\Preferences;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Request;

class ChangeUsername extends Component
{
    public $user;

    #[Validate("required")]
    public $name = "";

    public function boot() {
        $this->name = $this->user->name;
    }

    public function save() {
        $this->validate();

        $this->user->name = $this->name;
        $this->user->save();
        
        redirect("/preferences");
    }

    public function render()
    {
        return view('livewire.preferences.change-username');
    }
}
