@extends('sc.layouts.app')

@section('htmlheader_title')
Search League
@endsection

@section('page_id')search-league @endsection
@section('page_classes')search-league-page league-page @endsection

@section('content')
<div class="search-league-header-section header-section pt10">
  <div class="headline clearfix">
    <div class="">
      @include ('sc.comm.partials.league.league_header_tabs')
    </div>
  </div>
</div>

<div class="page-panel managed-leagues-section league-list-section mt10">
  <div class="panel-header">
    {!! Form::open(['route'=>'league.search', 'method'=>'get', 'class'=>'search-box-section' ]) !!}
        <div class="input-group stylish-input-group">
            {!! Form::text('term', null, ['class'=>'form-control', 'placeholder'=>'Search league', 'autofocus'=>'']) !!}
            <span class="input-group-addon">
                <button class="search-btn" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    {!! Form::close() !!}
  </div>
  @if (isset($leagues))
  <div class="panel-content">
    @if( !count($leagues) )
      <div class="text-center p20 empty-data-message">
        No search result
      </div>
    @else
      <div class="league-list row no-margin">
        @foreach($leagues as $league)
        <div class="col-md-6 no-padding">
          @include('sc.comm.partials.league.league_list_item')
        </div>
        @endforeach
      </div>
    @endif
  </div>
  @endif
</div>
@endsection

@push('scripts')
  @include('sc.comm.partials.league.league_list_js')
@endpush
