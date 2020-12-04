<?php

namespace App\Http\Controllers;

use App\Models\Heartbeat;
use Illuminate\Http\Request;
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
        $no_ssl_verify = true;

        $wakacfg = ''
            . '[settings]' . "\r\n"
            . 'api_key = ' . $api_key . "\r\n"
            . 'api_url = ' . $api_url . "\r\n"
            . 'no_ssl_verify = ' . ($no_ssl_verify ? 'true' : 'false') . "\r\n";

        return view('wakacfg', compact('wakacfg'));
    }
}
