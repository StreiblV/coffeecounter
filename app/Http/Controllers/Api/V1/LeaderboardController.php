<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Entry;
use App\Models\User;
use DB;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaderboardController extends Controller
{
    public function topConsumer() {
        $types = [
            "coffee",
            "coke",
            "wildkraut",
            "energydrink"
        ];
        $results = [];

        foreach ($types as $type) {
            $top = Entry::selectRaw("user_id, count(id) as points")
                ->where("type", "=", $type)            
                ->groupBy("user_id")
                ->orderByDesc("points")
                ->first();
            $topUser = User::find($top->user_id)->first();
            $results[$type] = $topUser;

        }

        return $results;
    }

    public function render() {
        return view('leaderboard', [
            "top" => $this->topConsumer()
        ]);
    }
}
