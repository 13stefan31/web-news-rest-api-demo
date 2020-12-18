<?php

namespace App\PostCategory\ServiceProvider;

use App\PostCategory\Controller\PostCategoryController;
use App\PostCategory\Repository\PostCategoryRepository;
use App\PostCategory\Service\PostCategoryService;
use Illuminate\Support\ServiceProvider;

class PostCategoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\PostCategory\Controller\PostCategoryController', function($app) {
            return new PostCategoryController($app->make('App\PostCategory\Service\PostCategoryService'));
        });

        $this->app->bind(
            'App\PostCategory\Service\PostCategoryService', function($app) {
            return new PostCategoryService($app->make('App\PostCategory\Repository\PostCategoryRepository'),
                $app->make('App\PostCategory\Transformer\PostCategoryTransformer'),
            );
        });

        $this->app->bind(
            'App\PostCategory\Repository\PostCategoryRepository', function($app) {
            return new PostCategoryRepository($app->make('App\PostCategory\Model\PostCategory'));
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
