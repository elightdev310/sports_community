@extends('sc.layouts.modal')

@section('htmlheader_title')
Add Season
@endsection

@section('page_id')add-season @endsection
@section('page_classes')add-season-page league-page @endsection
@section('content')
<div class="add-league-section clearfix p20">
  {!! Form::open(['route'=>['league.season.add.post', 'slug'=>$league->slug], 'method'=>'post', 'class'=>'sc-form-1' ]) !!}
    <div class="form-group has-feedback row">
        {!! Form::label('name', 'Season Name', ['class' => 'form-label col-xs-3']) !!}
        <div class="col-xs-9">
          {!! Form::text('name', null, ['class'=>'form-control', 'autofocus'=>'']) !!}
        </div>
    </div>
    <div class="form-group has-feedback row">
        {!! Form::label('start_date', 'Start Date', ['class' => 'form-label col-xs-3']) !!}
        <div class="col-xs-9">
          {!! Form::text('start_date', null, ['class'=>'form-control datepicker']) !!}
        </div>
    </div>
    <div class="form-group has-feedback row">
        {!! Form::label('end_date', 'End Date', ['class' => 'form-label col-xs-3']) !!}
        <div class="col-xs-9">
          {!! Form::text('end_date', null, ['class'=>'form-control datepicker']) !!}
        </div>
    </div>
    <div class="m30">&nbsp;</div>
    <div class="row">
        <div class="col-xs-12 text-right">
            {!! Form::submit('Add', ['class'=>'btn btn-primary btn-flat']) !!}
        </div><!-- /.col -->
    </div>
  {!! Form::close() !!}
</div>
@endsection

