@extends('sc.layouts.app')

@section('htmlheader_title')
Friends
@endsection

@section('page_id')user-friends @endsection
@section('page_classes')profile-page @endsection

@section('content')
@include('sc.comm.profile.profile_header')
@if ($currentUser->id == $user->id)
@include('sc.comm.profile.friends.friends_sent_request_panel')
@endif
<div class="page-panel friends-wrapper mt10">
  <div class="panel-header">
    <div class="row">
      <div class="col-xs-6">
        <div class="panel-title"><i class="fa fa-users mr5" aria-hidden="true"></i>Friends</div>
      </div>
      @if ($currentUser->id == $user->id)
      <div class="col-xs-6">
        <div class="pull-right"><a href="{{ route('search.people') }}" class="btn btn-primary btn-flat find-friends">+ Find Friends</a></div>
      </div>
      @endif
    </div>
  </div>
  <div class="panel-content">
    <div class="p20 text-center">Coming Soon...</div>
  </div>
</div>

@endsection
