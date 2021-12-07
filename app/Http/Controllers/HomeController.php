<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $timeout = request()->get('timeout', 15);
        $userId = auth()->user()->id;

        $codingActivity = $this->getDurations(
            now()->subDay(request()->get('days', 14))->startOfDay(),
            now(),
            $timeout,
            $userId,
            0
        );

        $durations = $this->getDurations(
            now()->startOfDay(),
            now()->endOfDay(),
            $timeout,
            $userId,
            1
        );

        $categoriesUsed = collect();
        $dailyAverages = collect();
        $languages = collect();
        $editorsUsed = collect();
        $projects = collect();

        return view('home', compact(
            'codingActivity',
            'durations',
            'categoriesUsed',
            'dailyAverages',
            'languages',
            'editorsUsed',
            'projects',
        ));
    }

    public function getDurations($from, $to, $timeout, $userId, $level = 0)
    {
        if ($level == 0) {
            $groupBy = "'yyyy-mm-dd'";
        } elseif ($level == 1) {
            $groupBy = "'yyyy-mm-dd hh24:mi:00'";
        }

        return DB::query()
            ->selectRaw('project, to_char(created_at, ' . $groupBy . ') as started_at')
            ->selectRaw('sum(case when diff < \'00:' . $timeout . ':00\' then diff else \'00:00:00\' end) as duration')
            ->from(function ($query) use ($from, $to, $userId) {
                $query
                    ->selectRaw('project, created_at')
                    ->selectRaw('created_at - lag(created_at, 1) over (partition by project, to_char(created_at, \'yyyy-mm-dd\') order by created_at) as diff')
                    ->from('heartbeats')
                    ->whereBetween('created_at', [$from, $to])
                    ->where('user_id', $userId)
                    ->orderBy('project')
                    ->orderBy('created_at', 'ASC');
            }, 'activity')
            ->groupBy('project')
            ->groupBy('started_at')
            ->orderBy('started_at', 'ASC')
            ->get();
    }

    public function wakacfg()
    {
        $api_key = auth()->user()->api_key;
        $api_url = route('api.heartbeat');

        $wakacfg = ''
            . '[settings]' . PHP_EOL
            . 'api_key = ' . $api_key . PHP_EOL
            . 'api_url = ' . $api_url . PHP_EOL
            . 'status_bar_coding_activity = false' . PHP_EOL;

        if (! request()->secure()) {
            $wakacfg .= 'no_ssl_verify = true' . PHP_EOL;
        }

        return view('wakacfg', compact('wakacfg'));
    }
}
