<?php

return [

    'default' => env('BROADCAST_DRIVER', 'pusher'),

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
                // Jika kamu pakai Laravel Websockets lokal, bisa ubah ini:
                // 'host' => '127.0.0.1',
                // 'port' => 6001,
                // 'scheme' => 'http',
                // 'useTLS' => false,
            ],
        ],

        'ably' => [
            'driver' => 'ably',
            'key' => env('ABLY_KEY'),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],
        'sync' => [
            'driver' => 'sync',
        ],
    ],

    'middleware' => [
        'web',
        // 'auth:api', // tambahkan jika kamu ingin autentikasi untuk channel privat
    ],
];
