<?php

return [

    'defaults' => [
        'guard' => 'admin',
        'passwords' => 'admin',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'client' => [
            'driver' => 'session',
            'provider' => 'clients',
        ]
    ],

    'providers' => [

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\AdminModel::class,
        ],
        'clients' => [
            'driver' => 'eloquent',
            'model' => App\Models\ClientModel::class,
        ]
    ],

    'passwords' => [
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'clients' => [
            'provider' => 'clients',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ]
    ],

    'password_timeout' => 10800,

];
