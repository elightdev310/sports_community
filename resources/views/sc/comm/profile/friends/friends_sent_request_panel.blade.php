<?php $sent_frs = SCUserLib::getSentFriendRequests($currentUser->id); ?>
@if (count($sent_frs))
  <div class="page-panel sent-request-friends-section mt10">
    <div class="panel-header">
      <strong>Sent Friend Requests.</strong>
    </div>
    <div class="panel-content p10 clearfix">
      <div class="fr-list row">
        @foreach ($sent_frs as $i_fr)
        <div class="col-sm-6">
          <div class="fr-item clearfix">
            <div class="pull-left mr10">
              {!! SCUserLib::avatarImage($i_fr->friend, 100) !!}
            </div>
            <div class="pull-left p5">
              <div class="user-name">
                <a href="{{ route('profile.index', ['user'=>$i_fr->friend_uid]) }}">{{ $i_fr->friend->name }}</a>
              </div>
              <div class="mt5">
                <div class="dropdown">
                  <button class="btn btn-info dropdown-toggle" type="button" id="dropdown-respond-fr" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sent Request
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdown-respond-fr">
                    <li><a href="#" data-url="{{ route('profile.friends.cancel_request.post', ['user'=>$i_fr->friend_uid]) }}" class="cancel-ifr-request">Cancel</a></li>
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
  // Reject Friend Request
  $('.sent-request-friends-section .cancel-ifr-request').on('click', function() {
    var action_url = $(this).data('url');
    SCApp.Friend.doAction(action_url, 'reject_request');
    return false;
  });
});
</script>
@endpush
