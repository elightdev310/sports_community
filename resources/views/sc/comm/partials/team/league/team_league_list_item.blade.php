{{-- $team, $league --}}
<div class="league-item m10 @if ($league->status) {{ "status-{$league->status}" }} @endif" data-league="{{ $league->id }}">
  <table class="table no-border mb0">
    <tr>
      <td>
        <div class="cover-photo-thumb pull-left">
          {!! SCNodeLib::coverPhotoImage( SCNodeLib::getNode($league->id, 'league' )) !!}
        </div>
        <div class="">
          <div class="mt5">
            <a href="{{ route('league.page', ['slug'=>$league->slug]) }}" class="league-title">{{ $league->name }}</a>
          </div>
        </div>
      </td>
      <td class="league-action pull-right">
        @if (SCTeamLib::isTeamManager($currentUser->id, $team))
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

  @if ( count(SCLeagueLib::getSeasons($league->id)) )
    <div class="season-list-section ml20">
      @foreach (SCLeagueLib::getSeasons($league->id) as $season)
        <div class="no-padding">
          @include('sc.comm.partials.league.season.season_list_item')
        </div>
      @endforeach
    </div>
  @endif
</div>
