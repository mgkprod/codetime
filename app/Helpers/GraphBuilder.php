<?php

namespace App\Helpers;

class GraphBuilder
{
    public static function codingActivity($payload)
    {
        $payload
            ->transform(function ($activity) {
                list($h, $m, $s) = explode(':', $activity->duration);
                $activity->duration_in_seconds = ($h * 60 * 60) + ($m * 60) + $s;

                if ($activity->project == null || $activity->project == '') {
                    $activity->project = 'unknown';
                }

                return $activity;
            });

        $grouped = $payload->groupBy('started_at');
        $projects = $payload->groupBy('project');

        $data = [];

        foreach ($grouped as $started_at => $activity) {
            $dataset = [
                'started_at' => $started_at,
            ];

            foreach ($projects->keys() as $project) {
                // Get duration for this day
                $dataset[$project] = data_get($activity->where('project', $project)->first(), 'duration_in_seconds', 0);
                $dataset[$project . '_human'] = format_time($dataset[$project]);
            }

            $dataset['total'] = $activity->sum('duration_in_seconds');
            $dataset['total' . '_human'] = format_time($dataset['total']);

            $data[] = $dataset;
        }

        return [
            'labels' => $projects->keys(),
            'data' => $data
        ];
    }

    public static function durations($payload)
    {
        // $payload
        //     ->transform(function ($activity) {
        //         list($h, $m, $s) = explode(':', $activity->duration);
        //         $activity->duration_in_seconds = ($h * 60 * 60) + ($m * 60) + $s;

        //         if ($activity->project == null || $activity->project == '') {
        //             $activity->project = 'unknown';
        //         }

        //         return $activity;
        //     });

        // $grouped = $payload->groupBy('started_at');
        $projects = $payload->groupBy('project');

        $data = [];

        // foreach ($grouped as $started_at => $activity) {
        //     $dataset = [
        //         'started_at' => $started_at,
        //     ];

        //     foreach ($projects->keys() as $project) {
        //         // Get duration for this day
        //         $dataset[$project] = data_get($activity->where('project', $project)->first(), 'duration_in_seconds', 0);
        //         $dataset[$project . '_human'] = format_time($dataset[$project]);
        //     }

        //     $dataset['total'] = $activity->sum('duration_in_seconds');
        //     $dataset['total' . '_human'] = format_time($dataset['total']);

        //     $data[] = $dataset;
        // }

        return [
            'labels' => $projects->keys(),
            'data' => $data
        ];
    }
}
