@extends('layouts.app')
@section('title', __('app.import_contacts'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script src="{{asset('public/components/bootstrap-filestyle/src/bootstrap-filestyle.min.js')}}"></script>
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
<script type="text/javascript">
$(function() {
  $("#lists").change(function () {
    $('#fields_mapping').hide();
    $('#btn-import').hide();
    $('#btn-proceed').show();
  });  
});
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.import_contacts') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li><a href="{{ route('contacts.index') }}">{{ __('app.contacts') }}</a></li>
    <li><a href="{{ route('contacts.import', ['list_id' => 0]) }}">{{ __('app.import_contacts') }}</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- form start -->
  <form class="form-horizontal" id="frm-contacts-import" enctype="multipart/form-data">
    <div class="box box-default">
      @csrf
      <div class="box-header">
        <h3 class="box-title">{{ __('app.basic_detail') }}</h3>
      </div>
      <div class="box-body">
        <div class="col-md-offset-2 col-md-10">
          {!! \Helper::getMaxFileSize(false, true) !!}
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.file') }}<span class="required">*</span>
          </label>
          <div class="col-md-6">
            <div class="input-group from-group col-md-12">
              <input type="file" id="file" name="file" class="form-control filestyle" data-buttonText="{{ __('app.contact_import_browse') }}" data-buttonBefore="true">
              <div class="input-group-addon input-group-addon-right">
                <a href="javascript:;"><i class="fa fa-eraser text-danger" id="clear" title="{{__('app.clear')}}"></i></a>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.list') }}<span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
              @include('includes.one_select_dropdown_list')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.contact_list_import') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.duplicates') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="duplicates" id="duplicates" class="form-control" >
                <option value="skip">{{ __('app.skip') }}</option>
                <option value="overwrite">{{ __('app.overwrite') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.contact_duplicate_import') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.suppressed') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="suppressed" id="suppressed" class="form-control" >
                <option value="allowed">{{ __('app.allowed') }}</option>
                <option value="not_allowed">{{ __('app.not_allowed') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.contact_suppressed_import') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.bounced') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="bounced" id="bounced" class="form-control" >
                <option value="allowed">{{ __('app.allowed') }}</option>
                <option value="not_allowed">{{ __('app.not_allowed') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.contact_bounced_import') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.options') }}</label>
          <div class="col-md-10">
            <a href="#" data-toggle="tooltip" title="{{ __('help.contact_html_import') }}">
              <input class="form-control" type="checkbox" id="format" name="format" data-toggle="toggle" data-size="small" data-on="{{ __('app.html') }}" data-off="{{ __('app.text') }}" checked="checked">
            </a>&nbsp;&nbsp;
            <a href="#" data-toggle="tooltip" title="{{ __('help.contact_active_import') }}">
              <input class="form-control" type="checkbox" id="active" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.active') }}" data-off="{{ __('app.inactive') }}" checked="checked">
            </a>&nbsp;&nbsp;
            <a href="#" data-toggle="tooltip" title="{{ __('help.contact_confirmed_import') }}">
              <input class="form-control" type="checkbox" id="confirmed" name="confirmed" data-toggle="toggle" data-size="small" data-on="{{ __('app.confirmed') }}" data-off="{{ __('app.unconfirmed') }}">
            </a>&nbsp;&nbsp;
            <a href="#" data-toggle="tooltip" title="{{ __('help.contact_unsubscribed_import') }}">
              <input class="form-control" type="checkbox" id="unsubscribed" name="unsubscribed" data-toggle="toggle" data-size="small" data-on="{{ __('app.subscribe') }}" data-off="{{ __('app.unsubscribed') }}" checked="checked">
            </a>&nbsp;&nbsp;
          </div>
        </div>
      </div>
    </div>
    <!-- /.box-body -->

    <div class="box box-default" id="fields-mapping" style="display: none;">
      <div class="box-header">
        <h3 class="box-title">{{ __('app.fields_mapping') }}</h3>
      </div>
      <div class="box-body" id="list-custom-fields">
      </div>
    </div>
    <!-- /.box-body -->

    <div class="box box-default" id="import-contacts" style="display: none;">
      <div class="box-header">
        <h3 class="box-title">{{ __('app.import_contacts') }}</h3>
      </div>
      <div class="box-body" id="processing">
        <label class="text-light-blue">{{ __('app.contact_import_msg') }}</label>
        <div class="progress progress-striped active" >
            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
        </div>
        <div class="form-group">
          <label class="col-md-1">{{ __('app.total') }}</label>
          <div id="total" class="col-md-6">0</div>
        </div>
        <div class="form-group">
          <label class="col-md-1">{{ __('app.processed') }}</label>
          <div id="processed" class="col-md-6">0</div>
        </div>
        <div class="form-group">
          <label class="col-md-1">{{ __('app.duplicates') }}</label>
          <div id="duplicates-data" class="col-md-6">0</div>
        </div>
        <div class="form-group">
          <label class="col-md-1">{{ __('app.invalids') }}</label>
          <div id="invalids" class="col-md-6">0</div>
        </div>
        <div class="form-group">
          <label class="col-md-1">{{ __('app.suppressed') }}</label>
          <div id="suppressed-data" class="col-md-6">0</div>
        </div>
        <div class="form-group">
          <label class="col-md-1">{{ __('app.bounced') }}</label>
          <div id="bounced-data" class="col-md-6">0</div>
        </div>
      </div>
    </div>
    <!-- /.box-body -->

    <div class="form-group">
      <div class="col-md-offset-2 col-md-10">
        <button type="button" class="btn btn-primary loader" id="btn-proceed" onclick="contactsImport(this, this.form, '{{ route('contacts.import', ['id' => $list_id]) }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.proceed') }}">{{ __('app.proceed') }}</button>
        <button type="button" class="btn btn-primary loader" id="btn-import" style="display: none;" onclick="doContactsImport(this.form, '{{ route('contacts.import', ['id' => $list_id]) }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.import') }}" id='exit'>{{ __('app.import') }}</button>
      </div>
    </div>
  </form>

</section>
<!-- /.content -->
@endsection
