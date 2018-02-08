{{-- $team, $is_team_manager --}}

<div class="cover-image-section" @if ($team->coverPhotoPath()) style="background-image:url('{{ url($team->coverPhotoPath()) }}')" @endif>
    @if ($is_team_manager)
    <a class="edit-cover-link emodal-iframe" href="#" data-url="{{ route('node.cover_photo',['node'=>$team->getNode()]) }}" data-title="Add Cover Photo" data-size="md">
      <i class="fa fa-camera mr5" aria-hidden="true"></i>
      <span>
      @if ($team->coverPhotoPath())
      Update Cover Photo
      @else
      Add Cover Photo
      @endif
      </span>
    </a>
    @endif

</div>
