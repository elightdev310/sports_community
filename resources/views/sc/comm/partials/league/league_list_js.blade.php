{{-- League List JS --}}
<script>
$(function () {
  $('.league-list-section').on('click', '.btn-league-join', function() {
    var $btn = $(this);
    var $item= $(this).closest('.league-item');
    var league_id = $item.data('league');
    var action = '';

    if ($item.hasClass('status-send')) {
      action = 'cancel'; 
    } else {
      action = 'send';
    }

    SCApp.UI.blockUI($item);
    SCApp.ajaxSetup();
    $.ajax({
      url: "/leagues/"+league_id+"/member-relationship",
      type: "POST",
      data: {'action':action},
    })
    .done(function( json, textStatus, jqXHR ) {
      SCApp.doAjaxAction(json);
      if (json.status == 'success') {
        if (action == 'send') {
          $item.addClass('status-send');
          $btn.html('Request Sent');
        } else if (action == 'cancel') {
          $item.removeClass('status-send');
          $btn.html('Join');
        }
      }
    })
    .always(function( data, textStatus, errorThrown ) {
      SCApp.UI.unblockUI($item);
    });
  });

  $('.league-list-section').on('click', '.btn-leave-league', function() {
    var $btn = $(this);
    var $item= $(this).closest('.league-item');
    var league_id = $item.data('league');
    var action = 'leave';

    eModal.confirm('Are you sure to leave league?', 'Leave League')
      .then(function() {
        SCApp.UI.blockUI('body');
        SCApp.ajaxSetup();
        $.ajax({
          url: "/leagues/"+league_id+"/member-relationship",
          type: "POST",
          data: {'action':action},
        })
        .done(function( json, textStatus, jqXHR ) {
          SCApp.doAjaxAction(json); //Refresh
        })
        .always(function( data, textStatus, errorThrown ) {
          SCApp.UI.unblockUI('body');
        });
      });
  });
});
</script>
