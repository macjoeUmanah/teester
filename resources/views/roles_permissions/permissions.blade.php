@extends('layouts.app')
@section('title', __('app.manage_permissions'))

@section('styles')
<style type="text/css">
ul {
  list-style-type: none;
}
</style>
@endsection
@section('scripts')
<script>
  $("#checkAll").click(function(){
      $('input:checkbox').not(this).prop('checked', this.checked);
  });
</script>
@endsection
@section('content')
<section class="content-header">
  <h1>{{ __('app.manage_permissions') }} <small>( {{ $role->name }} )</small></h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li><a href="{{ route('roles_permissions.index') }}">{{ __('app.roles') }}</a></li>
    <li class="active">{{ __('app.manage_permissions') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  @include('includes.msgs')
  <div class="box box-default">
    <!-- form start -->
    <form class="form-horizontal" id="frm-role-permissions" method="post" action="{{ route('user.store') }}">
      <input type="hidden" name="role_id" value="{{ $role->id }}">
        <div class="box-body">
          <input type="checkbox" id="checkAll" value="Select All"> <label>{{ __('app.select_all')}}</label>
          @foreach($permissions as $modules)
            @foreach($modules['modules'] as $module)
              <ul>
                <input type="checkbox" class="select-all" value="{{ \Illuminate\Support\Str::slug($module['title']) }}">
                <label>{{ $module['title'] }}</label>
                @foreach($module['permissions'] as $key => $permission)
                  <li style="padding-left: 10px;"><input type="checkbox" name="roles_permissions[]" class="{{ \Illuminate\Support\Str::slug($module['title']) }}" value="{{ $key }}" {{ $role_permissions->contains($key) ? 'checked' : '' }}> {{ $permission }}</li>
                @endforeach
              </ul>
            @endforeach
          @endforeach
          <div class="form-group">
            <div class="col-md-offset-1" style="padding-top: 20px;">
              <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('roles_permissions.save.permissions') }}')" id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
              <button type="button" class="btn btn-default" onclick="exit()">{{ __('app.exit') }}</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>
<!-- /.content -->
@endsection
