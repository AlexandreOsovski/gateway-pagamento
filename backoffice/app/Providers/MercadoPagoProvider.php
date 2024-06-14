<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use MercadoPago\Item;
Use MercadoPago\Client\Preference;
use MercadoPago\SDK;

class MercadoPagoProvider extends ServiceProvider
{

    public $public_token = 'APP_USR-2ad8353e-bcc3-4541-8361-9d7128d9ce8e';
    public $acess_token = 'APP_USR-3081233358446002-093010-83898e5207760231015ac91b5a352e46-1464096816';
    public $client_id = '3081233358446002';
    public $client_secret = 'x4gMK5TIr7xlEYngAP99yOFXL5PlHNBP';

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
