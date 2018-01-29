@extends('sc.layouts.app')

@section('htmlheader_title')
My Leagues
@endsection

@section('page_id')my-leagues @endsection
@section('page_classes')my-league-page league-page @endsection

@section('content')
<div class="my-leagues-header-section header-section pt10">
  <div class="headline clearfix">
    <ul class="headline-tab nav nav-pills">
    </ul>
    <div class="pull-right">
      <a class="create-league-link btn btn-primary emodal-iframe" href="#" data-url="{{ route('league.create') }}" data-title="Create league" data-size="md">
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
      <div class="row no-margin">
        @foreach( $m_leagues as $m_league)
        <div class="col-sm-6 no-padding">
          <div class="m-league-item m10">
            <table>
              <tr>
                <td>
                  <div class="cover-photo-thumb">
                    &nbsp;
                  </div>
                </td>
                <td class="league-title">{{ $m_league->name }}</td>
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
