<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

use App\SC\Libs\UserLib;
use App\SC\Libs\PhotoLib;
use App\SC\Libs\PostLib;
use App\SC\Libs\League\LeagueLib;
use App\SC\Libs\League\SeasonLib;
use App\SC\Libs\League\DivisionLib;
use App\SC\Libs\League\Division_TeamLib;

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
        $this->app->bind('scpost', function ($app) {
            return new PostLib($app);
        });

        // League
        $this->app->bind('scleague_league', function ($app) {
            return new LeagueLib($app);
        });
        $this->app->bind('scleague_season', function ($app) {
            return new SeasonLib($app);
        });
        $this->app->bind('scleague_division', function ($app) {
            return new DivisionLib($app);
        });
        $this->app->bind('scleague_division_team', function ($app) {
            return new Division_TeamLib($app);
        });



        //
        $loader = AliasLoader::getInstance();
        $loader->alias('SCHelper', \App\SC\Helpers\SCHelper::class);
        
        $loader->alias('SCUserLib',   \App\SC\Facades\UserFacade::class);
        $loader->alias('SCPhotoLib',  \App\SC\Facades\PhotoFacade::class);
        $loader->alias('SCPostLib',   \App\SC\Facades\PostFacade::class);

        // League
        $loader->alias('SCLeagueLib',       \App\SC\Facades\League\LeagueFacade::class);
        $loader->alias('SCSeasonLib',       \App\SC\Facades\League\SeasonFacade::class);
        $loader->alias('SCDivisionLib',     \App\SC\Facades\League\DivisionFacade::class);
        $loader->alias('SCDivision_TeamLib',\App\SC\Facades\League\Division_TeamFacade::class);
    }
}
