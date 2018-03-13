@extends('sc.layouts.league.season')

@section('htmlheader_title')
{{ $season->name }}
@endsection

@section('page_id')individual-season @endsection
@section('page_classes')individual-season-page @endsection

@section('content')
  @if (count($dt_teams))
    <div class="page-panel mt10">
      <div class="panel-content p5">
        <table class="division-team-list-section dt-item table no-margin">
          <tbody>
            @foreach ($dt_teams as $dt_team)
              <tr>
                <td>
                  <div class="cover-photo-thumb pull-left">
                    {!! SCNodeLib::coverPhotoImage( SCNodeLib::getNode($dt_team->team_id, 'team' )) !!}
                  </div>
                  <div>
                    <a href="{{ route('team.page', ['slug'=>$dt_team->slug]) }}" class="team-title">{{ $dt_team->team_name }}</a>
                  </div>
                </td>
                <td class="td-action text-right">
                  <div class="dropdown pull-right">
                    @if ($dt_team->status == 'send')
                      <button class="btn btn-info btn-small dropdown-toggle" type="button" id="dropdown-sent-respond-dt" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Waiting Approval
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdown-sent-respond-dt">
                        <li>
                            <a href="#" class="btn-allow-request" 
                                data-url="{{ route('league.season.user_team_join.post', [$league->slug, $season->id, $dt_team->team_id]) }}">
                              Allow
                            </a>
                          </li>
                        <li>
                          <a href="#" class="btn-reject-request" 
                              data-url="{{ route('league.season.user_team_join.post', [$league->slug, $season->id, $dt_team->team_id]) }}">
                            Reject
                          </a>
                        </li>
                      </ul>
                    @endif
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  @endif
  
  {{-- Division Teams --}}
  @if (count($division_teams))
    <div class="division-teams-panel page-panel mt10">
      <div class="panel-header">
        <div class="panel-title">Division & Teams</div>
      </div>
      <div class="panel-content">
        @include('sc.comm.partials.league.season.division_teams_panel')
      </div>
    </div>
  @endif
@endsection

@push('scripts')
<script>
$(function () {
  $(document).ready(function() {
    SCApp.Season.bindDivisionTeamList();
    SCApp.Season.bindDivisionTeamsPanel();
  });
});
</script>
@endpush