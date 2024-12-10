<?php

namespace App\Livewire\Analytics;


use App\Http\Controllers\Api\V1\EntryController;
use Auth;
use Carbon\Carbon;
use Livewire\Component;

class ChartTotal extends Component
{    
    public $total;

    protected EntryController $entryController;

    public function boot(EntryController $entryController) {        
        $this->entryController = $entryController;
        $this->total = $entryController->totalEnergyLevels();
    }

    public function render()
    {
        return view('livewire.analytics.chart-total');
    }
}
