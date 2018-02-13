{{-- Team List JS --}}
<script>
$(function () {
  $('.team-list-section').on('click', '.btn-team-join', function() {
    var $btn = $(this);
    var $item= $(this).closest('.team-item');
    var team_id = $item.data('team');
    var action = '';

    if ($item.hasClass('status-send')) {
      action = 'cancel'; 
    } else {
      action = 'send';
    }

    SCApp.UI.blockUI($item);
    SCApp.ajaxSetup();
    $.ajax({
      url: "/teams/"+team_id+"/member-relationship",
      type: "POST",
      data: {'action':action},
    })
    .done(function( json, textStatus, jqXHR ) {
      if (action == 'send') {
        $item.addClass('status-send');
        $btn.html('Request Sent');
      } else if (action == 'cancel') {
        $item.removeClass('status-send');
        $btn.html('Join');
      }
    })
    .always(function( data, textStatus, errorThrown ) {
      SCApp.UI.unblockUI($item);
    });
  });
});
</script>
