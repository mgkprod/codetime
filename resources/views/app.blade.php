<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>codetracker█</title>

        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
        <link href="https://fonts.googleapis.com/css2?family=Tomorrow:wght@400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />

        <script src="https://www.chartjs.org/dist/2.9.4/Chart.min.js"></script>
        <script src="{{ mix('/js/app.js') }}" defer></script>

        @routes
    </head>
    <body class="flex flex-col h-full min-h-screen antialiased transition duration-200 bg-gradient-to-b from-[#1B1C31] to-[#24263D] text-[#999CB3]">
        <div class="absolute top-0 left-0 right-0 w-auto -z-10">
            <svg class="w-full" viewBox="0 0 1440 600" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M1440 0H0V600L1440 0Z" fill="#1B1C31"/>
            </svg>
        </div>

        @inertia
    </body>
</html>
