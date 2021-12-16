<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class GraphBuilder
{
    public static function codingActivity($payload)
    {
        $oldestDate = carbon($payload[0]->started_at);
        $latestDate = carbon($payload[count($payload) - 1]->started_at);

        $data = [];
        $categories = [];

        for ($date = $oldestDate; $date->lte($latestDate); $date->addDay()) {
            $totalDuration = (clone $payload)->where('started_at', $date->format('Y-m-d'))->sum('duration_in_seconds');

            $data[] = $totalDuration;
            $categories[] = $date->format('m-d');
        }

        return [
            'data' => $data,
            'categories' => $categories,
        ];
    }

    public static function projectsBreakdown($payload)
    {
        $data = [];
        $labels = [];

        $payload
            ->transform(function ($activity) {
                $activity->project = Str::limit($activity->project, 20);

                return $activity;
            });

        $projects = $payload->groupBy('project');
        $projectsDurations = collect([]);

        foreach ($projects as $name => $project) {
            $projectsDurations[$name] = $project->sum('duration_in_seconds');
        }

        $projectsDurations = $projectsDurations->sortDesc();

        $mostActiveProjects = $projectsDurations->take(10);
        $others = $projectsDurations->skip(10)->sum();

        foreach ($mostActiveProjects as $name => $duration) {
            $data[] = $duration;
            $labels[] = $name;
        }

        if ($others) {
            $data[] = $others;
            $labels[] = 'other projects';
        }

        return [
            'data' => $data,
            'labels' => $labels,
        ];
    }

    public static function activityPerProject($payload)
    {
        $durations = [];
        $categories = [];

        $payload
            ->transform(function ($activity) {
                $activity->project = Str::limit($activity->project, 20);

                return $activity;
            });

        $oldestDate = carbon($payload[0]->started_at);
        $latestDate = carbon($payload[count($payload) - 1]->started_at);
        $allProjects = $payload->groupBy('project')->keys();

        for ($date = $oldestDate; $date->lte($latestDate); $date->addDay()) {
            foreach ($allProjects as $project) {
                $sum = (clone $payload)
                    ->where('project', $project)
                    ->where('started_at', $date->format('Y-m-d'))
                    ->first();

                $durations[$project][] = optional($sum)->duration_in_seconds ?? 0;
            }

            $categories[] = $date->format('m-d');
        }

        foreach ($durations as $name => $data) {
            $series[] = [
                'name' => $name,
                'data' => $data,
            ];
        }

        return [
            'series' => $series,
            'categories' => $categories,
        ];
    }

    public static function timeline($payload)
    {
        $data = [];

        $payload
            ->transform(function ($activity) {
                $activity->project = Str::limit($activity->project, 20);

                return $activity;
            });

        $projects = $payload->groupBy('project');

        foreach ($projects as $name => $durations) {
            $durations->transform(fn ($duration) => [
                carbon($duration->started_at)->timestamp * 1000,
                carbon($duration->started_at)->addSeconds($duration->duration_in_seconds)->timestamp * 1000,
            ]);

            foreach ($durations as $duration) {
                $data[] = [
                    'x' => $name,
                    'y' => $duration,
                ];
            }
        }

        return [
            'data' => $data,
        ];
    }
}
