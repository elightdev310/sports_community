@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/useractivationcodes') }}">UserActivationCode</a> :
@endsection
@section("contentheader_description", $useractivationcode->$view_col)
@section("section", "UserActivationCodes")
@section("section_url", url(config('laraadmin.adminRoute') . '/useractivationcodes'))
@section("sub_section", "Edit")

@section("htmlheader_title", "UserActivationCodes Edit : ".$useractivationcode->$view_col)

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
				{!! Form::model($useractivationcode, ['route' => [config('laraadmin.adminRoute') . '.useractivationcodes.update', $useractivationcode->id ], 'method'=>'PUT', 'id' => 'useractivationcode-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'user_id')
					@la_input($module, 'code')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/useractivationcodes') }}">Cancel</a></button>
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
	$("#useractivationcode-edit-form").validate({
		
	});
});
</script>
@endpush
