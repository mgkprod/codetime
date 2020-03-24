<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CodeTime</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <div id="app">
        <main>
            <div class="row">
                <div class="offset-md-4 col-md-4 p-4">
                    <div class="card">
                        <div class="card-header">
                            <img src="/svg/logo.svg" alt="CodeTime" class="d-block mx-auto" style="width: 80%;">
                        </div>
                        <div class="card-body">
                            <h1>The developer dashboard</h1>

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
