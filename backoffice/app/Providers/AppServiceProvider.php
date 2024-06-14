<?php

namespace App\Providers;

use App\Models\ClientModel;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ClientRepository;
use App\Repositories\Interfaces\ClientInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('App\Repositories\ClientRepository', function () {
            return new ClientRepository(new ClientModel());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
