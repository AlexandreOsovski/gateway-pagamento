<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\{
    ClientModel,
    KeysApiModel,
    MovementModel,
    NotificationModel,
    TransactionModel,
    TransferUserToUserModel,
};
use App\Repositories\{
    ClientRepository,
    KeysApiRepository,
    MovementRepository,
    TransactionRepository,
    NotificationRepository,
};


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

        $this->app->bind('App\Repositories\KeysApiRepository', function () {
            return new KeysApiRepository(new KeysApiModel());
        });

        $this->app->bind('App\Repositories\MovementRepository', function () {
            return new MovementRepository(new MovementModel());
        });

        $this->app->bind('App\Repositories\TransactionRepository', function () {
            return new TransactionRepository(new TransactionModel());
        });

        $this->app->bind('App\Repositories\NotificationRepository', function () {
            return new NotificationRepository(new NotificationModel());
        });

        // $this->app->bind('App\Repositories\', function () {
        //     return new Repository(new Model());
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
