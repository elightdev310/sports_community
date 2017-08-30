@extends('sc.layouts.app')

@section('htmlheader_title')
People
@endsection

@section('page_id')search-people @endsection
@section('page_classes')search-people-page search-page @endsection

@section('content')
<div class="search-people-wrapper">
  <div class="page-panel search-people-filter mt10">
    <div class="panel-content p10">
      {!! Form::open(['route'=>['search.people'], 'method'=>'get', 'class'=>'' ]) !!}
        <div class="form-group has-feedback row mt10">
          <div class="col-xs-12">
            <div class="input-group stylish-input-group">
                {!! Form::text('q', $query, ['class'=>'form-control', 'placeholder'=>'Search People']) !!}
                <span class="input-group-addon">
                    <button type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>  
                </span>
            </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

  @if(empty($no_query))
  <div class="page-panel search-people-result mt10">
    <div class="panel-content p10">
      @if (count($result))
        <div class="search-people-list">
        @foreach ($result as $people) 
          <div class="people-item clearfix">
            <div class="pull-left mr10">
              {!! SCUserLib::avatarImage($people, 72) !!}
            </div>
            <div class="pull-left p5">
              <div class="user-name">
                <a href="{{ route('profile.index', ['user'=>$people->id]) }}">{{ $people->name }}</a>
              </div>
            </div>
            <div class="pull-right ml5 mt5">
              @if ($currentUser->id == $people->id)
              @elseif (SCUserLib::isFriend($currentUser->id, $people->id))
              @elseif (SCUserLib::isFriendRequest($currentUser->id, $people->id)>0)
                <div class="dropdown">
                  <button class="btn btn-info dropdown-toggle" type="button" id="dropdown-sent-respond-fr" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sent Request
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
            </div>
          </div>
        @endforeach 
        </div>
      @else
        <div class="text-center p10">No Result</div>
      @endif
    </div>
  </div>
  @endif

</div>
@endsection

@push('scripts')
<script>
$(function () {
  // Send Friend Request
  $('.search-people-list .send-ifr-request').on('click', function() {
    var action_url = $(this).data('url');
    SCApp.Friend.doAction(action_url, 'send_request');
    return false;
  });
  // Reject Friend Request
  $('.search-people-list .cancel-ifr-request').on('click', function() {
    var action_url = $(this).data('url');
    SCApp.Friend.doAction(action_url, 'cancel_request');
    return false;
  });

  // Confirm Friend Request
  $('.search-people-list .confirm-ifr-request').on('click', function() {
    var action_url = $(this).data('url');
    SCApp.Friend.doAction(action_url, 'confirm_request');
    return false;
  });
  // Reject Friend Request
  $('.search-people-list .reject-ifr-request').on('click', function() {
    var action_url = $(this).data('url');
    SCApp.Friend.doAction(action_url, 'reject_request');
    return false;
  });
});
</script>
@endpush
