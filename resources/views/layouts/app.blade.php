<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>WatchMatch</title>

        <link href="{{ mix('css/settings.css') }}" rel="stylesheet">
        <link href="{{ mix('css/default.css') }}" rel="stylesheet">
        <link href="{{ mix('css/navigation.css') }}" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Major+Mono+Display&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Major+Mono+Display&family=Open+Sans&display=swap" rel="stylesheet">
    </head>
    <body>
        <div><a href="/logout">Logout</a></div>
        <main>
            @yield('content')
        </main>
        @include('partials/menu')
    </body>
</html>