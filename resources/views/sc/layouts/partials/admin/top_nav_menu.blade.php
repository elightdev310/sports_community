<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
	<ul class="nav navbar-nav">
		<li><a href="{{ url(config('laraadmin.adminRoute')) }}">Dashboard</a></li>
		<?php $menuItems = SCHelper::getMenuData('webadmin'); ?>
        @foreach ($menuItems as $menu)
            <?php echo SCHelper::printMenuTop($menu); ?>
        @endforeach
	</ul>
</div><!-- /.navbar-collapse -->
