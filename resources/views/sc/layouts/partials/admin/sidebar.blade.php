<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    @if (! Auth::guest())
      <div class="user-panel">
        <div class="pull-left image">
          {!! SCUserLib::avatarImage($currentUser, 45) !!}
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
    @endif

    @if (SCUserLib::isAdmin($currentUser) || SCUserLib::isSuperAdmin($currentUser))
    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <!-- Optionally, you can add icons to the links -->
      <li><a href="{{ url(config('sc.webadminRoute')) }}"><i class='fa fa-home'></i> <span>Dashboard</span></a></li>
      <?php
      $menuItems = SCHelper::getMenuData('webadmin');
      ?>
      @foreach ($menuItems as $menu)
        <?php echo SCHelper::printMenu($menu); ?>
      @endforeach
      <!-- LAMenus -->
      
    </ul><!-- /.sidebar-menu -->
    @endif
  </section>
  <!-- /.sidebar -->
</aside>
