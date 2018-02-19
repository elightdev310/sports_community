@extends('sc.layouts.app')

@section('htmlheader_title')
{{ $league->name }}
@endsection

@section('page_id')league-members @endsection
@section('page_classes')league-members-page league-page @endsection

@section('content')

<div class="row">
  <div class="col-sm-3">
    @include('sc.comm.partials.league.league_page_menu')
  </div>
  <div class="col-sm-9">
    @include ('sc.comm.partials.league.league_page_header')

    @if ($currentUser && SCLeagueLib::isLeagueManager($currentUser->id, $league))
      @include ('sc.comm.partials.league.league_join_requests')
    @endif

    <div class="page-panel mt10">
      <div class="panel-header">
        <div class="panel-title">League Members</div>
      </div>
      <div class="panel-content">
        @if (count($members))
          <div class="league-member-list people-list-section row no-margin">
          @foreach ($members as $people) 
          <div class="col-md-6 no-padding">
            @include('sc.comm.partials.user.people_list_item')
          </div>
          @endforeach 
          </div>
        @else
          <div class="text-center p10">No member</div>
        @endif
      </div>
    </div>

  </div>
</div>
@endsection
