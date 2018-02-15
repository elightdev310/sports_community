@extends('sc.layouts.app')

@section('htmlheader_title')
{{ $team->name }}
@endsection

@section('page_id')team-members @endsection
@section('page_classes')team-members-page team-page @endsection

@section('content')

<div class="row">
  <div class="col-sm-3">
    @include('sc.comm.partials.team.team_page_menu')
  </div>
  <div class="col-sm-9">
    @include ('sc.comm.partials.team.team_page_header')

    @if ($currentUser && SCTeamLib::isTeamManager($currentUser->id, $team))
      @include ('sc.comm.partials.team.team_join_requests')
    @endif

    <div class="page-panel mt10">
      <div class="panel-header">
        <div class="panel-title">Team Members</div>
      </div>
      <div class="panel-content">
        @if (count($members))
          <div class="team-member-list people-list-section row no-margin">
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
