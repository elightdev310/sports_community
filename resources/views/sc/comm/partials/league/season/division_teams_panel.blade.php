@foreach ($division_teams as $group)
  <div class="division m10">
    <div class="division-title text-bold">
      @if (isset($group['division']))
        {{ $group['division']->name }}
      @else
        
      @endif
    </div>
    
    <div class="division-teams ml10">
      @foreach ($group['teams'] as $team)
        <div class="team-item m5">
          <table class="table no-margin">
            <tr>
              <td>
                <div class="cover-photo-thumb pull-left">
                  {!! SCNodeLib::coverPhotoImage( SCNodeLib::getNode($team->id, 'team' )) !!}
                </div>
                <div class="">
                  <div class="mt5">
                    <a href="{{ route('team.page', ['slug'=>$team->slug]) }}" class="team-title">{{ $team->name }}</a>
                  </div>
                </div>
              </td>
              <td class="team-action pull-right">
                @if (!empty($is_league_manager))
                  <select class="form-control">
                      <option value="0" @if($team->division_id == 0) SELECTED @endif>- Unassigned -</option>
                    @foreach ($league->divisions() as $division)
                      <option value="{{ $division->id }}" @if($team->division_id == $division->id) SELECTED @endif>
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