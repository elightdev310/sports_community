@extends('sc.layouts.app')

@section('htmlheader_title')
{{ $team->name }}
@endsection

@section('page_id')individual-team @endsection
@section('page_classes')individual-team-page team-page @endsection

@section('content')
<h2>{{ $team->name }}</h2>
@endsection
