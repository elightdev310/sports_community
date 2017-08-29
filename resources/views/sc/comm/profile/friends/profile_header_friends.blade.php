<?php $h_fr = SCUserLib::getFriendRequests($user->id); ?>

@if ($currentUser->id == $user->id)
  @if (count($h_fr))
    <div class="page-panel profile-header-friends-section mt10">
      <div class="panel-header">
        <strong>You received Friend Requests.</strong>
      </div>
      <div class="panel-content p10 clearfix">
        <div class="fr-list row">
          @foreach ($h_fr as $i_fr)
          <div class="col-sm-6">
            <div class="fr-item clearfix">
              <div class="pull-left mr10">
                {!! SCUserLib::avatarImage($i_fr->user, 100) !!}
              </div>
              <div class="pull-left p5">
                <div class="user-name">
                  <a href="{{ route('profile.index', ['user'=>$i_fr->user_id]) }}">{{ $i_fr->user->name }}</a>
                </div>
                <div class="mt5">
                  <div class="dropdown">
                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdown-respond-fr" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Respond
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdown-respond-fr">
                      <li><a href="#" data-url="{{ route('profile.friends.confirm_request.post', ['user'=>$i_fr->user_id]) }}" class="confirm-ifr-request">Confirm</a></li>
                      <li><a href="#" data-url="{{ route('profile.friends.reject_request.post', ['user'=>$i_fr->user_id]) }}" class="reject-ifr-request">Reject</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  @endif
@else
  <div class="page-panel profile-header-friends-section mt10">
    <div class="panel-header">
      <strong>Do you know {{ $user->name }}?</strong>
    </div>
    <div class="panel-content p10 clearfix">
      @if (empty($h_fr))
        <a href="#" class="send-fr-request pull-left p5">Send friend request</a>
        <a href="#" class="btn btn-primary pull-right send-fr-request">Add Friend</a>
      @elseif ($h_fr->user_id == $currentUser->id)
        <span class="pull-left p5">You have already sent a friend request.</span>
        <a href="#" class="btn btn-warning pull-right cancel-fr-request">Cancel Friend Request</a>
      @elseif ($h_fr->user_id == $user->id)
        <span class="pull-left p5">{{ $user->name }} sent you a friend request. 
          <a href="#" class="confirm-fr-request">Confirm friend request.</a>
        </span>
        <div class="dropdown pull-right">
          <button class="btn btn-info dropdown-toggle" type="button" id="dropdown-respond-fr" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Respond Friend Request
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdown-respond-fr">
            <li><a href="#" class="confirm-fr-request">Confirm</a></li>
            <li><a href="#" class="reject-fr-request">Reject</a></li>
          </ul>
        </div>

      @endif
    </div>
  </div>
@endif


@push('scripts')
<script>
$(function() {
  // Send Friend Request
  $('.profile-header-friends-section .send-fr-request').on('click', function() {
    var action_url = '{{ route('profile.friends.send_request.post', ['user'=>$user->id]) }}';
    SCApp.Friend.doAction(action_url, 'send_request');
    return false;
  });
  // Cancel Friend Request
  $('.profile-header-friends-section .cancel-fr-request').on('click', function() {
    var action_url = '{{ route('profile.friends.cancel_request.post', ['user'=>$user->id]) }}';
    SCApp.Friend.doAction(action_url, 'cancel_request');
    return false;
  });

  // Confirm Friend Request
  $('.profile-header-friends-section .confirm-fr-request').on('click', function() {
    var action_url = '{{ route('profile.friends.confirm_request.post', ['user'=>$user->id]) }}';
    SCApp.Friend.doAction(action_url, 'confirm_request');
    return false;
  });
  // Reject Friend Request
  $('.profile-header-friends-section .reject-fr-request').on('click', function() {
    var action_url = '{{ route('profile.friends.reject_request.post', ['user'=>$user->id]) }}';
    SCApp.Friend.doAction(action_url, 'reject_request');
    return false;
  });

  // Confirm Friend Request
  $('.profile-header-friends-section .confirm-ifr-request').on('click', function() {
    var action_url = $(this).data('url');
    SCApp.Friend.doAction(action_url, 'confirm_request');
    return false;
  });
  // Reject Friend Request
  $('.profile-header-friends-section .reject-ifr-request').on('click', function() {
    var action_url = $(this).data('url');
    SCApp.Friend.doAction(action_url, 'reject_request');
    return false;
  });

});
</script>
@endpush
