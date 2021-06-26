<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ __('app.reset_password') }} - {{ $settings->app_name }}</title>
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
        <form method="post" action="{{ route('password.update') }}" name="signin">
          <input type="hidden" name="token" value="{{ $token }}">
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
          @if ($errors->has('password_confirmation'))
            <div class="form-group">
              <span class="text-red" role="alert">
                {{ $errors->first('password_confirmation') }}
              </span>
            </div>
          @endif
          <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="text" placeholder="{{ __('app.login_email_address') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" autofocus>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
            <input id="password" type="password" placeholder="{{ __('app.password') }}" class="form-control" name="password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <input id="password-confirm" type="password" placeholder="{{ __('app.confirm_password') }}" class="form-control" name="password_confirmation">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-md-offset-8 col-md-4">
              <button type="submit" id="btn-submit" class="btn btn-primary btn-block btn-auth" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.submit') }}">{{ __('app.submit') }}</button>
            </div>
          </div>
        </form>
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
<script src="{{asset('public/js/custom.js')}}"></script>
</body>
</html>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
