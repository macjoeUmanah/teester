@extends('layouts.app')
@section('title', __('app.templates'))
@section('scripts')
<script>
$(function () {
  'use strict';
  $(".modal").on("hidden.bs.modal", function() {
    document.getElementById("shortcode").select();
    document.execCommand("copy");
    $('.btn-primary').focus();
  });
});
</script>
@endsection
@section('content')
<section class="content-header">
  <h1>{{ __('app.template_builder') }} <button type="button" class="btn btn-primary loader" onclick="viewModal('modal', '{{ route('shortcodes') }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.shortcodes') }}">{{ __('app.shortcodes') }}</button> <input type="text" id="shortcode" value="" class="template-shortcode"></h1>

  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li><a href="{{ route('templates.index') }}">{{ __('app.templates') }}</a></li>
    <li class="active">{{ __('app.add_new_template_2') }}</li>
  </ol>
 
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="form-group col-md-12">
        <iframe src="/get_mc_builder_2?id={{$id ?? 0}}&action={{$action ?? 'create'}}" frameborder="yes" border="1" scrolling="yes" height="820" width="100%"></iframe>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
</section>
<!-- /.content -->
@endsection
