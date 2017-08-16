@extends('sc.layouts.app')

@section('htmlheader_title')
Basic Information
@endsection

@section('page_id')profile-about-basic @endsection
@section('page_classes')about-basic-page profile-about-page profile-page @endsection

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
          @include('sc.comm.profile.about_left')
        </div>
      </div>
      <div class="col-sm-8 col-md-9">
        <div class="about-content-section clearfix p20">
          @if ($editable)
          {!! Form::open(['route'=>['profile.about.save_basic.post', $user->id], 'method'=>'post', 'class'=>'sc-form-1' ]) !!}
            @include('sc.commons.success_error')
            <div class="form-group has-feedback row">
                {!! Form::label('birth_date', 'Birth Date', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-5">
                  {!! Form::select('birth_month', SCHelper::monthArray(), SCHelper::getStrDate($user->profile->date_birth, 'm'), ['class'=>'form-control']) !!}
                </div>
                <div class="col-xs-4">
                  {!! Form::select('birth_day', SCHelper::dayArray(), SCHelper::getStrDate($user->profile->date_birth, 'd'), ['class'=>'form-control']) !!}
                </div>
            </div>

            <div class="form-group has-feedback row">
                {!! Form::label('birth_year', 'Birth Year', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-5">
                  {!! Form::select('birth_year', SCHelper::yearArray(), SCHelper::getStrDate($user->profile->date_birth, 'y'), ['class'=>'form-control']) !!}
                </div>
            </div>


            <div class="form-group has-feedback row">
                {!! Form::label('gender', 'Gender', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-5">
                  {!! Form::select('gender', [''=>'- Please select gender -', 'male'=>'Male', 'female'=>'Female'], $user->profile->gender, ['class'=>'form-control']) !!}
                </div>
            </div>


            <div class="row">
                <div class="col-xs-12 text-right">
                    {!! Form::submit('Save Changes', ['class'=>'btn btn-primary btn-flat']) !!}
                </div><!-- /.col -->
            </div>

          {!! Form::close() !!}
          @else
            <div class="form-group has-feedback row">
                {!! Form::label('birth_date', 'Birth Date', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-9">
                  @if (SCHelper::getStrDate($user->profile->date_birth, 'm'))
                    {{ SCHelper::strTime($user->profile->date_birth, 'M d') }}
                  @endif
                </div>
            </div>
            <div class="form-group has-feedback row">
                {!! Form::label('birth_year', 'Birth Year', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-9">
                  @if (SCHelper::getStrDate($user->profile->date_birth, 'y'))
                    {{ SCHelper::strTime($user->profile->date_birth, 'Y') }}
                  @endif
                </div>
            </div>

            <div class="form-group has-feedback row">
                {!! Form::label('gender', 'Gender', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-9">
                  {{ ucwords($user->profile->gender) }}
                </div>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
