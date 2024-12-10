<?php

namespace App\Livewire\Analytics;

use App\Http\Controllers\Api\V1\EntryController;
use Auth;
use Carbon\Carbon;
use Livewire\Component;

class ChartRatio extends Component
{
    public $data;

    protected EntryController $entryController;

    public function boot(EntryController $entryController) {        
        $this->entryController = $entryController;
        $this->data = $this->ratio();
    }

    public function ratio() {        
        return Auth::user()->entries()
            ->selectRaw("type, count(*) as aggregate")
            ->groupBy("type")
            ->get();
    }

    public function render()
    {
        return view('livewire.analytics.chart-ratio');
    }
}
