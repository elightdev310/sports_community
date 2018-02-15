@extends('sc.layouts.app')

@section('htmlheader_title')
{{ $team->name }}
@endsection

@section('page_id')individual-team @endsection
@section('page_classes')individual-team-page team-page @endsection

@section('content')

<div class="row">
  <div class="col-sm-3">
    @include('sc.comm.partials.team.team_page_menu')
  </div>
  <div class="col-sm-9">
    @include ('sc.comm.partials.team.team_page_header')
  </div>
</div>
@endsection