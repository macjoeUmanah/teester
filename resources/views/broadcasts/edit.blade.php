@php
session_start();
$_SESSION['user_id'] = Auth::user()->id; // will be us in mc_imageuploader
$_SESSION['lang'] = Auth::user()->language // will be us in mc_imageuploader
@endphp
@extends('layouts.app')
@section('title', __('app.edit_broadcast'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/components/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('public/components/ckeditor/plugins/mc_uploader/plugin.js')}}"></script>
<script src="{{asset('public/js/broadcast.js')}}"></script>
<script>
$(function () {
  CKEDITOR.config.extraPlugins = 'mc_uploader,emoji';
});
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.edit_broadcast') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.campaigns') }}</li>
    <li><a href="{{ route('broadcasts.index') }}">{{ __('app.view_manage') }}</a></li>
    <li class="active">{{ __('app.edit_broadcast') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box box-default">
    <!-- form start -->
    <form class="form-horizontal" id="frm-broadcast">
      @csrf
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.group') }}
            <a href="javascript:;" onclick="viewModal('modal', '{{ route('group.create', ['type_id' => config('mc.groups.broadcasts')]) }}');">
              <i class="fa fa-plus-square-o"></i>
            </a>
            </label>
          <div class="col-md-8">
            <div class="input-group from-group">
             <select name="group_id" id="groups" class="form-control">
                @foreach($groups as $id => $group_name)
                  <option value="{{ $id }}" {{ $id == $broadcast->group_id ? 'selected="selected"' : '' }}>{{ Helper::decodeString($group_name) }}</option>
                @endforeach
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.broadcast_group') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.name') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
             <input type="text" class="form-control" name="name" value="{{ Helper::decodeString($broadcast->name) }}" placeholder="{{ __('app.name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.broadcast_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.email_subject') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
             <input type="text" class="form-control" name="email_subject" value="{{ Helper::decodeString($broadcast->email_subject) }}" placeholder="{{ __('app.email_subject') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.broadcast_email_subject') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.content_html') }}
            <div class="padding-top-10"></div>
            <button type="button" class="btn btn-primary btn-xs" onclick="viewModal('modal', '{{ route('shortcodes') }}');">{{ __('app.shortcodes') }}</button>
            <div class="padding-top-10"></div>
            <button type="button" class="btn btn-primary btn-xs" onclick="viewModal('modal', '{{ route('templates.all') }}');">Import Template</button>
          </label>
          <div class="col-md-8">
            <textarea class="form-control" name="content_html" id="content_html">{{ Helper::XSSReplaceTags(Helper::decodeString($broadcast->content_html)) }}</textarea>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.content_text') }}
            <div><a href="javascript:;" id="copy-as-text">{{ __('app.copy_as_text') }}</a></div>
          </label>
          <div class="col-md-8">
            <textarea class="form-control" name="content_text" id="content_text">{{ Helper::decodeString($broadcast->content_text) }}</textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
            <button type="button" class="btn btn-primary loader" onclick="CKupdate();submitData(this, this.form, 'PUT', '{{ route('broadcast.update', ['id' => $broadcast->id]) }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
            <button type="button" class="btn btn-success" onclick="viewModal('modal', '{{ route('send.email', ['broadcast_id' => $broadcast->id, 'sending_server_id' => 0, 'template_id' => 0]) }}');">{{ __('app.send_test_email') }}</button>
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
