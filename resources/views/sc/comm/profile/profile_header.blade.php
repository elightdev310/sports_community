<div class="header-section profile-cover">
    <div class="cover-image" style="@if ($user->profile->coverPhotoPath()) background-image: url({{ url($user->profile->coverPhotoPath()) }}); @endif">

        @if ($editable)
        <a class="edit-cover-link" href="#" >
          <i class="fa fa-camera mr5" aria-hidden="true"></i>
          <span>
          @if ($user->profile->cover_photo_path)
          Update Cover Photo
          @else
          Add Cover Photo
          @endif
          </span>
        </a>
        @endif

        <div class="user-name"><h2>{{ $user->name }}</h2></div>
    </div>
    <div class="headline clearfix">
        <ul class="headline-tab nav nav-pills">
          <li class="@if ($tab=='timeline') active @endif"> <a href="{{ route('profile.index', ['user'=>$user->id]) }}">Timeline</a></li>
          <li class="@if ($tab=='about')    active @endif"> <a href="{{ route('profile.about', ['user'=>$user->id]) }}">About</a></li>
          <li class="@if ($tab=='photos')   active @endif"> <a href="{{ route('profile.photo', ['user'=>$user->id]) }}">Photos</a></li>
        </ul>
        <div class="photo-container">
            <div class="profile-picture-thumb">
                {!! SCUserLib::avatarImage($user) !!}
                
                @if ($editable)
                <a class="edit-photo-link emodal-iframe" href="#" data-url="{{ route('profile.avatar') }}" data-title="Add Photo" data-size="md">
                  <i class="fa fa-camera mr5" aria-hidden="true"></i>
                  @if (SCUserLib::checkAvatarExist($user))
                  Update Photo
                  @else
                  Add Photo
                  @endif
                </a>
                @endif

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(function () {
  $(document).ready(function() {
    // Add Cover Photo
    $('.edit-cover-link').on('click', function() {
      var options = {
        url: '{{ route('profile.cover_photo') }}', 
        title: 'Add Cover Photo',
        buttons: false
      };
      eModal.ajax(options);
    });
    // Upload Cover Photo 
    $('body').on('click', '#upload-cover-photo-link', function () {
      $('#cover-photo-file').trigger('click');
    });
    $('body').on('change', '#cover-photo-file', function () {
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
});
</script>
@endpush
