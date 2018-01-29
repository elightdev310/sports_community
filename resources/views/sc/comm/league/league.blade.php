@extends('sc.layouts.app')

@section('htmlheader_title')
{{ $league->name }}
@endsection

@section('page_id')individual-league @endsection
@section('page_classes')individual-league-page league-page @endsection

@section('content')
<h2>{{ $league->name }}</h2>
@endsection
