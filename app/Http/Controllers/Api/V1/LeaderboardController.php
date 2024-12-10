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
    public function topConsumer(string $timespan) {
        $types = [
            "coffee",
            "coke",
            "wildkraut",
            "energydrink"
        ];
        $results = [];
        $startOfMonth = now()->startOfMonth();
        $today = now();

        foreach ($types as $type) {
            // Base query
            $query = DB::table('entries')
                ->select('user_id', DB::raw('COUNT(id) as points'))
                ->where('type', $type);

            // Apply filters based on timespan
            if ($timespan == "today") {
                $query->whereDate('created_at', $today);
            } elseif ($timespan == "monthly") {
                $query->whereBetween('created_at', [$startOfMonth, $today]);
            }

            // Execute the query
            $top = $query->groupBy('user_id')
                ->orderByDesc('points')
                ->first();

            if ($top) {
                $topUser = User::find($top->user_id);
                $results[$type] = [
                    'username' => $topUser ? $topUser->name : 'Nobody',
                    'points' => $top->points
                ];
            } else {
                $results[$type] = [
                    'username' => 'Nobody',
                    'points' => 0
                ];
            }
        }
        return $results;
    }

    public function render() {
        $topToday = $this->topConsumer('today');
        $topMonth = $this->topConsumer('monthly');
        $topTotal = $this->topConsumer('total');
        return view('leaderboard', compact('topToday', 'topMonth', 'topTotal'));
    }
}
