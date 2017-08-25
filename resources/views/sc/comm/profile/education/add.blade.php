@extends('sc.layouts.modal')

@section('htmlheader_title')
Add Education
@endsection

@section('page_id')profile-about-edu-add @endsection
@section('page_classes')add-education education-page profile-page @endsection

@section('content')
<div class="education-panel">
  {!! Form::open(['route'=>['profile.about.education.add.post', $user->id], 'method'=>'post', 'class'=>'sc-form-1' ]) !!}
    <!-- Name -->
    <div class="form-group has-feedback row">
      {!! Form::label('name', 'Name', ['class' => 'form-label col-xs-3']) !!}
      <div class="col-xs-9">
        {!! Form::text('name', NULL, ['class'=>'form-control']) !!}
      </div>
    </div>
    <!-- Start -->
    <div class="form-group has-feedback row">
      {!! Form::label('start_year', 'Start', ['class' => 'form-label col-xs-3']) !!}
      <div class="col-xs-9">
        {!! Form::select('start_year', SCHelper::yearArray(), NULL, ['class'=>'form-control']) !!}
      </div>
    </div>
    <!-- End -->
    <div class="form-group has-feedback row">
      {!! Form::label('end_year', 'End', ['class' => 'form-label col-xs-3']) !!}
      <div class="col-xs-9">
        {!! Form::select('end_year', SCHelper::yearArray(), NULL, ['class'=>'form-control']) !!}
      </div>
    </div>
    <!-- Graduated -->
    <div class="form-group has-feedback row">
      {!! Form::label('graduated', 'Graduated', ['class' => 'form-label col-xs-3']) !!}
      <div class="col-xs-9">
        <div class="checkbox icheck mt5">
          {!! Form::checkbox('graduated', '1', true) !!}
        </div>
      </div>
    </div>

    <div class="row">
        <div class="col-xs-12 text-right">
            {!! Form::submit('Add', ['class'=>'btn btn-primary btn-flat']) !!}
        </div><!-- /.col -->
    </div>
  {!! Form::close() !!}
</div>
@endsection
