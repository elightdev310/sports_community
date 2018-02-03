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

<div class="page-panel search-teams-section mt10">
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
          <div class="team-item m10 @if ($team->status) {{ "status-{$team->status}" }} @endif" data-team="{{ $team->id }}">
            <table class="table">
              <tr>
                <td>
                  <div class="cover-photo-thumb pull-left">
                    &nbsp;
                  </div>
                  <div class="">
                    <div class="mt5">
                      <a href="{{ route('team.page', ['slug'=>$team->slug]) }}" class="team-title">{{ $team->name }}</a>
                    </div>
                  </div>
                </td>
                <td class="team-action pull-right">
                  <button class="btn-team-join btn btn-default btn-small">
                    @if ($team->status=='send') Request Sent
                    @else Join 
                    @endif
                  </button>
                </td>
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
  $('.search-teams-section').on('click', '.btn-team-join', function() {
    var $btn = $(this);
    var $item= $(this).closest('.team-item');
    var team_id = $item.data('team');
    var action = '';

    if ($item.hasClass('status-send')) {
      action = 'cancel'; 
    } else {
      action = 'send';
    }

    SCApp.UI.blockUI($item);
    SCApp.ajaxSetup();
    $.ajax({
      url: "/teams/"+team_id+"/member-relationship",
      type: "POST",
      data: {'action':action},
    })
    .done(function( json, textStatus, jqXHR ) {
      if (action == 'send') {
        $item.addClass('status-send');
        $btn.html('Request Sent');
      } else if (action == 'cancel') {
        $item.removeClass('status-send');
        $btn.html('Join');
      }
    })
    .always(function( data, textStatus, errorThrown ) {
      SCApp.UI.unblockUI($item);
    });
  });
});
</script>
@endpush
