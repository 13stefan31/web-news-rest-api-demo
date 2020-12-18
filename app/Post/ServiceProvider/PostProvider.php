<?php

namespace App\Post\ServiceProvider;

use Illuminate\Support\ServiceProvider;

use App\Post\Controller\PostController;
use App\Post\Service\PostService;
use App\Post\Repository\PostRepository;
use App\Comment\Service\CommentService;
use App\PostCategory\Repository\PostCategoryRepository;

class PostProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Post\Controller\PostController', function($app) {
            return new PostController($app->make('App\Post\Service\PostService'));
        });

        $this->app->bind(
            'App\Post\Service\PostService', function($app) {
            return new PostService($app->make('App\Post\Repository\PostRepository'),
                $app->make('App\Authorization\Service\AuthorizationService'),
                $app->make('App\Post\Transformer\PostTransformer'),
                $app->make('App\Comment\Service\CommentService'),
                $app->make('App\PostCategory\Repository\PostCategoryRepository')
            );
        });

        $this->app->bind(
            'App\Post\Repository\PostRepository', function($app) {
            return new PostRepository($app->make('App\Post\Model\Post'));
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
