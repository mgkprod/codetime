@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">Coding activity</div>
                <div class="card-body p-0">
                    <canvas id="coding-activity" class="w-100" style="height: 500px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script src="https://www.chartjs.org/dist/2.9.4/Chart.min.js"></script>
    <script src="https://momentjs.com/downloads/moment.min.js"></script>

    <script>
        function codingActivity() {
            @php $codingActivity = \App\Helpers\GraphBuilder::codingActivity($codingActivity); @endphp

            let labels = @json($codingActivity['labels']);
            let datasets = @json($codingActivity['datasets']);
            let ctx = document.getElementById('coding-activity').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: { labels, datasets },
                options: {
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                if (tooltipItem.yLabel == 0) return;

                                let label = data.datasets[tooltipItem.datasetIndex].label || '';
                                label += ': ' + secondsToHms(tooltipItem.yLabel);

                                return label;
                            }
                        }
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{ stacked: true }],
                        yAxes: [{
                            stacked: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return secondsToH(value);
                                }
                            }
                        }],
                    }
                }
            });
        }

        function durations() {
            // var chart = am4core.create("durations", am4charts.XYChart);

            // // Add data
            // @php
            //     $durations = \App\Helpers\GraphBuilder::durations($durations);
            // @endphp

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

        codingActivity()
        durations()

        function secondsToH(d) {
            var h = moment("1900-01-01 00:00:00").add(d, 'seconds').format("HH")
            return h + 'h';
        }

        function secondsToHms(d) {
            var d = moment("1900-01-01 00:00:00").add(d, 'seconds').format("HH:mm:ss")
            return d;
        }
    </script>
@endpush