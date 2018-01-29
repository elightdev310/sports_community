@extends('sc.layouts.app')

@section('htmlheader_title')
Dashboard
@endsection

@section('page_id')dashboard @endsection
@section('page_classes')dashboard-page @endsection

@section('content')
  <div class="text-center pt30">
    <h2>Dashboard</h2>
    <p class="p10">
        <a href="{{ route('league.index') }}" class="">Leagues</a>
    </p>
    <p class="p30">
        <a href="/logout" class="btn btn-primary pl30 pr30">Log out</a>
    </p>
  </div>
@endsection
