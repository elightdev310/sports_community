<div class="header-section profile-cover">
    <div class="cover-image">
        <div class="user-name"><h2>{{ $currentUser->name }}</h2></div>
    </div>
    <div class="headline clearfix">
        <ul class="headline-tab nav nav-pills">
          <li class="@if ($tab=='timeline') active @endif"> <a href="#">Timeline</a></li>
          <li class="@if ($tab=='about')    active @endif"> <a href="#">About</a></li>
          <li class="@if ($tab=='friends')  active @endif"> <a href="#">Friends</a></li>
          <li class="@if ($tab=='photos')   active @endif"> <a href="#">Photos</a></li>
        </ul>
        <div class="photo-container">
            <div class="profile-picture-thumb">
                {!! SCUserLib::avatarImage($currentUser) !!}
                <a class="edit-photo-link emodal-iframe" href="#" data-url="{{ route('profile.avatar') }}" data-title="Add Photo" data-size="md">
                  <i class="fa fa-camera mr5" aria-hidden="true"></i>
                  @if (SCUserLib::checkAvatarExist($currentUser))
                  Update Photo
                  @else
                  Add Photo
                  @endif
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')

@endpush
