@if ($currentUser->id == $user->id)
  @include('sc.comm.profile.friends.friends_new_request_panel')
@else
  <?php $h_fr = SCUserLib::getFriendRequests($user->id); ?>
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
});
</script>
@endpush
