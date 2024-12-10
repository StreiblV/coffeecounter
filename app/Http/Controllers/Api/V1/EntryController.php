<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Entry;
use Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class EntryController extends Controller
{
    public function totalEnergyLevels() {
        $entries = Auth::user()
            ->entries()
            ->get();

        return $this->calculateEnergyLevel($entries);
    }

    public function dailyEnergyLevels() {
        $entries = Auth::user()
            ->entries()
            ->whereDate("created_at", Carbon::today())
            ->get();

        return $this->calculateEnergyLevel($entries);
    }

    public function calculateEnergyLevel(Collection $entries) {
        $sum = 0;

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

    public function findAll(): Collection {
        return Auth::user()->entries()->get();
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
        $energyLevels = $this->dailyEnergyLevels();
    
        return view('dashboard', ["entries" => $entries, "energyLevels" => $energyLevels]);
    }
}
