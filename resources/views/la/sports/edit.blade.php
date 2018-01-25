@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/sports') }}">Sport</a> :
@endsection
@section("contentheader_description", $sport->$view_col)
@section("section", "Sports")
@section("section_url", url(config('laraadmin.adminRoute') . '/sports'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Sports Edit : ".$sport->$view_col)

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($sport, ['route' => [config('laraadmin.adminRoute') . '.sports.update', $sport->id ], 'method'=>'PUT', 'id' => 'sport-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'name')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/sports') }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#sport-edit-form").validate({
		
	});
});
</script>
@endpush
