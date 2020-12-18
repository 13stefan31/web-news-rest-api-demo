<?php

namespace App\User\ServiceProvider;

use Illuminate\Support\ServiceProvider;

use App\User\Controller\UserController;
use App\User\Service\UserService;
use App\User\Repository\UserRepository;

class UserProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\User\Controller\UserController', function($app) {
            return new UserController($app->make('App\User\Service\UserService'));
        });

        $this->app->bind(
            'App\User\Service\UserService', function($app) {
            return new UserService($app->make('App\User\Repository\UserRepository'),
                $app->make('App\User\Transformer\UserTransformer'),
            );
        });

        $this->app->bind(
            'App\User\Repository\UserRepository', function($app) {
            return new UserRepository($app->make('App\User\Model\User'));
        });
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
