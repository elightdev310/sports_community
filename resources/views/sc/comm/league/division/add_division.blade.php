@extends('sc.layouts.modal')

@section('htmlheader_title')
Add Division
@endsection

@section('page_id')add-division @endsection
@section('page_classes')add-division-page division-page @endsection
@section('content')
<div class="add-division-section clearfix p20">
  {!! Form::open(['route'=>['league.division.add.post', 'slug'=>$league->slug], 'method'=>'post', 'class'=>'sc-form-1' ]) !!}
    <div class="form-group has-feedback row">
        {!! Form::label('name', 'Division Name', ['class' => 'form-label col-xs-3']) !!}
        <div class="col-xs-9">
          {!! Form::text('name', null, ['class'=>'form-control', 'autofocus'=>'']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-right">
            {!! Form::submit('Add', ['class'=>'btn btn-primary btn-flat']) !!}
        </div><!-- /.col -->
    </div>
  {!! Form::close() !!}
  
  {{-- Division List --}}
  @if (count($divisions))
  <div class="box mt20">
  <div class="box-body no-padding">
    <table class="table">
      <tbody>
        @foreach($divisions as $division)
        <tr>
          <td>{{ $division->name }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  </div>
  @endif
</div>
@endsection

