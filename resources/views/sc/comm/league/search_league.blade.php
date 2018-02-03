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

<div class="page-panel managed-leagues-section mt10">
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
          <div class="league-item m10">
            <table>
              <tr>
                <td>
                  <div class="cover-photo-thumb">
                    &nbsp;
                  </div>
                </td>
                <td class="league-title">
                  <a href="{{ route('league.page', ['slug'=>$league->slug]) }}">{{ $league->name }}</a></td>
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
</script>
@endpush
