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
    </div>
  </div>
@endsection
