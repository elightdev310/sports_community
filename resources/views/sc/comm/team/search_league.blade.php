@extends('sc.layouts.modal')

@section('htmlheader_title')
Search League
@endsection

@section('page_id')search-league-team @endsection
@section('page_classes')search-league-team-page search-league-page team-page @endsection

@section('content')
<div class="p10">
<div class="page-panel managed-leagues-section league-list-section" data-teamslug="{{ $team->slug }}">
  <div class="panel-header">
    {!! Form::open(['route'=>['team.league.search', $team->slug], 'method'=>'get', 'class'=>'search-box-section' ]) !!}
        <div class="input-group stylish-input-group">
            {!! Form::text('term', null, ['class'=>'form-control', 'placeholder'=>'Search league', 'autofocus'=>'']) !!}
            <span class="input-group-addon">
                <button class="search-btn" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    {!! Form::close() !!}
  </div>
  @if (isset($leagues))
  <div class="panel-content">
    @if( !count($leagues) )
      <div class="text-center p20 empty-data-message">
        No search result
      </div>
    @else
      <div class="league-list row no-margin">
        @foreach($leagues as $league)
        <div class="col-md-6 no-padding">
          @include('sc.comm.partials.team.league.team_league_list_item')
        </div>
        @endforeach
      </div>
    @endif
  </div>
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
