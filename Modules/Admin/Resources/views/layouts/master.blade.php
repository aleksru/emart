<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin::layouts.parts.meta')
    <title>{{env('APP_ADMIN_NAME')}}</title>
    @stack('css')
    <link rel="stylesheet" href="{{ mix('compiled/css/modules/admin/app.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        @include('admin::layouts.parts.nav_links')

        <!-- SEARCH FORM -->
        {{--@include('admin::layouts.parts.search')--}}

        <!-- Right navbar links -->
        @include('admin::layouts.parts.nav_right')
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">{{env('APP_ADMIN_NAME')}}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            @include('admin::layouts.parts.user_panel')

            <!-- Sidebar Menu -->
            @include('admin::layouts.parts.nav_left_menu')
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div id="app" class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        {{--<h1 class="m-0 text-dark">Starter Page</h1>--}}
                        @yield('title')
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        @yield('breadcrumbs')
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    {{--@include('admin::layouts.parts.right_sidebar')--}}
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    @include('admin::layouts.parts.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- AdminLTE App -->
<script src="{{ mix('compiled/js/modules/admin/app.js') }}"></script>
@stack('script')
@yield('js')
<script>
    @if (session()->has('success'))
        toast.success('{{ session()->get('success') }}')
    @endif
</script>
</body>
</html>