{{-- $team, $is_team_manager --}}

<div class="cover-image-section" @if ($team->coverPhotoPath()) style="background-image:url('{{ url($team->coverPhotoPath()) }}')" @endif>
    @if (!empty($is_team_manager))
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

@if ($currentUser)
@if (empty($is_team_manager))
<div class="team-page-header team-list-section team-item @if ($tm_record&&$tm_record->status) {{ "status-{$tm_record->status}" }} @endif" data-team="{{ $team->id }}">
  @if (!empty($is_team_member))
    <button class="btn-leave-team btn btn-gray">Leave Team</button>
  @else
    @if (!SCTeamLib::isTeamManager($currentUser->id, $team))
      <button class="btn-team-join btn btn-primary btn-small">
        @if ($tm_record&&$tm_record->status=='send') Request Sent
        @else Join Team
        @endif
      </button>
    @endif
  @endif
</div>
@endif
@endif

@push('scripts')
  @include('sc.comm.partials.team.team_list_js')
@endpush
