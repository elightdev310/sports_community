{{-- $league --}}
<div class="league-item m10 @if ($league->status) {{ "status-{$league->status}" }} @endif" data-league="{{ $league->id }}">
  <table class="table">
    <tr>
      <td>
        <div class="cover-photo-thumb pull-left">
          &nbsp;
        </div>
        <div class="">
          <div class="mt5">
            <a href="{{ route('league.page', ['slug'=>$league->slug]) }}" class="league-title">{{ $league->name }}</a>
          </div>
        </div>
      </td>
      <td class="league-action pull-right">
        @if (!SCLeagueLib::isLeagueManager($currentUser->id, $league))
          @if (!$league->active)
          <button class="btn-league-join btn btn-default btn-small">
            @if ($league->status=='send') Request Sent
            @else Join 
            @endif
          </button>
          @else
          <button class="btn-leave-league btn btn-gray">Leave League</button>
          @endif
        @endif
      </td>
    </tr>
  </table>
</div>
