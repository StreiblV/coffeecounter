<?php

namespace App\Livewire\Analytics;

use App\Http\Controllers\Api\V1\EntryController;
use Auth;
use Carbon\Carbon;
use Livewire\Component;

class ChartThirtyDays extends Component
{
    public $data;

    protected EntryController $entryController;

    public function boot(EntryController $entryController) {        
        $this->entryController = $entryController;
        $this->data = $this->thirtyDays();
    }

    public function thirtyDays() {        
        return Auth::user()->entries()
            ->whereDate("created_at", Carbon::today())
            ->selectRaw("date_format(created_at, '%Y-%m-%d') as date, count(*) as aggregate")
            ->groupBy("date")
            ->get();
    }

    public function render()
    {
        return view('livewire.analytics.chart-thirty-days');
    }
}
