@extends('sc.layouts.app')

@section('htmlheader_title')
Basic Information
@endsection

@section('page_id')profile-about-education @endsection
@section('page_classes')about-education-page profile-about-page profile-page @endsection

@section('content')
@include('sc.comm.profile.profile_header')

<div class="page-panel about-wrapper mt10">
  <div class="panel-header">
    <div class="row">
      <div class="col-xs-6"><div class="panel-title"><i class="fa fa-user mr5" aria-hidden="true"></i>About</div></div>
    </div>
  </div>
  <div class="panel-content">
    <div class="row">
      <div class="col-sm-4 col-md-3">
        <div class="about-left-sidebar p10">
          @include('sc.comm.profile.about_left')
        </div>
      </div>
      <div class="col-sm-8 col-md-9">
        <div class="about-content-section clearfix p20">
          Coming Soon...
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
