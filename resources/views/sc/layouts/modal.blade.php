<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
  @include('sc.layouts.partials.htmlheader')
@show
<body class="sidebar-collapse @hasSection('page_id')@yield('page_id')@endif @hasSection('page_classes')@yield('page_classes')@endif">
<div class="modal-wrapper">
  <div class="modal-content-wrapper">
    <!-- Main content -->
      @if(!isset($sub_message))
      @include('sc.commons.success_error')
      @endif
      <!-- Your Page Content Here -->
      @yield('content')
  </div><!-- ./modal-content-wrapper -->
</div><!-- ./wrapper -->

@section('scripts')
  @include('sc.layouts.partials.scripts')
  <script>
    $(function() {
      $(window).load(function() {
        SCApp.UI.fitModalWindow();
      });
    });
  </script>
@show

</body>
</html>
