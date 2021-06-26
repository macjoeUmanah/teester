@extends('layouts.app')
@section('title', __('app.add_new_list'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.add_new_list') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li><a href="{{ route('lists.index') }}">{{ __('app.lists') }}</a></li>
    <li class="active">{{ __('app.add_new_list') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box box-default">
    <!-- form start -->
    <form class="form-horizontal" id="frm-list">
      @csrf
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.group') }}
            <a href="javascript:;" onclick="viewModal('modal', '{{route('group.create', ['type_id' => config('mc.groups.lists')])}}');">
              <i class="fa fa-plus-square-o"></i>
            </a>
            </label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="group_id" id="groups" class="form-control">
                @foreach($groups as $id => $group_name)
                  <option value="{{ $id }}">{{Helper::decodeString($group_name)}}</option>
                @endforeach
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_group') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.list_name') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" class="form-control" name="name" value="" placeholder="{{ __('app.list_name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.sending_server') }}
            <a tabindex="-1" href="{{ route('sending_server.create') }}">
              <i class="fa fa-plus-square-o"></i>
            </a>
          </label>
          <div class="col-md-6">
            <div class="input-group from-group">
              @include('includes.one_select_dropdown_sending_server')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_sending_server') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">
            {{ __('app.custom_fields') }}
            <a tabindex="-1" href="javascript:;" onclick="viewModal('modal', '{{ route('custom_field.create', ['multiselect' => 1]) }}');">
              <i class="fa fa-plus-square-o"></i>
            </a>
          </label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select id="custom-fields" name="custom_fields[]" multiple="multiple">
                @foreach($custom_fields as $id => $custom_field)
                  <option value="{{ $id }}">{{ $custom_field }}</option>
                @endforeach
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_custom_fileds') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.double_optin') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="double_optin" id="double-optin" class="form-control">
                <option value="No">{{ __('app.no')}}</option>
                <option value="Yes">{{ __('app.yes') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_double_optin') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group" id="confirmation-email-data" style="display: none;">
          <label class="col-md-2 control-label">{{ __('app.email') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="confirmation_email_id" class="form-control">
                @foreach($emails as $id => $email)
                  <option value="{{$id}}" {{$id == '3' ? 'selected' : ''}}>{{ $email }}</option>
                @endforeach
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_confirmation_email_id') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.welcome_email') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="welcome_email" id="welcome-email" class="form-control">
                <option value="No">{{ __('app.no')}}</option>
                <option value="Yes">{{ __('app.yes') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_welcome_email') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group" id="welcome-email-data" style="display: none;">
          <label class="col-md-2 control-label">{{ __('app.email') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="welcome_email_id" class="form-control">
                @foreach($emails as $id => $email)
                  <option value="{{$id}}" {{$id == '1' ? 'selected' : ''}}>{{ $email }}</option>
                @endforeach
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_welcome_email_id') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.unsub_email') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="unsub_email" id="unsub-email" class="form-control">
                <option value="No">{{ __('app.no')}}</option>
                <option value="Yes" selected="selected">{{ __('app.yes') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_unsub_email') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group" id="unsub-email-data">
          <label class="col-md-2 control-label">{{ __('app.email') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="unsub_email_id" class="form-control">
                @foreach($emails as $id => $email)
                  <option value="{{$id}}" {{$id == '7' ? 'selected' : ''}}>{{ $email }}</option>
                @endforeach
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_unsub_email_id') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.notification') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="notification" id="notification" class="form-control">
                <option value="Disabled">{{ __('app.disabled')}}</option>
                <option value="Enabled">{{ __('app.enabled') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_notification') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group" style="display: none;" id="notify-email">
          <label class="col-md-2 control-label">{{ __('app.notify_email') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group">
              <input type="email" class="form-control" name="notify_email" value="" placeholder="{{ __('app.notify_email') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_notification_email') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group" style="display: none;" id="notify-criteria-div">
          <label class="col-md-2 control-label">{{ __('app.notify_criteria') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select id="notify-criteria" name="notify_criteria[]" multiple="multiple">
                <option value="app">{{ __('app.list_contact_added_app') }}</option>
                <option value="api">{{ __('app.list_contact_added_api') }}</option>
                <option value="webform">{{ __('app.list_contact_added_webform') }}</option>
                <option value="confirm">{{ __('app.list_contact_confirmed') }}</option>
                <option value="unsub">{{ __('app.list_contact_unsubscribed') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_notification_criteria') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
            <button type="button" class="btn btn-primary loader" onclick="submitData(this, this.form, 'POST', '{{ route('list.store') }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
            <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('list.store') }}', 1)" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save_add_new') }}">{{ __('app.save_add_new') }}</button>
            <button type="button" class="btn btn-danger" onclick="exit()">{{ __('app.exit') }}</button>
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
