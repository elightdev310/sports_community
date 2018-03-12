{{-- $season, $is_league_manager --}}

<div class="season-page-title">
  <h3><strong>{{ $season->name }}</strong></h3>
</div>

<div class="cover-image-section" @if ($season->coverPhotoPath()) style="background-image:url('{{ url($season->coverPhotoPath()) }}')" @endif>
    @if (!empty($is_league_manager))
    <a class="edit-cover-link emodal-iframe" href="#" data-url="{{ route('node.cover_photo',['node'=>$season->getNode()]) }}" data-title="Add Cover Photo" data-size="md">
      <i class="fa fa-camera mr5" aria-hidden="true"></i>
      <span>
      @if ($season->coverPhotoPath())
      Update Cover Photo
      @else
      Add Cover Photo
      @endif
      </span>
    </a>
    @endif
</div>

@if ($currentUser)
<div class="season-page-header season-list-section season-item cover-photo-page-header">
  @if (!empty($is_league_manager))
    <button class="btn-add-division btn btn-primary emodal-iframe"
        data-url="{{ route('league.division.add', ['slug'=>$league->slug]) }}" data-title="Add Division" data-size="md">
      + Add Division
    </button>
  @elseif (!empty($currentUser->getManagedTeams()))
    <button class="btn-league-join btn btn-primary btn-small emodal-iframe" 
        data-url="{{ route('league.season.user_team_join', ['slug'=>$league->slug, 'season'=>$season]) }}" data-title="Join Season ({{ $season->name }})" data-size="md">
      Join (Team Manager)
    </button>
  @else
    &nbsp;
  @endif
</div>
@endif