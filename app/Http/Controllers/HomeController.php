<?php

namespace App\Http\Controllers;

use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function dashboard()
    {
        return inertia('dashboard');
    }

    public function data()
    {
        $timeout = request()->get('timeout', 15);
        $userId = auth()->user()->id;

        $activity = $this->getDurations(
            now()->subDays(request()->get('days', 7))->startOfDay(),
            now(),
            $timeout,
            $userId,
            0
        );

        $activity_l2 = $this->getDurations(
            now()->subDays(request()->get('days', 7))->startOfDay(),
            now(),
            $timeout,
            $userId,
            2
        );

        $projects =
             (clone $activity)
             ->groupBy('project')
             ->transform(fn ($project) =>  $project->sum('duration_in_seconds'))
             ->sortDesc();

        $totalCodingTime = CarbonInterval::create(0)->addSeconds($activity->sum('duration_in_seconds'))->cascade()->forHumans();
        $totalProjects = $projects->count();
        $mostActiveProject = $projects->keys()->first();

        return  [
            'totalCodingTime' => $totalCodingTime,
            'totalProjects' => $totalProjects,
            'mostActiveProject' => $mostActiveProject,
            'codingActivity' => \App\Helpers\GraphBuilder::codingActivity($activity),
            'projectsBreakdown' => \App\Helpers\GraphBuilder::projectsBreakdown($activity),
            'activityPerProject' => \App\Helpers\GraphBuilder::activityPerProject($activity),
            'timeline' => \App\Helpers\GraphBuilder::timeline($activity_l2),
        ];
    }

    public function getDurations($from, $to, $timeout, $userId, $level = 0)
    {
        if ($level == 0) {
            $groupBy = "'yyyy-mm-dd'";
        } elseif ($level == 1) {
            $groupBy = "'yyyy-mm-dd hh24:00:00'";
        } elseif ($level == 2) {
            $groupBy = "'yyyy-mm-dd hh24:mi:00'";
        }

        $durations = DB::query()
            ->selectRaw('project, to_char(created_at, ' . $groupBy . ') as started_at')
            ->selectRaw('sum(case when diff < \'00:' . $timeout . ':00\' then diff else \'00:00:00\' end) as duration')
            ->selectRaw('count(*) as heartbeats')
            ->from(function ($query) use ($from, $to, $userId) {
                $query
                    ->selectRaw('CASE WHEN project_mappings.new is NULL THEN project ELSE project_mappings.new END AS project, created_at')
                    ->selectRaw('created_at - lag(created_at, 1) over (partition by project, to_char(created_at, \'yyyy-mm-dd\') order by created_at) as diff')
                    ->from('heartbeats')
                    ->leftJoin('project_mappings', function ($join) {
                        $join->on('heartbeats.user_id', '=', 'project_mappings.user_id');
                        $join->on('heartbeats.project', '=', 'project_mappings.old');
                    })
                    ->whereBetween('created_at', [$from, $to])
                    ->where('heartbeats.user_id', $userId)
                    ->orderBy('project')
                    ->orderBy('created_at', 'ASC');
            }, 'activity')
            ->groupBy('project')
            ->groupBy('started_at')
            ->orderBy('started_at', 'ASC')
            ->get();

        $durations
            ->transform(function ($activity) {
                list($h, $m, $s) = explode(':', $activity->duration);
                $activity->duration_in_seconds = ($h * 60 * 60) + ($m * 60) + $s;

                if ($activity->project == null || $activity->project == '') {
                    $activity->project = 'unknown';
                }

                return $activity;
            });

        return $durations;
    }

    public function wakacfg()
    {
        $apiKey = auth()->user()->api_key;
        $apiUrl = route('api.heartbeat');

        $wakacfg = ''
            . '[settings]' . PHP_EOL
            . 'api_key = ' . $apiKey . PHP_EOL
            . 'api_url = ' . $apiUrl . PHP_EOL
            . 'status_bar_coding_activity = false' . PHP_EOL;

        if (! request()->secure()) {
            $wakacfg .= 'no_ssl_verify = true' . PHP_EOL;
        }

        return inertia('wakacfg', [
            'wakacfg' => $wakacfg,
        ]);
    }
}
