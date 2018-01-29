<?php

Route::group(['middleware' => ['auth']], 
            function () {

  Route::get('leagues', [
        'as' => 'league.index', 'uses' => 'SC\Comm\League\LeagueController@myLeaguesPage' ]);
  Route::get('leagues/create', [
        'as' => 'league.create', 'uses' => 'SC\Comm\League\LeagueController@createLeaguePage' ]);
  Route::post('leagues/create', [
        'as' => 'league.create.post', 'uses' => 'SC\Comm\League\LeagueController@createLeagueAction' ]);

});
