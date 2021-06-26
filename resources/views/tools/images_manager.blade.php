@php
session_start();
$_SESSION['user_id'] = Auth::user()->id; // will be us in mc_imageuploader
$_SESSION['lang'] = Auth::user()->language // will be us in mc_imageuploader
@endphp
@extends('layouts.app')
@section('title', __('app.tools_images_manager'))
@section('content')
<section class="content-header">
  <h1>{{ __('app.tools_images_manager') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li class="active">{{ __('app.tools') }}</li>
    <li class="active">{{ __('app.tools_images_manager') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="form-group col-md-12">
        <iframe src="{{$settings->app_url}}/public/components/ckeditor/plugins/mc_uploader/uploader.php?CKEditor=content_html&CKEditorFuncNum=0&langCode=en" frameborder="yes" border="1" scrolling="yes" width="100%" class="image-manager"></iframe>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
</section>
<!-- /.content -->
@endsection