@extends('sc.layouts.app')

@section('htmlheader_title')
Profile
@endsection

@section('page_id')user-photo @endsection
@section('page_classes')photo-page profile-page @endsection

@section('content')
@include('sc.comm.profile.profile_header')

<div class="page-panel photo-wrapper mt10">
  <div class="panel-header">
    <div class="row">
      <div class="col-xs-6"><div class="panel-title"><i class="fa fa-picture-o mr5" aria-hidden="true"></i>Photos</div></div>
      <div class="col-xs-6 text-right">
        @if ($editable)
        <button class="btn btn-primary add-photo-link">Add Photo</button>
        <input type="file" id="photo-file" class="hidden" />
        @endif
      </div>
    </div>
  </div>
  <div class="panel-content">
    @include('sc.comm.partials.photo.photo_panel')
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
  // Upload Photo
  $('.add-photo-link').on('click', function() {
    $('#photo-file').trigger('click');
  })
  $('#photo-file').on('change', function() {
    var input = $(this);
    var inputLength = input[0].files.length; //No of files selected
    var file;
    var formData = new FormData();
    file = input[0].files[0];
    formData.append( 'file', file);
    //send POST request to upload.php
    SCApp.UI.blockUI('.photo-wrapper.page-panel');
    SCApp.ajaxSetup();
    $.ajax({
      url: "{{ route('profile.photo.upload_picture.post', ['user'=>$user->id]) }}",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
    })
    .done(function( json, textStatus, jqXHR ) {
      SCApp.doAjaxAction(json); //Refresh
    })
    .always(function( data, textStatus, errorThrown ) {
      SCApp.UI.unblockUI('.photo-wrapper.page-panel');
    });
  });

  // Remove Photo
  $('.photo-action-link').on('click', function() {
    var photo_id = $(this).closest('.image-content').data('photo');
    var action_url = '{{ route('profile.photo.delete_picture.post', ['user'=>$user->id]) }}';
    var data = {
      'photo_id': photo_id
    };
    SCApp.Photo.removePhoto(action_url, data);
  });
});
</script>
@endpush
