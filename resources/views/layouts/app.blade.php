<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

        <meta name="author" content="Dominik Bauernfeind & Katharina Schatz">
        <meta name="description" content="Gemeinsam Netflix Filme und Serien aussuchen und filtern">
        <meta name="keywords" content="Netflix Serien Filme Watchlist Matches Like">

        <meta content="WatchMatch" property="og:title">
        <meta content="Gemeinsam Netflix Filme und Serien aussuchen und filtern" property="og:description">
        <meta content="{{ asset('img/socialmedia_logo.png') }}" property="og:image">
        <meta content="1200" property="og:image:width">
        <meta content="630" property="og:image:height">

        <meta content="#07e0db" name="theme-color">
        <meta content="#07e0db" name="msapplication-TileColor">
        <meta content="#07e0db" name="apple-mobile-web-app-status-bar-style">

        <meta content="{{ asset('img/company_icon.png') }}" name="msapplication-TileImage">
        <link href="{{ asset('img/company_icon.png') }}" rel="apple-touch-icon">

        <title>WatchMatch</title>

        <link rel="stylesheet" href="{{ asset('css/main.css') }}">

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Major+Mono+Display&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Major+Mono+Display&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

        <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">

    </head>
    <body>

        @include('partials/logout')

        <main>
            @yield('content')
        </main>

        @include('partials/menu')

        <script src="{{ asset('js/script.js')}}"></script>
    </body>
</html>
