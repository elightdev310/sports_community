<div class="header-section profile-cover">
    <div class="cover-image" style="@if ($user->profile->coverPhotoPath()) background-image: url('{{ url($user->profile->coverPhotoPath()) }}'); @endif">

        @if ($editable)
        <a class="edit-cover-link emodal-ajax" href="#" data-url="{{ route('profile.cover_photo') }}" data-title="Add Cover Photo" data-size="md">
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

