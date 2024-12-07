<?php

namespace App\Livewire;

use Livewire\Component;

class Register extends Component
{
    public $is_forgotten = false;

    public function render()
    {
        return view('livewire.register');
    }

    public function forgot() {
        $this->is_forgotten = true;
    }
}
