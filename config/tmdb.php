<?php

return [

    'base_url' => 'https://api.themoviedb.org/3',

    'image_path' => 'https://image.tmdb.org/t/p/original',

    'api_token' => env('TMDB_API_TOKEN'),

    'client_options' => [
        'cache' => [
            'path' => storage_path('cache'),
        ],
        'log'   => [
            'enabled' => true,
            'path'    => storage_path('logs/tmdb_client.log')
        ]
    ]

];
