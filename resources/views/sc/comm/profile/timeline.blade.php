@extends('sc.layouts.app')

@section('htmlheader_title')
Profile
@endsection

@section('page_id')profile @endsection
@section('page_classes')profile-page @endsection

@section('content')
@include('sc.comm.profile.profile_header')
@endsection
