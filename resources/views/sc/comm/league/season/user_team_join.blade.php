@extends('sc.layouts.modal')

@section('htmlheader_title')
User Team Join
@endsection

@section('page_id')user-team-join @endsection
@section('page_classes')user-team-join-page season-page @endsection
@section('content')
  <div class="edit-season-section clearfix p20">
    <div class="box mt20">
      <div class="box-body">
        <h5><strong>Managed Teams</strong></h5>
        <table class="division-team-list-section table">
          <tbody>
            @foreach ($dt_teams as $dt_team)
              <tr class="dt-item">
                <td>
                  <div class="cover-photo-thumb pull-left">
                    {!! SCNodeLib::coverPhotoImage( SCNodeLib::getNode($dt_team->id, 'team' )) !!}
                  </div>
                  <div>
                    {{ $dt_team->name }}
                  </div>
                </td>
                <td class="td-action text-right">
                  @if ($dt_team->active)
                    <button class="btn btn-disabled btn-small" disabled>
                      Joined
                    </button>
                  @elseif ($dt_team->status)
                    <button class="btn btn-info btn-small" disabled>
                      Waiting approval
                    </button>
                  @else
                    <button class="btn-join-season btn btn-primary btn-small"
                        data-url="{{ route('league.season.user_team_join.post', [$league->slug, $season->id, $dt_team->id]) }}">
                      Join Season
                    </button>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
$(function () {
  $(document).ready(function() {
    SCApp.Season.bindDivisionTeamList();
  });
});
</script>
@endpush