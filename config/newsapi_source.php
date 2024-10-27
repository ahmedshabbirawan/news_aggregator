<?php
return [
    'newsapi'   => [
        'name' => 'News Api Org',
        'api_url' => 'https://newsapi.org/v2/top-headlines',
        'api_key' => env('NEWSAPI_API_KEY', 'ab8038e05e6b4ef9b984df26d86baffa'),
        'options' => [
            'verify' => false,
            'timeout' => 30,
        ],
    ],
    'newyorktimes'   => [
        'api_url'   => 'https://api.nytimes.com/svc/search/v2/articlesearch.json',
        'api_key'   => env('NY_TIME_NEWS_API_KEY', 'HVX5xqobJ8I1wpGA1URWM4byWiFQblmF'),
        'api_parameter_name'=> 'api-key',
    ]
];
