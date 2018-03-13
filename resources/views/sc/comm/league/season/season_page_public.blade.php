@extends('sc.layouts.league.season')

@section('htmlheader_title')
{{ $season->name }}
@endsection

@section('page_id')individual-season @endsection
@section('page_classes')individual-season-page @endsection

@section('content')
  
  {{-- Division Teams --}}
  @if (count($division_teams))
    <div class="page-panel mt10">
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
  });
});
</script>
@endpush