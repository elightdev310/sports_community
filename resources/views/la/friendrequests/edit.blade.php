@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/friendrequests') }}">FriendRequest</a> :
@endsection
@section("contentheader_description", $friendrequest->$view_col)
@section("section", "FriendRequests")
@section("section_url", url(config('laraadmin.adminRoute') . '/friendrequests'))
@section("sub_section", "Edit")

@section("htmlheader_title", "FriendRequests Edit : ".$friendrequest->$view_col)

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
				{!! Form::model($friendrequest, ['route' => [config('laraadmin.adminRoute') . '.friendrequests.update', $friendrequest->id ], 'method'=>'PUT', 'id' => 'friendrequest-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'user_id')
					@la_input($module, 'friend_uid')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/friendrequests') }}">Cancel</a></button>
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
	$("#friendrequest-edit-form").validate({
		
	});
});
</script>
@endpush
