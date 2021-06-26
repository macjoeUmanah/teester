<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title') - {{ $settings->app_name }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="icon" href="{{url('/')}}/storage/app/public/favicon.ico" type="image/gif" sizes="16x16">
  <link rel="stylesheet" type="text/css" href="{{asset('public/components/bootstrap/dist/css/bootstrap.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('public/components/Ionicons/css/ionicons.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('public/components/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('public/components/pace/css/pace.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('public/components/toastr/build/toastr.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('public/components/sweetalert/sweetalert.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('public/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('public/css/skins/skin-blue-light.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('public/css/custom.css')}}">
  @yield('styles')
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  @include('includes.header')
  @include('includes.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      @yield('content')
  </div>
  <!-- /.content-wrapper -->
  @include('includes.footer')
</div>
<!-- ./wrapper -->
<script type="text/javascript" src="{{asset('public/components/jquery/dist/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/components/pace/pace.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/components/toastr/build/toastr.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/components/sweetalert/sweetalert.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/components/moment/moment.js')}}"></script>
<script type="text/javascript" src="{{asset('public/components/moment/moment-timezone-with-data.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/clock.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/adminlte.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/custom.js')}}"></script>
@yield('scripts')
<script type="text/javascript">
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('.sidebar-menu').tree();
    toastr.options.timeOut = 3000;
  });

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(document).ajaxStart(function () {
    Pace.restart()
  });
</script>
@include('includes.modal')
@if(empty($settings->license_key))
  @include('settings.license_refresh')
  <script type="text/javascript">
    $(window).on('load',function(){
        $('#modal-refresh-license').modal('show');
    });
  </script>
@endif
</body>
</html>
