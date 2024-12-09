<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use Livewire\Component;

class Register extends Component
{
    public UserForm $form;

    public function render()
    {
        return view('livewire.register');
    }

    public function save() {
        $this->form->store();
        return $this->redirect('/login');
    }
}
