{{-- $season --}}
<div class="season-item m10">
  <table class="table">
    <tr>
      <td>
        <div class="cover-photo-thumb pull-left">
          {!! SCNodeLib::coverPhotoImage( SCNodeLib::getNode($season->id, 'season' )) !!}
        </div>
        <div class="">
          <div class="">
            <a href="{{ route('league.season.page', ['slug'=>$season->league->slug, 'season'=>$season->id]) }}" 
                class="season-title">
              {{ $season->name }}
            </a>
          </div>
          <div class="mt5">
            {{ SCHelper::strTime($season->start_date) }} ~ {{ SCHelper::strTime($season->end_date) }}
          </div>

        </div>
      </td>
      <td class="league-action pull-right">
        @if ($currentUser && SCLeagueLib::isLeagueManager($currentUser->id, $league))
          <button class="btn-edit-season btn emodal-iframe"
            data-url="{{ route('league.season.edit', ['slug'=>$league->slug, 'season'=>$season->id]) }}" data-title="Edit Season" data-size="md">
            Edit
          </button>
        @endif
      </td>
    </tr>
  </table>
</div>
  