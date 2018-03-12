{{-- $league, $is_league_manager --}}

<div class="cover-image-section" @if ($league->coverPhotoPath()) style="background-image:url('{{ url($league->coverPhotoPath()) }}')" @endif>
    @if (!empty($is_league_manager))
    <a class="edit-cover-link emodal-iframe" href="#" data-url="{{ route('node.cover_photo',['node'=>$league->getNode()]) }}" data-title="Add Cover Photo" data-size="md">
      <i class="fa fa-camera mr5" aria-hidden="true"></i>
      <span>
      @if ($league->coverPhotoPath())
      Update Cover Photo
      @else
      Add Cover Photo
      @endif
      </span>
    </a>
    @endif
</div>

@if ($currentUser)
@if (empty($is_league_manager))
<div class="league-page-header league-list-section league-item cover-photo-page-header @if ($lm_record&&$lm_record->status) {{ "status-{$lm_record->status}" }} @endif" 
      data-league="{{ $league->id }}">
  @if (!empty($is_league_member))
    <button class="btn-leave-league btn btn-gray">Leave League</button>
  @else
    @if (!SCLeagueLib::isLeagueManager($currentUser->id, $league))
      <button class="btn-league-join btn btn-primary btn-small">
        @if ($lm_record&&$lm_record->status=='send') Request Sent
        @else Join League
        @endif
      </button>
    @endif
  @endif
</div>
@endif
@endif

@push('scripts')
<script>
$(function () {
  $(document).ready(function() {
    SCApp.League.bindLeagueList();
  });
});
</script>
@endpush
