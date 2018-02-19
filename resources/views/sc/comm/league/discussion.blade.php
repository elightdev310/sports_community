@extends('sc.layouts.app')

@section('htmlheader_title')
{{ $league->name }}
@endsection

@section('page_id')league-discussion @endsection
@section('page_classes')league-discussion-page league-page @endsection

@section('content')

<div class="row">
  <div class="col-sm-3">
    @include('sc.comm.partials.league.league_page_menu')
  </div>
  <div class="col-sm-9">
    @include ('sc.comm.partials.league.league_page_header')

    <div class="league-timeline-section mt10">
      @include('sc.comm.partials.timeline.timeline')
    </div>
  </div>
</div>
@endsection
