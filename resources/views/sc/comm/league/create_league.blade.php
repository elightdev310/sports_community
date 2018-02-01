@extends('sc.layouts.modal')

@section('htmlheader_title')
Create League
@endsection

@section('page_id')create-league @endsection
@section('page_classes')create-league-page league-page @endsection
@section('content')
<div class="create-league-section clearfix p20">
  {!! Form::open(['route'=>'league.create', 'method'=>'post', 'class'=>'sc-form-1' ]) !!}
    <div class="form-group has-feedback row">
        {!! Form::label('name', 'Name', ['class' => 'form-label col-xs-3']) !!}
        <div class="col-xs-9">
          {!! Form::text('name', null, ['class'=>'form-control', 'autofocus'=>'']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-right">
            {!! Form::submit('Create', ['class'=>'btn btn-primary btn-flat']) !!}
        </div><!-- /.col -->
    </div>
  {!! Form::close() !!}
</div>
@endsection

@push('scripts')
<script>
$(function() {
  
});
</script>
@endpush
