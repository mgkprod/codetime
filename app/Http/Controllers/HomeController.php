<?php

namespace App\Http\Controllers;

use App\Models\Heartbeat;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $timeout = 15;
        $from = now()->subDays(7);
        $to = now();

        $heartbeats = auth()->user()->heartbeats()
            ->orderBy('project')
            ->orderBy('created_at')
            ->whereBetween('created_at', [$from, $to]);

        $durations = $this->getProjectsActivity($heartbeats, $timeout);
        $coding_activity = $this->getCodingActivity($durations);
        $categories_used = collect();
        $daily_averages = $this->getDailyAverages($durations);
        $languages = collect();
        $editors_used = collect();
        $projects = collect();

        return view('home', compact('coding_activity', 'categories_used', 'durations', 'daily_averages', 'languages', 'editors_used', 'projects'));
    }

    protected function getProjectsActivity($heartbeats, $timeout = 15)
    {
        $activity = (clone $heartbeats)
            ->selectRaw('project, created_at')
            ->get();

        $projects_activity = collect();

        $activity->each(function ($heartbeat) use (&$projects_activity, $timeout) {
            $latest_activity = $projects_activity
                ->where('project', $heartbeat->project)
                ->where('day', $heartbeat->created_at->format('Y-m-d'));

            $latest_activity_key = $latest_activity->keys()->last();
            $latest_activity = $latest_activity->last();

            if (
                $latest_activity
                && (clone $heartbeat->created_at)->subMinutes($timeout) < $latest_activity['last_heartbeat_at']
            ) {
                $latest_activity['last_heartbeat_at'] = $heartbeat->created_at;
                $latest_activity['duration'] = $latest_activity['started_at']->diff($latest_activity['last_heartbeat_at']);

                $projects_activity[$latest_activity_key] = $latest_activity;
                return true;
            }

            $projects_activity[] = [
                'project' => $heartbeat->project,
                'day' => $heartbeat->created_at->format('Y-m-d'),
                'started_at' => $heartbeat->created_at,
                'last_heartbeat_at' => $heartbeat->created_at,
                'duration' => $heartbeat->created_at->diff($heartbeat->created_at)
            ];
        });

        return $projects_activity;
    }

    protected function getCodingActivity($projects_activity)
    {
        $coding_activity = collect();

        $projects_activity
            ->groupBy('day')
            ->each(function ($activity, $day) use (&$coding_activity) {
                $activity
                    ->groupBy('project')
                    ->each(function ($activity, $project) use (&$coding_activity, $day) {
                        $activity
                            ->each(function ($period) use (&$coding_activity, $day, $project) {
                                $latest_activity = $coding_activity
                                    ->where('day', $day)
                                    ->where('project', $project);

                                $latest_activity_key = $latest_activity->keys()->last();
                                $latest_activity = $latest_activity->last();

                                if ($latest_activity) {
                                    $now = now();
                                    $now_ = clone $now;
                                    $now->add($latest_activity['duration']);
                                    $now->add($period['duration']);

                                    $latest_activity['duration'] = $now_->diff($now);
                                    $coding_activity[$latest_activity_key] = $latest_activity;

                                    return true;
                                }

                                $coding_activity[] = [
                                    'project' => $project,
                                    'day' => $day,
                                    'duration' => $period['duration'],
                                ];
                            });
                    });
            });

        return $coding_activity;
    }

    protected function getDailyAverages($projects_activity)
    {
        $daily_activity = collect();

        $projects_activity
            ->groupBy('day')
            ->each(function ($activity, $day) use (&$daily_activity) {
                $activity
                    ->each(function ($period) use (&$daily_activity, $day) {
                        $latest_activity = $daily_activity
                            ->where('day', $day);

                        $latest_activity_key = $latest_activity->keys()->last();
                        $latest_activity = $latest_activity->last();

                        if ($latest_activity) {
                            $now = now();
                            $now_ = clone $now;
                            $now->add($latest_activity['duration']);
                            $now->add($period['duration']);

                            $latest_activity['duration'] = $now_->diff($now);
                            $daily_activity[$latest_activity_key] = $latest_activity;

                            return true;
                        }

                        $daily_activity[] = [
                            'day' => $day,
                            'duration' => $period['duration'],
                        ];
                    });
            });

        return $daily_activity;
    }
}
