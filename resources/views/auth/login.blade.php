<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ __('app.sign_in') }} - {{ $settings->app_name }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="stylesheet" href="{{asset('public/components/bootstrap/dist/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/components/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/css/custom.css')}}">
  <link rel="stylesheet" href="{{asset('public/components/iCheck/flat/blue.css')}}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="icon" href="{{url('/')}}/storage/app/public/favicon.ico" type="image/gif" sizes="16x16">
</head>
<body>
  <div class="col-md-4 hold-transition login-leftside">
    <div class="login-box">
      <div class="login-logo">
        {!! !empty(json_decode($settings->attributes)->login_html) ? json_decode($settings->attributes)->login_html : '' !!}
      </div>
      <div class="login-box-body page-content">
        <form method="post" action="{{ route('login') }}" name="signin">
          @csrf
          @if ($errors->has('email'))
            <div class="form-group">
              <span class="text-red" role="alert">
                {{ $errors->first('email') }}
              </span>
            </div>
          @endif
          @if ($errors->has('password'))
            <div class="form-group">
              <span class="text-red" role="alert">
                {{ $errors->first('password') }}
              </span>
            </div>
          @endif
          @if ($errors->has('active'))
            <div class="form-group">
              <span class="text-red" role="alert">
                {{ $errors->first('active') }}
              </span>
            </div>
          @endif
          <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="text" placeholder="{{ __('app.login_email_address') }}" class="form-control" name="email" value="{{ old('email') }}" autofocus>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
            <input id="password" type="password" placeholder="{{ __('app.password') }}" class="form-control" name="password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" name="remember" value="1" > {{ __('app.remember_me') }}
                </label>
              </div>
            </div>
            <div class="col-md-4">
              <button type="submit" id="btn-submit" class="btn btn-primary btn-block btn-auth" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.sign_in') }}">{{ __('app.sign_in') }}</button>
            </div>
          </div>
        </form>
        <div class="padding-top-50">
          <a href="{{ route('password.request') }}">{{ __('app.forgot_password') }}</a>
        </div>
      </div>
    </div>
  </div>
  @if(!empty(json_decode($settings->attributes)->login_image))
    <div id="login-image" class="col-md-8" style="background-color: {{!empty(json_decode($settings->attributes)->login_backgroud_color) ? json_decode($settings->attributes)->login_backgroud_color : '#dedede'}};">
      <img src="{{ json_decode($settings->attributes)->login_image }}">
    </div>
  @endif
<!-- /.login-box -->
<script src="{{asset('public/components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('public/components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/components/iCheck/icheck.min.js')}}"></script>
<script src="{{asset('public/js/custom.js')}}"></script>
<script>
$(function () {
  'use strict';
  $('input').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    increaseArea: '20%' /* optional */
  });
});
</script>
</body>
</html>