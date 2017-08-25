@extends('sc.layouts.app')

@section('htmlheader_title')
Education
@endsection

@section('page_id')profile-about-education @endsection
@section('page_classes')about-education-page profile-about-page profile-page @endsection

@section('content')
@include('sc.comm.profile.profile_header')

<div class="page-panel about-wrapper mt10">
  <div class="panel-header">
    <div class="row">
      <div class="col-xs-6"><div class="panel-title"><i class="fa fa-user mr5" aria-hidden="true"></i>About</div></div>
    </div>
  </div>
  <div class="panel-content">
    <div class="row">
      <div class="col-sm-4 col-md-3">
        <div class="about-left-sidebar p10">
          @include('sc.comm.profile.about.left_menu')
        </div>
      </div>
      <div class="col-sm-8 col-md-9">
        <div class="profile-education-section about-content-section clearfix p20">
          @if (!empty($editable))
          <div class="mb20">
            <a href="#" class="btn btn-primary btn-flat emodal-iframe" data-url="{{ route('profile.about.education.add', ['user'=>$user->id]) }}" data-title="Add Education" data-size="md">+ Add Education</a>
          </div>
          @endif

          <div class="education-list">
            @if (empty($editable))
              <p class="text-center">No Education</p>
            @endif
            @if (count($educations)>0)
            @foreach ($educations as $education)
              <div class="edu-item hover-pane">
                <div class="edu-name">{{ $education->name }}</div>
                <div class="edu-period">
                  {{ SCHelper::getStrDate($education->start, 'y') }} - 
                  {{ intval(SCHelper::getStrDate($education->end, 'y'))? SCHelper::getStrDate($education->end, 'y'):'' }}
                  @if (!empty($editable))
                  <div class="edu-action clearfix">
                    <a href="#" class="edu-action-edit hover-action-link emodal-iframe" data-url="{{ route('profile.about.education.edit', ['user'=>$user->id, 'edu'=>$education->id]) }}" data-title="Edit Education" data-size="md">
                      <i class="fa fa-edit" aria-hidden="true"></i></a>
                    <a href="#" class="edu-action-delete hover-action-link" data-edu="{{$education->id}}">
                      <i class="fa fa-trash-o" aria-hidden="true"></i></a>
                  </div>
                  @endif
                </div>
              </div>
            @endforeach
            @endif

          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
  // Delete Education
  $('.edu-action-delete').on('click', function() {
    var edu_id = $(this).data('edu');
    var message = "Are you sure to delete education?";
    eModal.confirm(message, 'Delete Education')
      .then(
          function() { 
            var _url = '{{ route('profile.about.education.delete.post', ['user'=>$user->id]) }}';
            var data = {'edu_id': edu_id};
            SCApp.ajaxSetup();
            $.ajax({
              url: _url,
              type: "POST",
              data: data,
            })
            .done(function( json, textStatus, jqXHR ) {
              SCApp.doAjaxAction(json); //Refresh
            })
            .always(function( data, textStatus, errorThrown ) {
              SCApp.UI.unblockUI('.photo-panel-section');
            });
          },
          function() {});
  });
});
</script>
@endpush
