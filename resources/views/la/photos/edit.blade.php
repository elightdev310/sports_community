@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/photos') }}">Photo</a> :
@endsection
@section("contentheader_description", $photo->$view_col)
@section("section", "Photos")
@section("section_url", url(config('laraadmin.adminRoute') . '/photos'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Photos Edit : ".$photo->$view_col)

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
				{!! Form::model($photo, ['route' => [config('laraadmin.adminRoute') . '.photos.update', $photo->id ], 'method'=>'PUT', 'id' => 'photo-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'file_id')
					@la_input($module, 'group_nid')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/photos') }}">Cancel</a></button>
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
	$("#photo-edit-form").validate({
		
	});
});
</script>
@endpush
