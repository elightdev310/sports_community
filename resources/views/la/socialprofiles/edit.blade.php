@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/socialprofiles') }}">SocialProfile</a> :
@endsection
@section("contentheader_description", $socialprofile->$view_col)
@section("section", "SocialProfiles")
@section("section_url", url(config('laraadmin.adminRoute') . '/socialprofiles'))
@section("sub_section", "Edit")

@section("htmlheader_title", "SocialProfiles Edit : ".$socialprofile->$view_col)

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
				{!! Form::model($socialprofile, ['route' => [config('laraadmin.adminRoute') . '.socialprofiles.update', $socialprofile->id ], 'method'=>'PUT', 'id' => 'socialprofile-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'email')
					@la_input($module, 'provider')
					@la_input($module, 'provider_id')
					@la_input($module, 'token')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/socialprofiles') }}">Cancel</a></button>
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
	$("#socialprofile-edit-form").validate({
		
	});
});
</script>
@endpush
