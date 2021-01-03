<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>
</head>
<body class="antialiased">
    @if( session('username') )
        <h1>Hello, {{ session('username') }}</h1>

        @include('partials/menu')
    @else
        <h1>Login</h1>

        <form action="/login" method="post">
            @csrf
            <input hidden id="username" name="username" type="text" value="Dominik">
            <button type="submit">Dominik</button>
        </form>

        <form action="/login" method="post">
            @csrf
            <input hidden id="username" name="username" type="text" value="Kathi">
            <button type="submit">Kathi</button>
        </form>
    @endif
</body>
</html>
