<?php

namespace App\Http\Controllers\Api\V1;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;

class EntryController extends Controller
{
    public function energyLevels() {        
        $sum = 0;
        $entries = Auth::user()
            ->entries()
            ->get();

        foreach ($entries as $entry) {
            $sum += $entry->energyLevel();
        }

        return $sum;
    }

    public function render () {
        $entries = Auth::user()->entries;
        $energyLevels = $this->energyLevels();
    
        return view('dashboard', ["entries" => $entries, "energyLevels" => $energyLevels]);
    }
}
