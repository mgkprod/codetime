@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Coding activity</div>
                <div class="card-body p-0">
                    <div id="coding-activity" class="w-100" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Categories used</div>
                <div class="card-body"></div>
            </div>
        </div> --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Durations</div>
                <div class="card-body p-0">
                    <div id="durations" class="w-100" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Daily average</div>
                <div class="card-body p-0">
                    @foreach ($dailyAverages as $activity)
                        <div class="p-3">
                            On day: {{ $activity['day'] }}<br>
                            Duration: {{ $activity['duration']->format('%H h %i m %s s') }}<br>
                        </div>

                        @if (!$loop->last)
                            <hr class="m-0">
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Languages</div>
                <div class="card-body"></div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Editors used</div>
                <div class="card-body"></div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Projects</div>
                <div class="card-body"></div>
            </div>
        </div> --}}
    </div>
</div>

@endsection

@push('js')
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

    <script>
        function codingActivity() {
            var chart = am4core.create("coding-activity", am4charts.XYChart);

            // Add data
            @php
                $codingActivity = \App\Helpers\GraphBuilder::codingActivity($codingActivity);
            @endphp

            chart.data = @json($codingActivity['data']);
            var labels = @json($codingActivity['labels']);

            // Create axes
            var categoryAxis = chart.xAxes.push(new am4charts.DateAxis());
            categoryAxis.renderer.grid.template.location = 0;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.renderer.inside = true;
            valueAxis.renderer.labels.template.disabled = true;
            valueAxis.min = 0;

            function createSeries(name) {
                let series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueY = name;
                series.dataFields.dateX = "started_at";
                series.name = name;
                series.stacked = true;

                return series;
            }

            var column = undefined
            var tooltip = ''

            labels.forEach(element => {
                if (element == 'started_at') return
                series = createSeries(element)
                tooltip += element + ': {' + element + '_human}\n'
            });

            // Create line series :
            var lineSeries = chart.series.push(new am4charts.LineSeries());
            lineSeries.name = "total";
            lineSeries.dataFields.valueY = "total";
            lineSeries.dataFields.dateX = "started_at";

            lineSeries.stroke = am4core.color("#fdd400");
            lineSeries.strokeWidth = 3;
            lineSeries.propertyFields.strokeDasharray = "lineDash";
            lineSeries.tooltip.label.textAlign = "middle";

            var bullet = lineSeries.bullets.push(new am4charts.Bullet());
            bullet.fill = am4core.color("#fdd400"); // tooltips grab fill from parent by default
            bullet.tooltipText = '[bold]{started_at}: {total_human}[/]\n----\n' + tooltip;

            var circle = bullet.createChild(am4core.Circle);
            circle.radius = 4;
            circle.fill = am4core.color("#fff");
            circle.strokeWidth = 3;

            chart.legend = new am4charts.Legend();
        }

        function durations() {
            var chart = am4core.create("durations", am4charts.XYChart);

            // Add data
            @php
                $durations = \App\Helpers\GraphBuilder::durations($durations);
            @endphp

            // chart.data = @json($codingActivity['data']);
            // var labels = @json($codingActivity['labels']);

            // // Create axes
            // var categoryAxis = chart.xAxes.push(new am4charts.DateAxis());
            // categoryAxis.renderer.grid.template.location = 0;

            // var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            // valueAxis.renderer.inside = true;
            // valueAxis.renderer.labels.template.disabled = true;
            // valueAxis.min = 0;

            // function createSeries(name) {
            //     let series = chart.series.push(new am4charts.ColumnSeries());
            //     series.dataFields.valueY = name;
            //     series.dataFields.dateX = "started_at";
            //     series.name = name;
            //     series.stacked = true;

            //     return series;
            // }

            // var column = undefined
            // var tooltip = ''

            // labels.forEach(element => {
            //     if (element == 'started_at') return
            //     series = createSeries(element)
            //     tooltip += element + ': {' + element + '_human}\n'
            // });

            // // Create line series :
            // var lineSeries = chart.series.push(new am4charts.LineSeries());
            // lineSeries.name = "total";
            // lineSeries.dataFields.valueY = "total";
            // lineSeries.dataFields.dateX = "started_at";

            // lineSeries.stroke = am4core.color("#fdd400");
            // lineSeries.strokeWidth = 3;
            // lineSeries.propertyFields.strokeDasharray = "lineDash";
            // lineSeries.tooltip.label.textAlign = "middle";

            // var bullet = lineSeries.bullets.push(new am4charts.Bullet());
            // bullet.fill = am4core.color("#fdd400"); // tooltips grab fill from parent by default
            // bullet.tooltipText = '[bold]{started_at}: {total_human}[/]\n----\n' + tooltip;

            // var circle = bullet.createChild(am4core.Circle);
            // circle.radius = 4;
            // circle.fill = am4core.color("#fff");
            // circle.strokeWidth = 3;

            // chart.legend = new am4charts.Legend();
        }

        am4core.ready(() => {
            console.log('am4core is ready')
            am4core.useTheme(am4themes_animated);

            codingActivity()
            durations()
        });
    </script>
@endpush