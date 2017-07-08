<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
	@include('sc.layouts.partials.admin.htmlheader')
	@show
<body class="{{ LAConfigs::getByKey('skin') }} {{ LAConfigs::getByKey('layout') }} 
					@if(LAConfigs::getByKey('layout') == 'sidebar-mini') sidebar-collapse @endif" 
					bsurl="{{ url('') }}" adminRoute="{{ config('sc.webadminRoute') }}">

@include('sc.layouts.partials.admin.preloading')

<div class="wrapper">

	@include('sc.layouts.partials.admin.mainheader')

	@if(LAConfigs::getByKey('layout') != 'layout-top-nav')
		@include('sc.layouts.partials.admin.sidebar')	
	@endif

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		@if(!isset($no_header))
			@include('sc.layouts.partials.admin.contentheader')
		@endif
		<!-- Main content -->
		<section class="content {{ $no_padding or '' }}">
		
			@if(!isset($no_message))
		    @include('sc.commons.success_error')
		    @endif
			<!-- Your Page Content Here -->
			@yield('main-content')
		</section><!-- /.content -->
	</div><!-- /.content-wrapper -->

	@include('sc.layouts.partials.admin.controlsidebar')

	@include('sc.layouts.partials.footer')

</div><!-- ./wrapper -->

@include('sc.layouts.partials.admin.file_manager')

@section('scripts')
	@include('sc.layouts.partials.admin.scripts')
@show

</body>
</html>
