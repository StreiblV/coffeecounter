<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Entry;
use Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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

    public function findToday(): Collection {
        return Auth::user()->entries()
        ->whereDate("created_at", Carbon::today())
        ->orderByDesc("created_at")
        ->get();
    }

    public function consume(string $type) {        
        $user = Auth::user();

        Entry::create([
            "type"=> $type,
            "user_id" => $user->id,
        ]);
    }

    public function remove(int $id) {
        $user = Auth::user();
        
        Entry::where("id", "=", $id)
            ->where("user_id", "=", $user->id)
            ->delete();
    }

    public function render () {
        $entries = $this->findToday();
        $energyLevels = $this->energyLevels();
    
        return view('dashboard', ["entries" => $entries, "energyLevels" => $energyLevels]);
    }
}
