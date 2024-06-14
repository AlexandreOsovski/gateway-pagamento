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
        ],
        'affiliate' => [
            'driver' => 'session',
            'provider' => 'affiliates',
        ],
        'franchise' => [
            'driver' => 'session',
            'provider' => 'franchises',
        ],
    ],

    'providers' => [

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\AdminModel::class,
        ],
        'clients' => [
            'driver' => 'eloquent',
            'model' => App\Models\ClientModel::class,
        ],
        'affiliates' => [
            'driver' => 'eloquent',
            'model' => App\Models\AffiliateModel::class,
        ],
        'franchises' => [
            'driver' => 'eloquent',
            'model' => App\Models\FranchiseModel::class,
        ],
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
        ],
        'affiliates' => [
            'provider' => 'affiliates',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'franchises' => [
            'provider' => 'franchises',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];

