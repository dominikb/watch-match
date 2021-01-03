<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Movie</title>

    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
</head>
<body class="antialiased">

    @foreach($posterPaths as $path)
        <img src="{{$path}}" alt="Movie poster" width="300px">
    @endforeach
</body>
</html>
