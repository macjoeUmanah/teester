@extends('layouts.app')
@section('title', __('app.add_new_user'))

@section('scripts')
<script>
$("#modal").on("hidden.bs.modal", function () {
  dropdownDB('role-id', "{{route('get_roles', ['return_type' => 'json'])}}");
});
</script>
@endsection
@section('content')
<section class="content-header">
  <h1>{{ __('app.add_new_user') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li><a href="{{ route('users.index') }}">{{ __('app.users') }}</a></li>
    <li class="active">{{ __('app.add_new_user') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('includes.msgs')
  <div class="box box-default">
    <!-- form start -->
    <form class="form-horizontal" id="frm-user">
      @csrf
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.role') }} 
            <a href="javascript:;" onclick="viewModal('modal', '{{ route('role.create') }}')">
              <i class="fa fa-plus-square-o"></i>
            </a>
          </label>
          <div class="col-md-6">
            <select name="role_id" id="role-id" class="form-control">
              @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
              @endforeach
            </select>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.name') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="name" value="" placeholder="{{ __('app.name') }}">
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.email') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <input type="email" class="form-control" name="email" value="" placeholder="{{ __('app.email') }}">
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.password') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <input type="password" class="form-control" name="password" placeholder="{{ __('app.leave_blank') }}">
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.confirm_password') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <input type="password" class="form-control" name="password_confirmation" placeholder="{{ __('app.confirm_password') }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.address') }}</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="address" value="" placeholder="{{ __('app.address') }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.country') }}</label>
          <div class="col-md-6">
            <select name="country_code" class="form-control">
              @foreach(\Helper::countries() as $code => $name)
                <option value="{{ $code }}">{{ $name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.phone') }}</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="phone" value="" placeholder="{{ __('app.phone') }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.time_zone') }}</label>
          <div class="col-md-6">
            <select name="time_zone" class="form-control">
              @foreach(\Helper::timeZones() as $key => $time_zone)
                <option value="{{ $key }}">{{ $time_zone }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.language') }}</label>
          <div class="col-md-6">
            <select name="language" class="form-control">
              @foreach(\Helper::languages() as $key => $language)
                <option value="{{ $key }}">{{ $language }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
            <button type="button" class="btn btn-primary loader" onclick="submitData(this, this.form, 'POST', '{{ route('user.store') }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
            <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('user.store') }}', 1)" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save_add_new') }}">{{ __('app.save_add_new') }}</button>
            <button type="button" class="btn btn-default" onclick="exit()">{{ __('app.exit') }}</button>
          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </form>
  </div>
  <!-- /.box -->
</section>
<!-- /.content -->
@endsection
