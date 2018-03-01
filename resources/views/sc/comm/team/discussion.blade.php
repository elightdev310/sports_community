@extends('sc.layouts.team.team')

@section('htmlheader_title')
{{ $team->name }}
@endsection

@section('page_id')team-discussion @endsection
@section('page_classes')team-discussion-page @endsection

@section('content')

  <div class="team-timeline-section mt10">
    @include('sc.comm.partials.timeline.timeline')
  </div>
  
@endsection
