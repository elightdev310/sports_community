<div class="cover-photo-content modal-body-section">
  <div class="picture-action-panel p10">
    <button id="upload-cover-photo-link" class="btn btn-primary btn-lg">Upload Photo</button>
    <input type="file" name="photo" id="cover-photo-file" class="hidden">
  </div>
</div>

<script>
$(function () {
  // Upload Cover Photo 
  $('#upload-cover-photo-link').on('click', function () {
    $('#cover-photo-file').trigger('click');
  });

  $('#cover-photo-file').on('change', function () {
    var input = $(this);
    var inputLength = input[0].files.length; //No of files selected
    var file;
    var formData = new FormData();
    file = input[0].files[0];
    formData.append( 'cover_photo', file);
    //send POST request to upload.php
    SCApp.UI.blockUI('.modal-body');
    SCApp.ajaxSetup();
    $.ajax({
      url: "{{ route('profile.cover_photo.upload_picture.post') }}",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
    })
    .done(function( json, textStatus, jqXHR ) {
      SCApp.doAjaxAction(json); //Refresh
    })
    .always(function( data, textStatus, errorThrown ) {
      SCApp.UI.unblockUI('.modal-body');
    });
  });

});
</script>
