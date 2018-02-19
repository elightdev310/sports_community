@extends('sc.layouts.app')

@section('htmlheader_title')
{{ $league->name }}
@endsection

@section('page_id')individual-league @endsection
@section('page_classes')individual-league-page league-page @endsection

@section('content')

<div class="row">
  <div class="col-sm-3">
    @include('sc.comm.partials.league.league_page_menu')
  </div>
  <div class="col-sm-9">
    @include ('sc.comm.partials.league.league_page_header')
  </div>
</div>
@endsection
