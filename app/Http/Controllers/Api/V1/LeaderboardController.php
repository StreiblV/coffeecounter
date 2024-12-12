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
    private function topConsumer(string $timespan) {
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

    private function topEnergyLeader(string $timespan) {
        // Fetch energy leaders
        $timeCondition = '';
        $columnAlias = 'energy_level';

        switch ($timespan) {
            case 'today':
                $timeCondition = DB::raw("DATE(e.created_at) = CURDATE()");
                break;
            case 'monthly':
                $timeCondition = DB::raw("MONTH(e.created_at) = MONTH(CURDATE())");
                $columnAlias = 'avg_energy_level';
                break;
            case 'total':
                $timeCondition = null; // No specific condition for total
                $columnAlias = 'total_energy_level';
                break;
            default:
                return ['user' => 'Nobody', $columnAlias => 0];
        }

        // Build the query
        $query = DB::table('users as u')
            ->select('u.name as user')
            ->leftJoin('entries as e', 'u.id', '=', 'e.user_id')
            ->when($timeCondition, function ($query) use ($timeCondition) {
                $query->whereRaw($timeCondition);
            })
            ->selectRaw(
                $timespan === 'monthly'
                    ? "ROUND(SUM(CASE
                                    WHEN e.type IN ('coffee', 'wildkraut', 'energydrink') THEN 3
                                    WHEN e.type = 'coke' THEN 1
                                    ELSE 0
                                END) / COUNT(DISTINCT DATE(e.created_at)), 2) as avg_energy_level"
                    : "SUM(CASE
                            WHEN e.type IN ('coffee', 'wildkraut', 'energydrink') THEN 3
                            WHEN e.type = 'coke' THEN 1
                            ELSE 0
                        END) as $columnAlias"
            )
            ->groupBy('u.name')
            ->orderByDesc($columnAlias)
            ->limit(1);

        // Execute the query
        $result = $query->first();
        return $result ? (array) $result : ['user' => 'Nobody', $columnAlias => 0];
    }

    private function top10EnergyToday() {
        $today = now()->toDateString();

        $top10 = DB::table('users as u')
            ->select('u.name as user')
            ->leftJoin('entries as e', 'u.id', '=', 'e.user_id')
            ->whereDate('e.created_at', $today)
            ->selectRaw(
                "SUM(CASE
                WHEN e.type IN ('coffee', 'wildkraut', 'energydrink') THEN 3
                WHEN e.type = 'coke' THEN 1
                ELSE 0
            END) as energy_level"
            )
            ->groupBy('u.name')
            ->orderByDesc('energy_level')
            ->limit(10)
            ->get();

        return $top10;
    }

    private function setTop10Rank($top10EnergyToday) {
        // Custom ranking logic
        $rank = 1;
        $previousEnergyLevel = null;

        foreach ($top10EnergyToday as $index => $entry) {
            if ($entry->energy_level !== $previousEnergyLevel) {
                $rank = $index + 1;
            }
            $entry->rank = $rank; // Assign the calculated rank
            $previousEnergyLevel = $entry->energy_level;
        }
        return $top10EnergyToday;
    }

    public function render() {
        $topToday = $this->topConsumer('today');
        $topMonth = $this->topConsumer('monthly');
        $topTotal = $this->topConsumer('total');

        $topEnergyToday = $this->topEnergyLeader('today');
        $topEnergyMonthly = $this->topEnergyLeader('monthly');
        $topEnergyTotal = $this->topEnergyLeader('total');

        $top10EnergyToday = $this->top10EnergyToday();
        $top10EnergyToday = $this->setTop10Rank($top10EnergyToday);

        return view('leaderboard', compact('topToday', 'topMonth', 'topTotal', 'topEnergyToday', 'topEnergyMonthly', 'topEnergyTotal', 'top10EnergyToday'));
    }
}
