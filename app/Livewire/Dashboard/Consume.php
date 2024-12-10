<?php

namespace App\Livewire\Dashboard;

use App\Http\Controllers\Api\V1\EntryController;
use Livewire\Component;
use App\Models\Entry;
use Auth;

class Consume extends Component
{
    protected EntryController $entryController;

    public function boot(EntryController $entryController) {        
        $this->entryController = $entryController;
    }

    public function consume(string $type) {        
        $this->entryController->consume($type);
        return redirect("/dashboard");
    }

    public function render()
    {
        return view('livewire.dashboard.consume');
    }
}
