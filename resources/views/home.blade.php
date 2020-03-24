@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Coding activity</div>
                <div class="card-body p-0">
                    @foreach ($coding_activity as $activity)
                        <div class="p-3">
                            @if ($activity['project'])
                                Project: <a href="#">{{ $activity['project'] }}</a><br>
                            @else
                                <a href="#">Unknown project</a><br>
                            @endif
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
                <div class="card-header">Categories used</div>
                <div class="card-body"></div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Durations</div>
                <div class="card-body"></div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Daily average</div>
                <div class="card-body"></div>
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
        </div>
    </div>
</div>
@endsection
