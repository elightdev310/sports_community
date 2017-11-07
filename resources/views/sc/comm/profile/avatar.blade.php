@extends('sc.layouts.modal')

@section('htmlheader_title')
Add Photo
@endsection

@section('page_id')avatar @endsection
@section('page_classes')avatar-page profile-page @endsection

@section('content')
<div class="avatar-picture-content">
  <div class="picture-action-panel p10">
    <button id="upload-photo-link" class="btn btn-primary btn-lg">Upload Photo</button>
    <input type="file" name="avatar" id="user-profile-picture" class="hidden">
  </div>
  <div class="upload-picture-wrap hidden p10">
    <div id="upload-picture">
    </div>
    <div class="text-center">
    <button class="avatar-rotate" data-deg="-90">Rotate Left</button>
    <button class="avatar-rotate" data-deg="90">Rotate Right</button>
    </div>

    <div class="pt20 text-right">
      <button type="button" class="btn btn-primary crop-user-picture" >Crop and Save</button>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('assets/plugins/croppie/croppie.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/croppie/croppie.js') }}" type="text/javascript"></script>
<script type="text/javascript">
  $(function () {
    var $uploadCrop;
    function readFile(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
          $('#user-picture-modal').addClass('ready');
          console.log(e.target.result);
          $uploadCrop.croppie('bind', {
            url: e.target.result
          }).
          then(function(){
            console.log('jQuery bind complete');
            SCApp.UI.fitModalWindow();
          });
        }

        reader.readAsDataURL(input.files[0]);
      }
      else {
        
      }
    }
  
    $uploadCrop = $('#upload-picture').croppie({
      viewport: {
        width: 160,
        height: 160, 
      },
      boundary: {
          width: 250,
          height: 250
      },
      enableOrientation: true, 
      //enableExif: true
    });

    $('#upload-photo-link').on('click', function () {
      $('#user-profile-picture').trigger('click');
    });
    $('#user-profile-picture').on('change', function() {
      readFile(this);
      $('.upload-picture-wrap').removeClass('hidden');
    })
    $('.avatar-rotate').on('click', function(ev) {
      var degree = parseInt($(this).data('deg'));
      $uploadCrop.croppie('rotate', degree);
    });

    $('.crop-user-picture').on('click', function (ev) {
      $uploadCrop.croppie('result', {
        type: 'canvas',
        size: 'viewport', 
      }).then(function (resp) {
        // Crop & Save
        SCApp.UI.blockUI('body');
        SCApp.ajaxSetup();
        $.ajax({
            type: "POST", 
            url: "{{ route('profile.avatar.upload_picture.post') }}",
            dataType: 'json',
            data: {
              "user_pic" : resp
            }
        })
        .done(function( json, textStatus, jqXHR ) {
          SCApp.doAjaxAction(json); //Refresh
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
          
        })
        .always(function( data, textStatus, errorThrown ) {
          SCApp.UI.unblockUI('body');
        });
      });
    });

  });
</script>

<script src="{{ asset('assets/plugins/exif/exif.js') }}" type="text/javascript"></script>
@endpush
