@extends('sc.layouts.app')

@section('htmlheader_title')
Profile
@endsection

@section('page_id')profile @endsection
@section('page_classes')profile-page @endsection

@section('content')
@include('sc.comm.profile.profile_header')

<div class="user-timeline-section mt10">
  @include('sc.comm.partials.timeline.timeline')
</div>

@endsection
