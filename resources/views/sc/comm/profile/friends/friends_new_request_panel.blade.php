<?php $new_frs = SCUserLib::getFriendRequests($currentUser->id); ?>
@if (count($new_frs))
  <div class="page-panel new-friends-request-section mt10">
    <div class="panel-header">
      <strong>New Friend Requests.</strong>
    </div>
    <div class="panel-content p10 clearfix">
      <div class="fr-list row">
        @foreach ($new_frs as $i_fr)
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
                  <button class="btn btn-info dropdown-toggle" type="button" id="dropdown-new-respond-fr" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Respond Request
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdown-new-respond-fr">
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

@push('scripts')
<script>
$(function() {
  // Confirm Friend Request
  $('.new-friends-request-section .confirm-ifr-request').on('click', function() {
    var action_url = $(this).data('url');
    SCApp.Friend.doAction(action_url, 'confirm_request');
    return false;
  });
  // Reject Friend Request
  $('.new-friends-request-section .reject-ifr-request').on('click', function() {
    var action_url = $(this).data('url');
    SCApp.Friend.doAction(action_url, 'reject_request');
    return false;
  });
});
</script>
@endpush
