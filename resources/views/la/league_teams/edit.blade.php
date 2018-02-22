@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/league_teams') }}">League Team</a> :
@endsection
@section("contentheader_description", $league_team->$view_col)
@section("section", "League Teams")
@section("section_url", url(config('laraadmin.adminRoute') . '/league_teams'))
@section("sub_section", "Edit")

@section("htmlheader_title", "League Teams Edit : ".$league_team->$view_col)

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
				{!! Form::model($league_team, ['route' => [config('laraadmin.adminRoute') . '.league_teams.update', $league_team->id ], 'method'=>'PUT', 'id' => 'league_team-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'league_id')
					@la_input($module, 'team_id')
					@la_input($module, 'active')
					@la_input($module, 'status')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/league_teams') }}">Cancel</a></button>
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
	$("#league_team-edit-form").validate({
		
	});
});
</script>
@endpush
