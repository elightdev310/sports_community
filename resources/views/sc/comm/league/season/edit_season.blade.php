@extends('sc.layouts.modal')

@section('htmlheader_title')
Edit Season
@endsection

@section('page_id')edit-season @endsection
@section('page_classes')edit-season-page season-page @endsection
@section('content')
<div class="edit-season-section clearfix p20">
  {!! Form::open(['route' =>['league.season.edit.post', 'slug'=>$league->slug, 'season'=>$season->id], 
                  'method'=>'post', 'class'=>'sc-form-1' ]) !!}
    <div class="form-group has-feedback row">
        {!! Form::label('name', 'Season Name', ['class' => 'form-label col-xs-3']) !!}
        <div class="col-xs-9">
          {!! Form::text('name', $season->name, ['class'=>'form-control', 'autofocus'=>'']) !!}
        </div>
    </div>
    <div class="form-group has-feedback row">
        {!! Form::label('start_date', 'Start Date', ['class' => 'form-label col-xs-3']) !!}
        <div class="col-xs-9">
          {!! Form::text('start_date', SCHelper::strTime($season->start_date, 'm/d/Y'), ['class'=>'form-control datepicker']) !!}
        </div>
    </div>
    <div class="form-group has-feedback row">
        {!! Form::label('end_date', 'End Date', ['class' => 'form-label col-xs-3']) !!}
        <div class="col-xs-9">
          {!! Form::text('end_date', SCHelper::strTime($season->end_date, 'm/d/Y'), ['class'=>'form-control datepicker']) !!}
        </div>
    </div>
    <div class="m30">&nbsp;</div>
    <div class="row">
        <div class="col-xs-12 text-right">
            {!! Form::submit('Save', ['class'=>'btn btn-primary btn-flat']) !!}
        </div><!-- /.col -->
    </div>
  {!! Form::close() !!}
</div>
@endsection

