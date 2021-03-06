<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        window.csrf = "{{ csrf_token() }}"
    </script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SMIS') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>

    {{-- AMINLTE STYLES --}}

            <!-- Font Awesome -->
        <link rel="stylesheet"  href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- Tempusdominus Bbootstrap 4 -->
        <link rel="stylesheet"   href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
        <!-- iCheck -->
        <link rel="stylesheet"   href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- JQVMap -->
        <link rel="stylesheet"  href="{{ asset('adminlte/plugins/jqvmap/jqvmap.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet"   href="{{ asset('adminlte/dist/css/adminlte.css') }}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet"   href=" {{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <!-- Daterange picker -->
        <link rel="stylesheet"    href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css') }}">
        <!-- summernote -->
        <link rel="stylesheet"  href="{{ asset('adminlte/plugins/summernote/summernote-bs4.css') }}">

        <link rel="stylesheet"  href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
</head>
<body>
        @include('parts.loader')
        <main>
            @yield('content')
        </main>


        <script src="{{ asset('js/app.js')}}"></script>


        {{-- ADMIN LTE SCRIPTS --}}
        <!-- jQuery -->
        <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
        $.widget.bridge('uibutton', $.ui.button)
        </script>
        <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
        <!-- DataTables -->
        <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
        <!-- AdminLTE App -->
        <!-- Bootstrap 4 -->
        <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- ChartJS -->
        <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js')}}"></script>
        <!-- Sparkline -->
        <script src="{{ asset('adminlte/plugins/sparklines/sparkline.js')}}"></script>
        <!-- JQVMap -->
        <script src="{{ asset('adminlte/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
        <script src="{{ asset('adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{ asset('adminlte/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
        <!-- daterangepicker -->
        <script src="{{ asset('adminlte/plugins/moment/moment.min.js')}}"></script>
        <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js')}}"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
        <!-- Summernote -->
        <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js')}}"></script>
        <!-- overlayScrollbars -->
        <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('adminlte/dist/js/adminlte.js')}}"></script>


</body>
</html>




