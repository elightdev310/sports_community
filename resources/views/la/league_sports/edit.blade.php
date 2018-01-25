@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/league_sports') }}">League Sport</a> :
@endsection
@section("contentheader_description", $league_sport->$view_col)
@section("section", "League Sports")
@section("section_url", url(config('laraadmin.adminRoute') . '/league_sports'))
@section("sub_section", "Edit")

@section("htmlheader_title", "League Sports Edit : ".$league_sport->$view_col)

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
				{!! Form::model($league_sport, ['route' => [config('laraadmin.adminRoute') . '.league_sports.update', $league_sport->id ], 'method'=>'PUT', 'id' => 'league_sport-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'league_id')
					@la_input($module, 'sport_id')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/league_sports') }}">Cancel</a></button>
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
	$("#league_sport-edit-form").validate({
		
	});
});
</script>
@endpush
