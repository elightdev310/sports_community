<script>
$(function () {
  // Send Friend Request
  $('.people-list-section .send-ifr-request').on('click', function() {
    var action_url = $(this).data('url');
    SCApp.Friend.doAction(action_url, 'send_request');
    return false;
  });
  // Reject Friend Request
  $('.people-list-section .cancel-ifr-request').on('click', function() {
    var action_url = $(this).data('url');
    SCApp.Friend.doAction(action_url, 'cancel_request');
    return false;
  });

  // Confirm Friend Request
  $('.people-list-section .confirm-ifr-request').on('click', function() {
    var action_url = $(this).data('url');
    SCApp.Friend.doAction(action_url, 'confirm_request');
    return false;
  });
  // Reject Friend Request
  $('.people-list-section .reject-ifr-request').on('click', function() {
    var action_url = $(this).data('url');
    SCApp.Friend.doAction(action_url, 'reject_request');
    return false;
  });
});
</script>
