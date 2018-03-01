@extends('sc.layouts.team.team')

@section('htmlheader_title')
{{ $team->name }}
@endsection

@section('page_id')team-leaques @endsection
@section('page_classes')team-leaques-page @endsection

@section('content')

  @if ($currentUser && SCTeamLib::isTeamManager($currentUser->id, $team))
    <div class="clearfix mt10">
      <a class="btn-search-league btn btn-primary btn-flat emodal-iframe pull-right"
          data-url="{{ route('team.league.search', ['slug'=>$team->slug]) }}" 
          data-title="Search League for Team" data-size="md">
        Search League for Team
      </a>
    </div>

    {{--  Requests to join league  --}}
    @if (count($requests))
    <div class="page-panel mt10">
      <div class="panel-header">
        <div class="panel-title">Requests to join League</div>
      </div>
      <div class="panel-content">
        <div class="team-league-list league-list-section row no-margin" data-teamslug="{{ $team->slug }}">
          @foreach ($requests as $league) 
            <div class="col-md-6 no-padding">
              @include('sc.comm.partials.team.league.team_league_list_item')
            </div>
          @endforeach 
        </div>
      </div>
    </div>
    @endif
  @endif

  {{--  Joined leagues  --}}
  <div class="page-panel mt10">
    <div class="panel-header">
      <div class="panel-title">Joined Leagues</div>
    </div>
    <div class="panel-content">
      @if (count($leagues))
        <div class="team-league-list league-list-section row no-margin" data-teamslug="{{ $team->slug }}">
          @foreach ($leagues as $league) 
            <div class="col-md-6 no-padding">
              @include('sc.comm.partials.team.league.team_league_list_item')
            </div>
          @endforeach 
        </div>
      @else
        <div class="text-center p10">No Joined Leagues</div>
      @endif
    </div>
  </div>

@endsection

@push('scripts')
<script>
$(function () {
  $(document).ready(function() {
    SCApp.Team.bindTeamLeagueList();
  });
});
</script>
@endpush