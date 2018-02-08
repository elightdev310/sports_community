@extends('sc.layouts.app')

@section('htmlheader_title')
{{ $team->name }}
@endsection

@section('page_id')team-discussion @endsection
@section('page_classes')team-discussion-page team-page @endsection

@section('content')

<div class="row">
  <div class="col-sm-3">
    @include('sc.comm.partials.team.team_page_menu')
  </div>
  <div class="col-sm-9">
    @include ('sc.comm.partials.team.team_page_header')

    <div class="team-timeline-section mt10">
      @include('sc.comm.partials.timeline.timeline')
    </div>
  </div>
</div>
@endsection
