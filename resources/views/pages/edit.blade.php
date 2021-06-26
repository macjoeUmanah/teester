@extends('layouts.app')
@section('title', __('app.edit_page'))

@section('scripts')
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
  <h1>{{ __('app.edit_page') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.pages_emails') }}</li>
    <li class="active">{{ __('app.edit_page') }}</li>
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
          <label class="col-md-2 control-label">{{ __('app.name') }} <span class="required">*</span></label>
          <div class="col-md-7">
            <div class="input-group from-group">
              @if($page_email->type == 'Email')
                <input type="text" class="form-control" name="name" value="{{ $page_email->name ?? '' }}" placeholder="{{ __('app.name') }}">
              @else
                <label class="form-control">{{ $page_email->name }}</label>
              @endif
              <input type="hidden" name="p" value="{{ $page_email->name }}" >
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.page_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        @if($page_email->type != 'Page')
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.email_subject') }} <span class="required">*</span></label>
          <div class="col-md-7">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="email_subject" value="{{ Helper::decodeString($page_email->email_subject) }}" placeholder="{{ __('app.email_subject') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.page_email_subject') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        @else
          <input type="hidden" class="form-control" name="email_subject" value="no-subject">
        @endif
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.page_content') }}
            <br />
            <button type="button" class="btn btn-primary btn-xs" onclick="viewModal('modal', '{{ route('shortcodes') }}');">{{ __('app.shortcodes') }}</button>
            <div class="padding-top-10"></div>
            <button type="button" class="btn btn-primary btn-xs" onclick="viewModal('modal', '{{ route('templates.all') }}');">Import Template</button>
          </label>
          <div class="col-md-7">
            <textarea class="form-control" name="content_html">{{ Helper::XSSReplaceTags(Helper::decodeString($page_email->content_html)) }}</textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
            <button type="button" class="btn btn-primary loader" onclick="CKupdate();submitData(this, this.form, 'PUT', '{{ route('page.update', ['id' => $page_email->id]) }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
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
@include('includes.modal')
@endsection
