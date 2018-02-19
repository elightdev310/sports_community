<!-- Join Requests -->
<!-- TO DO: Change Peopele Actions -->
<div class="page-panel mt10">
  <div class="panel-header">
    <div class="panel-title">Join Requests</div>
  </div>
  <div class="panel-content">
    @if (count($requests))
      <div class="league-member-list people-list-section row no-margin">
      @foreach ($requests as $people) 
      <div class="col-md-6 no-padding">
        <div class="people-item m10" data-member="{{ $people->id }}">
          <table class="table">
            <tr>
              <td>
                <div class="cover-photo-thumb pull-left">
                  {!! SCUserLib::avatarImage($people, 72) !!}
                </div>
                <div class="user-name pull-left">
                  <div class="mt5">
                    <a href="{{ route('profile.index', ['user'=>$people->id]) }}">{{ $people->name }}</a>
                  </div>
                </div>
              </td>
              <td class="people-action pull-right">
                <a href="#" data-url="{{ route('league.member.relationship.post', ['league'=>$league->id]) }}" class="btn btn-primary btn-allow-member">
                  Allow
                </a>
              </td>
            </tr>
          </table>
        </div>
      </div>
      @endforeach 
      </div>
    @else
      <div class="text-center p10">No member</div>
    @endif
  </div>
</div>

@push('scripts')
<script>
$(function () {
  $('.league-member-list').on('click', '.btn-allow-member', function() {
    var $item = $(this).closest('.people-item');
    var action= 'allow';
    var user_id = $item.data('member');

    // Allow Member
    var action_url = $(this).data('url');

    SCApp.UI.blockUI($item);
    SCApp.ajaxSetup();
    $.ajax({
      url: action_url,
      type: "POST", 
      data: {'action':action, 'user_id':user_id },
    })
    .done(function( json, textStatus, jqXHR ) {
      SCApp.doAjaxAction(json); //Refresh
    })
    .always(function( data, textStatus, errorThrown ) {
      SCApp.UI.unblockUI($item);
    });
    return false;
  });
});
</script>
@endpush
