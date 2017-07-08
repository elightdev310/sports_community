@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/userprofiles') }}">UserProfile</a> :
@endsection
@section("contentheader_description", $userprofile->$view_col)
@section("section", "UserProfiles")
@section("section_url", url(config('laraadmin.adminRoute') . '/userprofiles'))
@section("sub_section", "Edit")

@section("htmlheader_title", "UserProfiles Edit : ".$userprofile->$view_col)

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
				{!! Form::model($userprofile, ['route' => [config('laraadmin.adminRoute') . '.userprofiles.update', $userprofile->id ], 'method'=>'PUT', 'id' => 'userprofile-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'user_id')
					@la_input($module, 'date_birth')
					@la_input($module, 'gender')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/userprofiles') }}">Cancel</a></button>
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
	$("#userprofile-edit-form").validate({
		
	});
});
</script>
@endpush
