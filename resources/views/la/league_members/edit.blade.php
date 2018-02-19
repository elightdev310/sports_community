@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/league_members') }}">League Member</a> :
@endsection
@section("contentheader_description", $league_member->$view_col)
@section("section", "League Members")
@section("section_url", url(config('laraadmin.adminRoute') . '/league_members'))
@section("sub_section", "Edit")

@section("htmlheader_title", "League Members Edit : ".$league_member->$view_col)

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
				{!! Form::model($league_member, ['route' => [config('laraadmin.adminRoute') . '.league_members.update', $league_member->id ], 'method'=>'PUT', 'id' => 'league_member-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'league_id')
					@la_input($module, 'user_id')
					@la_input($module, 'active')
					@la_input($module, 'status')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/league_members') }}">Cancel</a></button>
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
	$("#league_member-edit-form").validate({
		
	});
});
</script>
@endpush
