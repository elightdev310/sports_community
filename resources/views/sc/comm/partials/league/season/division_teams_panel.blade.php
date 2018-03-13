<div class="division-teams-panel-section" data-season="{{ $season->id }}">
@foreach ($division_teams as $group)
  <div class="division m10">
    <div class="division-title text-bold">
      @if (isset($group['division']))
        {{ $group['division']->name }}
      @else
        
      @endif
    </div>
    
    <div class="division-teams ml10">
      @foreach ($group['teams'] as $dt_team)
        <div class="team-item m5" data-team="{{ $dt_team->team_id }}">
          <table class="table no-margin">
            <tr>
              <td>
                <div class="cover-photo-thumb pull-left">
                  {!! SCNodeLib::coverPhotoImage( SCNodeLib::getNode($dt_team->team_id, 'team' )) !!}
                </div>
                <div class="">
                  <div class="mt5">
                    <a href="{{ route('team.page', ['slug'=>$dt_team->slug]) }}" class="team-title">{{ $dt_team->team_name }}</a>
                  </div>
                </div>
              </td>
              <td class="team-action pull-right">
                @if (!empty($is_league_manager))
                  <select class="division-select form-control">
                      <option value="0" @if($dt_team->division_id == 0) SELECTED @endif>- Unassigned -</option>
                    @foreach ($league->divisions() as $division)
                      <option value="{{ $division->id }}" @if($dt_team->division_id == $division->id) SELECTED @endif>
                        {{ $division->name }}
                      </option>
                    @endforeach
                  </select>
                @endif
              </td>
            </tr>
          </table>
        </div>
      @endforeach
    </div>
  </div>
@endforeach
</div>