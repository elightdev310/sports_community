{{-- $team --}}
<div class="team-item m10 @if ($team->status) {{ "status-{$team->status}" }} @endif" data-team="{{ $team->id }}">
  <table class="table">
    <tr>
      <td>
        <div class="cover-photo-thumb pull-left">
          &nbsp;
        </div>
        <div class="">
          <div class="mt5">
            <a href="{{ route('team.page', ['slug'=>$team->slug]) }}" class="team-title">{{ $team->name }}</a>
          </div>
        </div>
      </td>
      <td class="team-action pull-right">
        @if (!SCTeamLib::isTeamManager($currentUser->id, $team))
        <button class="btn-team-join btn btn-default btn-small">
          @if ($team->status=='send') Request Sent
          @else Join 
          @endif
        </button>
        @endif
      </td>
    </tr>
  </table>
</div>
