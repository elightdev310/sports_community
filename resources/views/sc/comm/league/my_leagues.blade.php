@extends('sc.layouts.app')

@section('htmlheader_title')
My Leagues
@endsection

@section('page_id')my-leagues @endsection
@section('page_classes')my-leagues-page league-page @endsection

@section('content')
<div class="my-leagues-header-section header-section pt10">
  <div class="headline clearfix">
    <div class="pull-left">
      @include ('sc.comm.partials.league.league_header_tabs')
    </div>
    <div class="pull-right">
      <a class="create-league-link btn btn-primary emodal-iframe mt5" href="#" data-url="{{ route('league.create') }}" data-title="Create league" data-size="md">
        <i class="fa fa-plus mr5" aria-hidden="true"></i><span>Create League</span>
      </a>
    </div>
  </div>
</div>

<div class="page-panel managed-leagues-section mt10">
  <div class="panel-header">
    <div class="row">
      <div class="col-xs-6"><div class="panel-title">Leagues I Manage</div></div>
      <div class="col-xs-6 text-right">
        
      </div>
    </div>
  </div>
  <div class="panel-content">
    @if( !count($m_leagues) )
      <div class="text-center p20 empty-data-message">No League you manage</div>
    @else
      <div class="league-list row no-margin">
        @foreach( $m_leagues as $m_league )
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
                  <a href="{{ route('league.page', ['slug'=>$m_league->slug]) }}">{{ $m_league->name }}</a></td>
              </tr>
            </table>
          </div>
        </div>
        @endforeach
      </div>
    @endif
  </div>
</div>
@endsection
