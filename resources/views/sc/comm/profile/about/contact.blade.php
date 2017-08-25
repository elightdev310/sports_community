@extends('sc.layouts.app')

@section('htmlheader_title')
Contact Information
@endsection

@section('page_id')profile-about-contact @endsection
@section('page_classes')about-contact-page profile-about-page profile-page @endsection

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
        <div class="profile-contact-section about-content-section clearfix p20">

          @if (!empty($editable))
          {!! Form::open(['route'=>['profile.about.save_contact.post', $user->id], 'method'=>'post', 'class'=>'sc-form-1' ]) !!}
            <div class="form-group has-feedback row">
                {!! Form::label('email', 'Email', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-9">
                  {!! Form::email('email', $user->email, ['class'=>'form-control', 'readonly'=>'readonly']) !!}
                </div>
            </div>
            <div class="form-group has-feedback row">
                {!! Form::label('phone', 'Mobile', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-9">
                  {!! Form::text('phone', $user->profile->phone, ['class'=>'form-control']) !!}
                </div>
            </div>

            <div class="form-group has-feedback row">
                {!! Form::label('address', 'Address', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-9">
                  {!! Form::text('address', $user->profile->address, ['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group has-feedback row">
                {!! Form::label('city', 'City', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-9">
                  {!! Form::text('city', $user->profile->city, ['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group has-feedback row">
                {!! Form::label('state', 'State', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-9">
                  {!! Form::text('state', $user->profile->state, ['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group has-feedback row">
                {!! Form::label('zip', 'Zip', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-9">
                  {!! Form::text('zip', $user->profile->zip, ['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-right">
                    {!! Form::submit('Save Changes', ['class'=>'btn btn-primary btn-flat']) !!}
                </div><!-- /.col -->
            </div>
          {!! Form::close() !!}

          @else

          <!-- Public Contact Information -->
            <div class="form-group has-feedback row">
                {!! Form::label('email', 'Email', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-9">
                  {{ $user->email }}
                </div>
            </div>
            <div class="form-group has-feedback row">
                {!! Form::label('phone', 'Mobile', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-9">
                  {{ $user->profile->phone }}
                </div>
            </div>

            <div class="form-group has-feedback row">
                {!! Form::label('address', 'Address', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-9">
                  {{ $user->profile->address }}
                </div>
            </div>
            <div class="form-group has-feedback row">
                {!! Form::label('city', 'City', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-9">
                  {{ $user->profile->city }}
                </div>
            </div>
            <div class="form-group has-feedback row">
                {!! Form::label('state', 'State', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-9">
                  {{ $user->profile->state }}
                </div>
            </div>
            <div class="form-group has-feedback row">
                {!! Form::label('zip', 'Zip', ['class' => 'form-label col-xs-3']) !!}
                <div class="col-xs-9">
                  {{ $user->profile->zip }}
                </div>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
