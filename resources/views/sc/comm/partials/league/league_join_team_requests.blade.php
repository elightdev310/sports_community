<!-- Join Team Requests -->
<!-- TO DO: Change Team Actions -->
@if (count($requests))
<div class="page-panel mt10">
  <div class="panel-header">
    <div class="panel-title">Join Requests</div>
  </div>
  <div class="panel-content">
      <div class="league-team-list team-list-section row no-margin">
      @foreach ($requests as $team) 
      <div class="col-md-6 no-padding">
        <div class="team-item m10" data-team="{{ $team->id }}">
          <table class="table">
            <tr>
              <td>
                <div class="cover-photo-thumb pull-left">
                  {!! SCNodeLib::coverPhotoImage( SCNodeLib::getNode($team->id, 'team' )) !!}
                </div>
                <div class="user-name pull-left">
                  <div class="mt5">
                    <a href="{{ route('profile.index', ['user'=>$team->id]) }}">{{ $team->name }}</a>
                  </div>
                </div>
              </td>
              <td class="team-action pull-right">
                <a href="#" class="btn btn-primary btn-allow-team" 
                    data-url="{{ route('team.league.relationshiop.post', ['slug'=>$team->slug, 'league'=>$league->id]) }}">
                  Allow
                </a>
              </td>
            </tr>
          </table>
        </div>
      </div>
      @endforeach 
      </div>
    
  </div>
</div>
@endif

@push('scripts')
<script>
$(function () {
  $('.league-team-list').on('click', '.btn-allow-team', function() {
    var $item = $(this).closest('.team-item');
    var action= 'allow';
    var user_id = $item.data('team');

    // Allow team
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
