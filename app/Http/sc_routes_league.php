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

  Route::post('leagues/{league}/member-relationship', [
        'as' => 'league.member.relationship.post', 'uses' => 'SC\Comm\League\LeagueController@memberRelationshipAction' ]);

  Route::get('teams', [
        'as' => 'team.my_teams',        'uses' => 'SC\Comm\Team\TeamController@myTeamsPage' ]);
  Route::get('teams/create', [
        'as' => 'team.create',          'uses' => 'SC\Comm\Team\TeamController@createTeamPage' ]);
  Route::post('teams/create', [
        'as' => 'team.create.post',     'uses' => 'SC\Comm\Team\TeamController@createTeamAction' ]);
  Route::get('teams/search', [
        'as' => 'team.search',          'uses' => 'SC\Comm\Team\TeamController@searchTeamPage' ]);

  Route::post('teams/{team}/member-relationship', [
        'as' => 'team.member.relationship.post', 'uses' => 'SC\Comm\Team\TeamController@memberRelationshipAction' ]);
});

/**
 * League Page
 */
Route::group(['prefix' => 'leagues/{slug}'], function () {
  $as_league = 'league.';
  Route::get('/', [
    'as' => $as_league.'page',        'uses' => 'SC\Comm\League\LeagueController@leaguePage' ]);
  Route::get('/discussion', [
    'as' => $as_league.'discussion',  'uses' => 'SC\Comm\League\LeagueController@leagueDiscussionPage' ]);
  Route::get('/members', [
    'as' => $as_league.'members',     'uses' => 'SC\Comm\League\LeagueController@leagueMembersPage' ]);
  Route::get('/teams', [
    'as' => $as_league.'teams',       'uses' => 'SC\Comm\League\LeagueController@leagueTeamsPage' ]);
});

/**
 * Team Page
 */
Route::group(['prefix' => 'teams/{slug}'], function () {
  $as_team = 'team.';
  Route::get('/', [
    'as' => $as_team.'page',      'uses' => 'SC\Comm\Team\TeamController@teamPage' ]);
  Route::get('/discussion', [
    'as' => $as_team.'discussion','uses' => 'SC\Comm\Team\TeamController@teamDiscussionPage' ]);
  Route::get('/members', [
    'as' => $as_team.'members',   'uses' => 'SC\Comm\Team\TeamController@teamMembersPage' ]);
  Route::get('/leagues', [
    'as' => $as_team.'leagues',   'uses' => 'SC\Comm\Team\TeamController@teamLeaguesPage' ]);
  Route::get('/leagues/search', [
    'as' => $as_team.'league.search', 	'uses' => 'SC\Comm\Team\TeamController@teamSearchLeaguePage' ]);

	Route::post('/leagues/{league}/relationship', [
		'as' => $as_team.'league.relationshiop.post', 	'uses' => 'SC\Comm\Team\TeamController@teamLeagueRelationshipAction']);
});
