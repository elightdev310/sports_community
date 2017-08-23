@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/postcomments') }}">PostComment</a> :
@endsection
@section("contentheader_description", $postcomment->$view_col)
@section("section", "PostComments")
@section("section_url", url(config('laraadmin.adminRoute') . '/postcomments'))
@section("sub_section", "Edit")

@section("htmlheader_title", "PostComments Edit : ".$postcomment->$view_col)

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
				{!! Form::model($postcomment, ['route' => [config('laraadmin.adminRoute') . '.postcomments.update', $postcomment->id ], 'method'=>'PUT', 'id' => 'postcomment-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'text')
					@la_input($module, 'post_id')
					@la_input($module, 'pid')
					@la_input($module, 'author_uid')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/postcomments') }}">Cancel</a></button>
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
	$("#postcomment-edit-form").validate({
		
	});
});
</script>
@endpush
