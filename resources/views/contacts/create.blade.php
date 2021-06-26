@extends('layouts.app')
@section('title', __('app.add_new_contact'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
<script src="{{asset('public/js/common.js')}}"></script>
@if($list_id)<script>loadListCustomFields('{{ $list_id }}');</script>@endif
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.add_new_contact') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li><a href="{{ route('contacts.index') }}">{{ __('app.contacts') }}</a></li>
    <li class="active">{{ __('app.add_new_contact') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- form start -->
  <form class="form-horizontal" id="frm-contact">
    <div class="box box-default margin-bottom-0">
      @csrf
      <div class="box-header">
        <h3 class="box-title">{{ __('app.basic_info') }}</h3>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.list') }}<span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
              @include('includes.one_select_dropdown_list')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.contact_list') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.contact_email') }}<span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <input type="email" class="form-control" name="email" value="" placeholder="{{ __('app.contact_email') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.contact_email') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
            <a href="#" data-toggle="tooltip" title="{{ __('help.contact_html') }}">
              <input class="form-control" type="checkbox" name="format" data-toggle="toggle" data-size="small" data-on="{{ __('app.html') }}" data-off="{{ __('app.text') }}" checked="checked" >
            </a>&nbsp;&nbsp;
            <a href="#" data-toggle="tooltip" title="{{ __('help.contact_active') }}">
              <input class="form-control" type="checkbox" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.active') }}" data-off="{{ __('app.inactive') }}" checked="checked">
            </a>&nbsp;&nbsp;
            <a href="#" data-toggle="tooltip" title="{{ __('help.contact_confirmed') }}">
              <input class="form-control" type="checkbox" name="confirmed" data-toggle="toggle" data-size="small" data-on="{{ __('app.confirmed') }}" data-off="{{ __('app.unconfirmed') }}">
            </a>&nbsp;&nbsp;
            <a href="#" data-toggle="tooltip" title="{{ __('help.contact_verified') }}">
              <input class="form-control" type="checkbox" name="verified" data-toggle="toggle" data-size="small" data-on="{{ __('app.verified') }}" data-off="{{ __('app.unverified') }}">
            </a>&nbsp;&nbsp;
            <a href="#" data-toggle="tooltip" title="{{ __('help.contact_unsubscribed') }}">
              <input class="form-control" type="checkbox" name="unsubscribed" data-toggle="toggle" data-size="small" data-on="{{ __('app.subscribe') }}" data-off="{{ __('app.unsubscribed') }}" checked="checked">
            </a>&nbsp;&nbsp;
          </div>
        </div>
      </div>
    </div>
    <!-- /.box-body -->

    <div class="box box-default">
      <div class="box-header">
        <h3 class="box-title">{{ __('app.custom_fields') }}</h3>
      </div>
        <div class="box-body" id="list_custom_fields">
          <div class="col-md-offset-2 col-md-10">
            <h3>{{ __('app.none') }}</h3>
          </div>
      </div>
    </div>
    <!-- /.box-body -->

    <div class="form-group">
      <div class="col-md-offset-2 col-md-10">
        <button type="button" class="btn btn-primary loader" onclick="submitData(this, this.form, 'POST', '{{ route('contact.store') }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
        <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('contact.store') }}', 1)" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save_add_new') }}">{{ __('app.save_add_new') }}</button>
        <button type="button" class="btn btn-danger" onclick="exit()">{{ __('app.exit') }}</button>
      </div>
    </div>
  </form>
</section>
<!-- /.content -->
@endsection
