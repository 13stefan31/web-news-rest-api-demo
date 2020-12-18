<?php

namespace App\UserNotification\ServiceProvider;

use Illuminate\Support\ServiceProvider;

use App\UserNotification\Controller\UserNotificationController;

class UserNotificationProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $apiController = new UserNotificationController;

        $this->app->instance('App\UserNotification\Controller\UserNotificationController', $apiController);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Route/route.php');
    }
}
