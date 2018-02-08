@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/node_posts') }}">Node Post</a> :
@endsection
@section("contentheader_description", $node_post->$view_col)
@section("section", "Node Posts")
@section("section_url", url(config('laraadmin.adminRoute') . '/node_posts'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Node Posts Edit : ".$node_post->$view_col)

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
				{!! Form::model($node_post, ['route' => [config('laraadmin.adminRoute') . '.node_posts.update', $node_post->id ], 'method'=>'PUT', 'id' => 'node_post-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'node_id')
					@la_input($module, 'post_id')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/node_posts') }}">Cancel</a></button>
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
	$("#node_post-edit-form").validate({
		
	});
});
</script>
@endpush
