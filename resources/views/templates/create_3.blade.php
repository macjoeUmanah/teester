@php
session_start();
$_SESSION['user_id'] = Auth::user()->id; // will be us in mc_imageuploader
$_SESSION['lang'] = Auth::user()->language // will be us in mc_imageuploader
@endphp
@extends('layouts.app')
@section('title', __('app.add_new_broadcast'))

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
  <h1>{{ __('app.create_new') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.campaigns') }}</li>
    <li class="active">{{ __('app.create_new') }}</li>
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
          <label class="col-md-2 control-label">{{ __('app.name') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="name" value="{{ !empty($template->name) ? Helper::decodeString($template->name) : '' }}" placeholder="{{ __('app.name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.name') }}"></i>
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
            <textarea class="form-control" name="content_html" id="content_html">{!! !empty($template->content) ? $template->content : '' !!}</textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
            <input type="hidden" value="3" name="type">
            <input type="hidden" value="{{$action}}" name="action">
            <input type="hidden" value="{{$id ?? null}}" name="id">
            <button type="button" class="btn btn-primary loader" onclick="CKupdate();submitData(this, this.form, 'POST', '{{ route('template.save') }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
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
