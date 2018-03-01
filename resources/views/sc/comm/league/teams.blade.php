@extends('sc.layouts.league.league')

@section('htmlheader_title')
{{ $league->name }}
@endsection

@section('page_id')league-teams @endsection
@section('page_classes')league-teams-page @endsection

@section('content')

  @if ($currentUser && SCLeagueLib::isLeagueManager($currentUser->id, $league))
    @include ('sc.comm.partials.league.league_join_team_requests')
  @endif

  <div class="page-panel mt10">
    <div class="panel-header">
      <div class="panel-title">League Teams</div>
    </div>
    <div class="panel-content">
      @if (count($teams))
        <div class="league-team-list team-list-section row no-margin">
        @foreach ($teams as $team) 
        <div class="col-md-6 no-padding">
          @include('sc.comm.partials.team.team_list_item')
        </div>
        @endforeach 
        </div>
      @else
        <div class="text-center p10">No team</div>
      @endif
    </div>
  </div>
  
@endsection
