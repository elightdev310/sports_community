@extends('sc.layouts.app')

@section('htmlheader_title')
My Teams
@endsection

@section('page_id')my-teams @endsection
@section('page_classes')my-teams-page team-page @endsection

@section('content')
<div class="my-teams-header-section header-section pt10">
  <div class="headline clearfix">
    <div class="pull-left">
      @include ('sc.comm.partials.team.team_header_tabs')
    </div>
    <div class="pull-right">
      <a class="create-team-link btn btn-primary emodal-iframe mt5" href="#" data-url="{{ route('team.create') }}" data-title="Create team" data-size="md">
        <i class="fa fa-plus mr5" aria-hidden="true"></i><span>Create Team</span>
      </a>
    </div>
  </div>
</div>

{{-- Managed Teams --}}
@if( count($m_teams) )
<div class="page-panel managed-teams-section mt10">
  <div class="panel-header">
    <div class="row">
      <div class="col-xs-6"><div class="panel-title">Teams I Manage</div></div>
      <div class="col-xs-6 text-right">
        
      </div>
    </div>
  </div>
  <div class="panel-content">
      <div class="team-list row no-margin">
        @foreach( $m_teams as $m_team )
        <div class="col-md-6 no-padding">
          <div class="team-item m10">
            <table class="table">
              <tr>
                <td>
                  <div class="cover-photo-thumb pull-left">
                    &nbsp;
                  </div>
                  <div class="">
                    <div class="mt5">
                      <a href="{{ route('team.page', ['slug'=>$m_team->slug]) }}" class="team-title">{{ $m_team->name }}</a>
                    </div>
                  </div>
                </td>
                <td class="team-action pull-right">
                  
                </td>
              </tr>
            </table>
          </div>
        </div>
        @endforeach
      </div>
  </div>
</div>
@endif

{{-- Requested Teams --}}
@if( count($r_teams) )
<div class="page-panel request-teams-section team-list-section mt10">
  <div class="panel-header">
    <div class="row">
      <div class="col-xs-6"><div class="panel-title">Teams You sent request to</div></div>
      <div class="col-xs-6 text-right">
        
      </div>
    </div>
  </div>
  <div class="panel-content">
    <div class="team-list row no-margin">
      @foreach( $r_teams as $team )
      <div class="col-md-6 no-padding">
        @include('sc.comm.partials.team.team_list_item')
      </div>
      @endforeach
    </div>
  </div>
</div>
@endif

{{-- Joined Teams --}}
@if( count($j_teams) )
<div class="page-panel joined-teams-section team-list-section mt10">
  <div class="panel-header">
    <div class="row">
      <div class="col-xs-6"><div class="panel-title">Teams You joined</div></div>
      <div class="col-xs-6 text-right">
        
      </div>
    </div>
  </div>
  <div class="panel-content">
    <div class="team-list row no-margin">
      @foreach( $j_teams as $team )
      <div class="col-md-6 no-padding">
        @include('sc.comm.partials.team.team_list_item')
      </div>
      @endforeach
    </div>
  </div>
</div>
@endif
@endsection

@push('scripts')
  @include('sc.comm.partials.team.team_list_js')
@endpush
