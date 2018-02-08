@extends('sc.layouts.modal')

@section('htmlheader_title')
Add Photo
@endsection

@section('page_id')cover-photo @endsection
@section('page_classes')cover-photo-page node-page @endsection

@section('content')

<div class="cover-photo-content">
  <div class="picture-action-panel">
    <div class="upload-photo-section p10">
      <button id="upload-cover-photo-link" class="btn btn-primary btn-lg">Upload Photo</button>
      <input type="file" name="photo" id="cover-photo-file" class="hidden">
    </div>
    <div class="photo-browser-section p10">
      <?php print SCPhotoLib::render_photo_browser(); ?>
    </div>
  </div>
</div>

@endsection

@push('scripts')
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
    SCApp.UI.blockUI('body');
    SCApp.ajaxSetup();
    $.ajax({
      url: "{{ route('node.cover_photo.upload_picture.post', ['node'=>$node]) }}",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
    })
    .done(function( json, textStatus, jqXHR ) {
      SCApp.doAjaxAction(json); //Refresh
    })
    .always(function( data, textStatus, errorThrown ) {
      SCApp.UI.unblockUI('body');
    });
  });

  // Choose photo in browser
  $('.photo-browser-section .image-item .image-content').on('click', function () {
    var $this = $(this);
    var photo_id = $this.data('photo');
    $this.addClass('border-selected');

    SCApp.UI.blockUI('body');
    SCApp.ajaxSetup();
    $.ajax({
      url: "{{ route('node.cover_photo.choose_picture.post', ['node'=>$node]) }}",
      type: "POST",
      data: {photo_id: photo_id},
    })
    .done(function( json, textStatus, jqXHR ) {
      SCApp.doAjaxAction(json); //Refresh
    })
    .always(function( data, textStatus, errorThrown ) {
      SCApp.UI.unblockUI('body');
    });
  });
});
</script>
@endpush
