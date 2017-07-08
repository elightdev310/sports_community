<!-- Main Header -->
<header class="main-header">
	@if(LAConfigs::getByKey('layout') != 'layout-top-nav')
	<!-- Logo -->
	<a href="/" class="logo">
		<img class="site-logo" typeof="foaf:Image" src="{{ config('sc.logo_url') }}" alt="{{ LAConfigs::getByKey('sitename') }}" width="40" height="40">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>{{ LAConfigs::getByKey('sitename_short') }}</b></span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>{{ LAConfigs::getByKey('sitename_short') }}</b></b>
      {{ LAConfigs::getByKey('sitename_part2') }}</span>
	</a>
	@endif

	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top" role="navigation">
	@if(LAConfigs::getByKey('layout') == 'layout-top-nav')
		<div class="container">
			<div class="navbar-header">
				<a href="{{ url(config('sc.webadminRoute')) }}" class="navbar-brand"><b>{{ LAConfigs::getByKey('sitename_part1') }}</b>{{ LAConfigs::getByKey('sitename_part2') }}</a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
			</div>
			@include('sc.layouts.partials.admin.top_nav_menu')
			@include('sc.layouts.partials.admin.notifs')
			
		</div><!-- /.container-fluid -->
	@else
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle b-l" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		@include('sc.layouts.partials.admin.notifs')
	@endif
	
	</nav>
</header>
