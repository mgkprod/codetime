@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="mb-4 col-md-12">
            <div class="card">
                <div class="card-header">WakaTime config file</div>
                <div class="card-body">
                    <p>CodeTime relies on WakaTime plugins to retrieve code statistics.</p>
                    <p>
                        In order to connect the plugins, you must specify a custom server in the global configuration file.<br>
                        This file is usually located in your user folder :
                    </p>
                    <ul>
                        <li><code>C:\Users\{username}\.wakatime.cfg</code> on Windows</li>
                        <li><code>/home/{username}/.wakatime.cfg</code> on Linux</li>
                    </ul>

                    <p>Put the following in your <code>.wakatime.cfg</code> file.</p>
                    <pre>{{ $wakacfg }}</pre>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection