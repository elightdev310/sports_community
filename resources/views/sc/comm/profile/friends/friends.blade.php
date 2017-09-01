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
  <div class="panel-content p10">
    @if (empty($friends))
    <div class="p20 text-center">No Friend</div>
    @else 
      <div class="friend-list row">
      @foreach($friends as $friend)
        <div class="col-sm-6">
        <div class="people-item clearfix">
          <div class="pull-left mr10">
            {!! SCUserLib::avatarImage($friend, 72) !!}
          </div>
          <div class="pull-left p5">
            <div class="user-name">
              <a href="{{ route('profile.index', ['user'=>$friend->id]) }}">{{ $friend->name }}</a>
            </div>
          </div>
          @if ($editable)
          <div class="pull-right p5">
              <button class="btn btn-info dropdown-toggle" type="button" id="dropdown-friendship-{{$friend->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user" aria-hidden="true"></i>&nbsp;Friend
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdown-friendship-{{$friend->id}}">
                <li><a href="#" data-url="{{ route('profile.friends.close_friendship.post', ['user'=>$friend->id]) }}" class="close-friendship">Close Friend</a></li>
              </ul>
            </div>
          </div>
          @endif
        </div>
        </div>
      @endforeach
      </div>
    @endif
  </div>
</div>

@endsection


@push('scripts')
<script>
$(function() {
  // Confirm Friend Request
  $('.friend-list .close-friendship').on('click', function() {
    var action_url = $(this).data('url');
    SCApp.Friend.doAction(action_url, 'close_friendship');
    return false;
  });
});
</script>
@endpush
