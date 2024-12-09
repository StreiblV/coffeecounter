<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    #[Validate("required")]
    public $email = "";

    #[Validate("required")]
    public $password = "";
}
