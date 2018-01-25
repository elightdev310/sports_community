@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/division_teams') }}">Division Team</a> :
@endsection
@section("contentheader_description", $division_team->$view_col)
@section("section", "Division Teams")
@section("section_url", url(config('laraadmin.adminRoute') . '/division_teams'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Division Teams Edit : ".$division_team->$view_col)

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
				{!! Form::model($division_team, ['route' => [config('laraadmin.adminRoute') . '.division_teams.update', $division_team->id ], 'method'=>'PUT', 'id' => 'division_team-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'team_name')
					@la_input($module, 'division_id')
					@la_input($module, 'team_id')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/division_teams') }}">Cancel</a></button>
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
	$("#division_team-edit-form").validate({
		
	});
});
</script>
@endpush
