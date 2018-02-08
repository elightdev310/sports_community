<?php

Route::group(['middleware' => ['auth']], 
            function () {

  Route::get('leagues', [
        'as' => 'league.my_leagues',    'uses' => 'SC\Comm\League\LeagueController@myLeaguesPage' ]);
  Route::get('leagues/create', [
        'as' => 'league.create',        'uses' => 'SC\Comm\League\LeagueController@createLeaguePage' ]);
  Route::post('leagues/create', [
        'as' => 'league.create.post',   'uses' => 'SC\Comm\League\LeagueController@createLeagueAction' ]);
  Route::get('leagues/search', [
        'as' => 'league.search',        'uses' => 'SC\Comm\League\LeagueController@searchLeaguePage' ]);

  Route::get('leagues/{slug}', [
        'as' => 'league.page', 'uses' => 'SC\Comm\League\LeagueController@leaguePage' ]);


  Route::get('teams', [
        'as' => 'team.my_teams',        'uses' => 'SC\Comm\Team\TeamController@myTeamsPage' ]);
  Route::get('teams/create', [
        'as' => 'team.create',          'uses' => 'SC\Comm\Team\TeamController@createTeamPage' ]);
  Route::post('teams/create', [
        'as' => 'team.create.post',     'uses' => 'SC\Comm\Team\TeamController@createTeamAction' ]);
  Route::get('teams/search', [
        'as' => 'team.search',          'uses' => 'SC\Comm\Team\TeamController@searchTeamPage' ]);

  Route::group(['prefix' => 'teams/{slug}'], function () {
    $as_team = 'team.';
    Route::get('/', [
      'as' => $as_team.'page',        'uses' => 'SC\Comm\Team\TeamController@teamPage' ]);
    Route::get('/discussion', [
      'as' => $as_team.'discussion',  'uses' => 'SC\Comm\Team\TeamController@teamDiscussionPage' ]);
  });

  

  Route::post('teams/{team}/member-relationship', [
        'as' => 'team.member.relationship.post', 'uses' => 'SC\Comm\Team\TeamController@memberRelationshipAction' ]);
});
