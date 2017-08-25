@extends('sc.layouts.modal')

@section('htmlheader_title')
Edit Education
@endsection

@section('page_id')profile-about-edu-edit @endsection
@section('page_classes')edit-education education-page profile-page @endsection

@section('content')
<div class="education-panel">
  {!! Form::open(['route'=>['profile.about.education.edit.post', $user->id, $education->id], 'method'=>'post', 'class'=>'sc-form-1' ]) !!}
    <!-- Name -->
    <div class="form-group has-feedback row">
      {!! Form::label('name', 'Name', ['class' => 'form-label col-xs-3']) !!}
      <div class="col-xs-9">
        {!! Form::text('name', $education->name, ['class'=>'form-control']) !!}
      </div>
    </div>
    <!-- Start -->
    <div class="form-group has-feedback row">
      {!! Form::label('start_year', 'Start', ['class' => 'form-label col-xs-3']) !!}
      <div class="col-xs-9">
        {!! Form::select('start_year', SCHelper::yearArray(), SCHelper::getStrDate($education->start, 'y'), ['class'=>'form-control']) !!}
      </div>
    </div>
    <!-- End -->
    <div class="form-group has-feedback row">
      {!! Form::label('end_year', 'End', ['class' => 'form-label col-xs-3']) !!}
      <div class="col-xs-9">
        {!! Form::select('end_year', SCHelper::yearArray(), SCHelper::getStrDate($education->end, 'y'), ['class'=>'form-control']) !!}
      </div>
    </div>
    <!-- Graduated -->
    <div class="form-group has-feedback row">
      {!! Form::label('graduated', 'Graduated', ['class' => 'form-label col-xs-3']) !!}
      <div class="col-xs-9">
        <div class="checkbox icheck mt5">
          {!! Form::checkbox('graduated', '1', $education->graduated? true:false) !!}
        </div>
      </div>
    </div>

    <div class="row">
        <div class="col-xs-12 text-right">
            {!! Form::submit('Save CHanges', ['class'=>'btn btn-primary btn-flat']) !!}
        </div><!-- /.col -->
    </div>
  {!! Form::close() !!}
</div>
@endsection
