@extends('sc.layouts.app')

@section('htmlheader_title')
Search Team
@endsection

@section('page_id')search-team @endsection
@section('page_classes')search-team-page team-page @endsection

@section('content')
<div class="search-team-header-section header-section pt10">
  <div class="headline clearfix">
    <div class="">
      @include ('sc.comm.partials.team.team_header_tabs')
    </div>
  </div>
</div>

<div class="page-panel search-teams-section team-list-section mt10">
  <div class="panel-header">
    {!! Form::open(['route'=>'team.search', 'method'=>'get', 'class'=>'search-box-section' ]) !!}
        <div class="input-group stylish-input-group">
            {!! Form::text('term', null, ['class'=>'form-control', 'placeholder'=>'Search Team', 'autofocus'=>'']) !!}
            <span class="input-group-addon">
                <button class="search-btn" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    {!! Form::close() !!}
  </div>
  @if (isset($teams))
  <div class="panel-content">
    @if( !count($teams) )
      <div class="text-center p20 empty-data-message">
        No search result
      </div>
    @else
      <div class="team-list row no-margin">
        @foreach($teams as $team)
        <div class="col-md-6 no-padding">
          @include('sc.comm.partials.team.team_list_item')
        </div>
        @endforeach
      </div>
    @endif
  </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
$(function () {
  $(document).ready(function() {
    SCApp.Team.bindTeamList();
  });
});
</script>
@endpush
