<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

use App\SC\Libs\UserLib;
use App\SC\Libs\PhotoLib;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('*', function($view){
            $currentUser = \Auth::user();

            $view->with('currentUser', $currentUser);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('scuser', function ($app) {
            return new UserLib($app);
        });
        $this->app->bind('scphoto', function ($app) {
            return new PhotoLib($app);
        });

        //
        $loader = AliasLoader::getInstance();
        $loader->alias('SCHelper', \App\SC\Helpers\SCHelper::class);
        
        $loader->alias('SCUserLib', \App\SC\Facades\UserFacade::class);
        $loader->alias('SCPhotoLib', \App\SC\Facades\PhotoFacade::class);
    }
}
