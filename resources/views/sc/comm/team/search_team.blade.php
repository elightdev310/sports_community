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

<div class="page-panel managed-teams-section mt10">
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
        <div class="col-sm-6 no-padding">
          <div class="team-item m10">
            <table>
              <tr>
                <td>
                  <div class="cover-photo-thumb">
                    &nbsp;
                  </div>
                </td>
                <td class="team-title">
                  <a href="{{ route('team.page', ['slug'=>$team->slug]) }}">{{ $team->name }}</a></td>
              </tr>
            </table>
          </div>
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
  
});
@endpush
