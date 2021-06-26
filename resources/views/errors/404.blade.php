<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>404 - {{ config('app.name') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="icon" href="{{url('/')}}/storage/app/public/favicon.ico" type="image/gif" sizes="16x16">
  <link rel="stylesheet" href="{{asset('public/components/bootstrap/dist/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/components/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/components/pace/css/pace.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/css/mailcarry.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/css/skins/skin-blue-light.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/css/custom.css')}}">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<div class="wrapper">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Main content -->
  <section class="content">
    <div class="error-page">
      <h2 class="headline text-yellow"> 404</h2>
          <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
          </div>
          <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('includes.footer')
</div>
<!-- ./wrapper -->
<script src="{{asset('public/components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('public/components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/components/pace/pace.min.js')}}"></script>
<script src="{{asset('public/js/mailcarry.min.js')}}"></script>
</body>
</html>

