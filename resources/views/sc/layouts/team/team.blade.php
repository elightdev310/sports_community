<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
		@include('sc.layouts.partials.htmlheader')
@show
<body class="sidebar-collapse @hasSection('page_id')@yield('page_id')@endif @hasSection('page_classes')@yield('page_classes')@endif team-page">
  <div class="wrapper">

    @include('sc.layouts.partials.mainheader')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container">
            <!-- Main content -->
            <section class="content no-padding">

              {{-- Team Page Content  --}}
              <div class="row">
                <div class="col-sm-3">
                  @include('sc.comm.partials.team.team_page_menu')
                </div>
                <div class="col-sm-9">
                  @section('team_page_header')
                    @include ('sc.comm.partials.team.team_page_header')
                  @show

                  @if(!isset($sub_message))
                  @include('sc.commons.success_error')
                  @endif

                  @yield('content')
                </div>
              </div>

            </section><!-- /.content -->

        </div><!-- /.container -->
    </div><!-- /.content-wrapper -->

  </div><!-- ./wrapper -->

  @include('sc.layouts.partials.footer')

  @section('scripts')
  @include('sc.layouts.partials.scripts')
  @show

</body>
</html>
