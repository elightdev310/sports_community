@extends('sc.layouts.league.league')

@section('htmlheader_title')
{{ $league->name }}
@endsection

@section('page_id')league-seasons @endsection
@section('page_classes')league-seasons-page @endsection

@section('content')
  <div class="page-panel mt10">
    <div class="panel-content">

      @if ($currentUser)
      @if (!empty($is_league_manager))
      <div class="p10">
        <button class="btn-add-season btn btn-primary emodal-iframe"
            data-url="{{ route('league.season.add', ['slug'=>$league->slug]) }}" data-title="Add Season" data-size="md">
          + Add Season
        </button>
      </div>
      @endif
      @endif

      @if (count($seasons) || count($archived))
        @if (count($seasons))
          <div class="active-season-list season-list-section row no-margin">
            @foreach($seasons as $season)
              <div class="no-padding">
                @include('sc.comm.partials.league.season.season_list_item')
              </div>
            @endforeach
          </div>
        @endif
        @if (count($archived))
          <div class="archived-season-list season-list-section row no-margin">
            <div class="pl20">
              <h4><strong>Archived Seasons</strong></h4>
            </div>
            @foreach($archived as $season)
              <div class="no-padding">
                @include('sc.comm.partials.league.season.season_list_item')
              </div>
            @endforeach
          </div>
        @endif
      @else
        <div class="text-center p10">No season</div>
      @endif
    </div>
  </div>
@endsection
