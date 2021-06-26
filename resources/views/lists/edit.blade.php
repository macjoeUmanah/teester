@extends('layouts.app')
@section('title', __('app.edit_list'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.edit_list') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li><a href="{{ route('lists.index') }}">{{ __('app.lists') }}</a></li>
    <li class="active">{{ __('app.edit_list') }}</li>
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
                  <option value="{{ $id }}" {{ ($id == $list->group_id) ? 'selected' : '' }}>{{ Helper::decodeString($group_name) }}</option>
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
              <input type="text" class="form-control" name="name" value="{{ Helper::decodeString($list->name) }}" placeholder="{{ __('app.list_name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.sending_server') }}
            <a href="{{ route('sending_server.create') }}">
              <i class="fa fa-plus-square-o"></i>
            </a>
            </label>
          <div class="col-md-6">
            <div class="input-group from-group">
              @php $sending_server_id = $list->sending_server_id @endphp
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
            <a href="javascript:;" onclick="viewModal('modal', '{{ route('custom_field.create', ['multiselect' => 1]) }}');">
              <i class="fa fa-plus-square-o"></i>
            </a>
          </label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select id="custom-fields" class="form-control width-100" name="custom_fields[]" multiple="multiple">
                @foreach($custom_fields as $id => $custom_field)
                  <option value="{{ $id }}" {{ (in_array($id, $list_custom_fields)) ? 'selected' : '' }}>{{ $custom_field }}</option>
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
                <option value="No" {{ $list->double_optin == 'No' ? 'selected="selected"' : '' }}>{{ __('app.no')}}</option>
                <option value="Yes" {{ $list->double_optin == 'Yes' ? 'selected="selected"' : '' }}>{{ __('app.yes') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_double_optin') }}"></i>
              </div>
            </div>
          </div>
        </div>
        @php $attributes = json_decode($list->attributes); @endphp
        <div class="form-group" id="confirmation-email-data" style="display: {{($list->double_optin == 'No') ? 'none' : ''}}">
          <label class="col-md-2 control-label">{{ __('app.email') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="confirmation_email_id" class="form-control">
                @foreach($emails as $id => $email)
                  <option value="{{$id}}" {{!empty($attributes->confirmation_email_id) && $attributes->confirmation_email_id == $id ? 'selected' : ($id == '3' ? 'selected' : '')}}>{{ $email }}</option>
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
              <select name="welcome_email" id="welcome-email"  class="form-control">
                <option value="No" {{ $list->welcome_email == 'No' ? 'selected="selected"' : '' }}>{{ __('app.no')}}</option>
                <option value="Yes" {{ $list->welcome_email == 'Yes' ? 'selected="selected"' : '' }}>{{ __('app.yes') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_welcome_email') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group" id="welcome-email-data" style="display: {{($list->welcome_email == 'No') ? 'none' : ''}}">
          <label class="col-md-2 control-label">{{ __('app.email') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="welcome_email_id" class="form-control">
                @foreach($emails as $id => $email)
                  <option value="{{$id}}" {{!empty($attributes->welcome_email_id) && $attributes->welcome_email_id == $id ? 'selected' : ($id == '1' ? 'selected' : '')}}>{{ $email }}</option>
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
                <option value="No" {{ $list->unsub_email == 'No' ? 'selected="selected"' : '' }}>{{ __('app.no')}}</option>
                <option value="Yes" {{ $list->unsub_email == 'Yes' ? 'selected="selected"' : '' }}>{{ __('app.yes') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_unsub_email') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group" id="unsub-email-data" style="display: {{($list->unsub_email == 'No') ? 'none' : ''}}">
          <label class="col-md-2 control-label">{{ __('app.email') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="unsub_email_id" class="form-control">
                @foreach($emails as $id => $email)
                  <option value="{{$id}}" {{!empty($attributes->unsub_email_id) && $attributes->unsub_email_id == $id ? 'selected' : ($id == '7' ? 'selected' : '')}}>{{ $email }}</option>
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
                <option value="Disabled" {{ $list->notification == 'Disabled' ? 'selected="selected"' : '' }}>{{ __('app.disabled')}}</option>
                <option value="Enabled" {{ $list->notification == 'Enabled' ? 'selected="selected"' : '' }}>{{ __('app.enabled') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_notification') }}"></i>
              </div>
            </div>
          </div>
        </div>
        @php $notification_attributes = json_decode($list->notification_attributes); @endphp
        <div class="form-group" style="{{ $list->notification == 'Disabled' ? 'display:none' : '' }}" id="notify-email">
          <label class="col-md-2 control-label">{{ __('app.notify_email') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group">
              <input type="email" class="form-control" name="notify_email" value="{{ $notification_attributes->email ?? '' }}" placeholder="{{ __('app.notify_email') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_notification_email') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group" style="{{ $list->notification == 'Disabled' ? 'display:none' : '' }}" id="notify-criteria-div">
          <label class="col-md-2 control-label">{{ __('app.notify_criteria') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select id="notify-criteria" name="notify_criteria[]" multiple="multiple">
                <option value="app" {{ !empty($notification_attributes->criteria) && in_array('app', $notification_attributes->criteria) ? 'selected="selected"' : '' }}>{{ __('app.list_contact_added_app') }}</option>
                <option value="api" {{ !empty($notification_attributes->criteria) && in_array('api', $notification_attributes->criteria) ? 'selected="selected"' : '' }}>{{ __('app.list_contact_added_api') }}</option>
                <option value="webform" {{ !empty($notification_attributes->criteria) && in_array('webform', $notification_attributes->criteria) ? 'selected="selected"' : '' }}>{{ __('app.list_contact_added_webform') }}</option>
                <option value="confirm" {{ !empty($notification_attributes->criteria) && in_array('confirm', $notification_attributes->criteria) ? 'selected="selected"' : '' }}>{{ __('app.list_contact_confirmed') }}</option>
                <option value="unsub" {{ !empty($notification_attributes->criteria) && in_array('unsub', $notification_attributes->criteria) ? 'selected="selected"' : '' }}>{{ __('app.list_contact_unsubscribed') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_notification_criteria') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
            <button type="button" class="btn btn-primary loader" onclick="submitData(this, this.form, 'PUT', '{{ route('list.update', ['id' => $list->id]) }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
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
