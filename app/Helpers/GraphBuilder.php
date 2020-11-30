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

        $datasets = [];

        $bg_colors = collect([
            '#FCA5A5',
            '#F87171',
            '#EF4444',
            '#DC2626',
            '#FDBA74',
            '#FB923C',
            '#F97316',
            '#EA580C',
            '#FCD34D',
            '#FBBF24',
            '#F59E0B',
            '#D97706',
            '#FDE047',
            '#FACC15',
            '#EAB308',
            '#CA8A04',
            '#BEF264',
            '#A3E635',
            '#84CC16',
            '#65A30D',
            '#86EFAC',
            '#4ADE80',
            '#22C55E',
            '#16A34A',
            '#6EE7B7',
            '#34D399',
            '#10B981',
            '#059669',
            '#5EEAD4',
            '#2DD4BF',
            '#14B8A6',
            '#0D9488',
            '#67E8F9',
            '#22D3EE',
            '#06B6D4',
            '#0891B2',
            '#7DD3FC',
            '#38BDF8',
            '#0EA5E9',
            '#0284C7',
            '#93C5FD',
            '#60A5FA',
            '#3B82F6',
            '#2563EB',
            '#A5B4FC',
            '#818CF8',
            '#6366F1',
            '#4F46E5',
            '#C4B5FD',
            '#A78BFA',
            '#8B5CF6',
            '#7C3AED',
            '#D8B4FE',
            '#C084FC',
            '#A855F7',
            '#9333EA',
            '#F0ABFC',
            '#E879F9',
            '#D946EF',
            '#C026D3',
            '#F9A8D4',
            '#F472B6',
            '#EC4899',
            '#DB2777',
            '#FDA4AF',
            '#FB7185',
            '#F43F5E',
            '#E11D48',
        ])->shuffle();

        foreach ($projects as $label => $activity) {
            $dataset = [
                'type' => 'bar',
                'label' => $label,
                'backgroundColor' => $bg_colors->pop(),
                'data' => [],
            ];

            foreach ($grouped->keys() as $started_at) {
                // Get duration for this day
                $data = data_get($activity->where('started_at', $started_at)->first(), 'duration_in_seconds', 0);
                $dataset['data'][] = $data;
            }

            $datasets[] = $dataset;
        }

        $dataset = [
            'type' => 'line',
            'label' => 'total',
            'borderColor' => 'rgb(20, 40, 191)',
            'borderWidth' => '2',
            'fill' => 'false',
            'data' => [],
        ];

        foreach ($grouped as $started_at => $activities) {
            $data = $activities->sum('duration_in_seconds');
            $dataset['data'][] = $data;
        }

        $datasets[] = $dataset;

        return [
            'labels' => $grouped->keys(),
            'datasets' => $datasets,
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
