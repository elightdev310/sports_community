<div class="people-item m10">
  <table class="table">
    <tr>
      <td>
        <div class="cover-photo-thumb pull-left">
          {!! SCUserLib::avatarImage($people, 72) !!}
        </div>
        <div class="user-name">
          <div class="mt5">
            <a href="{{ route('profile.index', ['user'=>$people->id]) }}">{{ $people->name }}</a>
          </div>
        </div>
      </td>
      <td class="people-action pull-right">
        @if ($currentUser->id == $people->id)

        @elseif (SCUserLib::isFriend($currentUser->id, $people->id))
        @elseif (SCUserLib::isFriendRequest($currentUser->id, $people->id)>0)
          <div class="dropdown">
            <button class="btn btn-info dropdown-toggle" type="button" id="dropdown-sent-respond-fr" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Request sent
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdown-sent-respond-fr">
              <li><a href="#" data-url="{{ route('profile.friends.cancel_request.post', ['user'=>$people->id]) }}" class="cancel-ifr-request">Cancel</a></li>
            </ul>
          </div>
        @elseif (SCUserLib::isFriendRequest($currentUser->id, $people->id)<0)
          <div class="dropdown">
            <button class="btn btn-info dropdown-toggle" type="button" id="dropdown-new-respond-fr" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Respond to Friend Request
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdown-new-respond-fr">
              <li><a href="#" data-url="{{ route('profile.friends.confirm_request.post', ['user'=>$people->id]) }}" class="confirm-ifr-request">Confirm</a></li>
              <li><a href="#" data-url="{{ route('profile.friends.reject_request.post', ['user'=>$people->id]) }}" class="reject-ifr-request">Reject</a></li>
            </ul>
          </div>
        @else
          <a href="#" data-url="{{ route('profile.friends.send_request.post', ['user'=>$people->id]) }}" class="btn btn-primary send-ifr-request">Add Friend</a>
        @endif
      </td>
    </tr>
  </table>
</div>
