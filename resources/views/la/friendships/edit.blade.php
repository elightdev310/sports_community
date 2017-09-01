@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/friendships') }}">FriendShip</a> :
@endsection
@section("contentheader_description", $friendship->$view_col)
@section("section", "FriendShips")
@section("section_url", url(config('laraadmin.adminRoute') . '/friendships'))
@section("sub_section", "Edit")

@section("htmlheader_title", "FriendShips Edit : ".$friendship->$view_col)

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
				{!! Form::model($friendship, ['route' => [config('laraadmin.adminRoute') . '.friendships.update', $friendship->id ], 'method'=>'PUT', 'id' => 'friendship-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'user1_id')
					@la_input($module, 'user2_id')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/friendships') }}">Cancel</a></button>
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
	$("#friendship-edit-form").validate({
		
	});
});
</script>
@endpush
