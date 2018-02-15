@extends('sc.layouts.app')

@section('htmlheader_title')
People
@endsection

@section('page_id')search-people @endsection
@section('page_classes')search-people-page search-page @endsection

@section('content')
<div class="search-people-wrapper">
  <div class="page-panel search-people-filter mt10">
    <div class="panel-content p10">
      {!! Form::open(['route'=>['search.people'], 'method'=>'get', 'class'=>'' ]) !!}
        <div class="form-group has-feedback row mt10">
          <div class="col-xs-12">
            <div class="input-group stylish-input-group">
                {!! Form::text('q', $query, ['class'=>'form-control', 'placeholder'=>'Search People']) !!}
                <span class="input-group-addon">
                    <button type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>  
                </span>
            </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

  @if(empty($no_query))
  <div class="page-panel search-people-result mt10">
    <div class="panel-content">
      @if (count($result))
        <div class="search-people-list people-list-section row no-margin">
        @foreach ($result as $people) 
        <div class="col-md-6 no-padding">
          @include('sc.comm.partials.user.people_list_item')
        </div>
        @endforeach 
        </div>
      @else
        <div class="text-center p10">No Result</div>
      @endif
    </div>
  </div>
  @endif

</div>
@endsection

@push('scripts')
  @include('sc.comm.partials.user.people_list_js')
@endpush
