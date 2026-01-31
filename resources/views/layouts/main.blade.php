<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="theme-color" content="#2E7D32">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }} - APPS Penyuluhan</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css?v=1.3') }}">
    </head>

    <body class="font-sans antialiased safe-top-area">
    
        @if(!View::hasSection('no-navigation'))
            @include('layouts.navigation')
        @endif

        @yield('content')

        @stack('scripts')

  </body>
</html>
