<?php

namespace App\Comment\ServiceProvider;

use Illuminate\Support\ServiceProvider;

use App\Comment\Controller\CommentController;
use App\Comment\Service\CommentService;
use App\Comment\Repository\CommentRepository;

use App\Authorization\Service\AuthorizationService;
use App\User\Repository\UserRepository;

use App\Comment\Transformer\CommentTransformer;

use App\Comment\Model\Comment;

class CommentProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Comment\Controller\CommentController', function($app) {
            return new CommentController($app->make('App\Comment\Service\CommentService'));
        });

        $this->app->bind(
            'App\Comment\Controller\CommentService', function($app) {
            return new CommentService($app->make('App\Comment\Repository\CommentRepository'),
                $app->make('App\Authorization\Service\AuthorizationService'),
                $app->make('App\User\Repository\UserRepository'),
                $app->make('App\Comment\Transformer\CommentTransformer')
            );
        });

        $this->app->bind(
            'App\Comment\Repository\CommentRepository', function($app) {
            return new CommentRepository($app->make('App\Comment\Model\Comment'));
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
