<?php

namespace App\Livewire\Dashboard;

use App\Http\Controllers\Api\V1\EntryController;
use Livewire\Component;

class EntryTable extends Component
{
    public $entries;

    protected EntryController $entryController;

    public function boot(EntryController $entryController) {        
        $this->entryController = $entryController;        
    }

    public function remove(string $id) {
        $this->entryController->remove($id);
        return redirect("/dashboard");
    }

    public function render()
    {
        return view('livewire.dashboard.entry-table');
    }
}
