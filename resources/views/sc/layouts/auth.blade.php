<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
@include('sc.layouts.partials.auth.htmlheader')
@show

<body class="sidebar-collapse auth-page no-main-header">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content">
            @yield('content')
            </div>
        </div><!-- /.content-wrapper -->

    </div><!-- ./wrapper -->

    @section('scripts')
    @include('sc.layouts.partials.scripts_auth')
    @show

</body>
</html>
