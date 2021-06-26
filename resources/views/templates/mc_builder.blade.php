@php
session_start();
$_SESSION['mc_user_id'] = Auth::user()->id;
@endphp
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset('public/components/toastr/build/toastr.min.css')}}">
<link rel="stylesheet" href="{{asset('public/css/custom.css')}}">
<link rel="stylesheet" href="{{('/')}}mc_builder/dist/css/editor.css">
<link rel="stylesheet" href="{{('/')}}mc_builder/dist/css/custom.css">

<div id="email-builder">
  <!-- Main Sidebar -->
  <div class="sidebar-main">
    <ul class="nav" data-type="nav">
      <li class="nav-item active" data-nav="has-child">
        <span class="item"><i class="icon icon-sliders"></i> {{ __('app.builder_modules') }}</span>
        <ul class="subnav" data-type="subnav">
            <li class="subnav-item" data-target="modules">{{ __('app.builder_components') }}</li>
            <li class="subnav-item" data-target="styles">{{ __('app.builder_sytles') }}</li>
        </ul>
      </li>
      <li class="nav-item" data-nav="has-child">
        <span class="item"><i class="icon icon-download"></i> {{ __('app.builder_export') }}</span>
        <ul class="subnav" data-type="subnav">
            <li class="subnav-item" data-action="export-zip">{{ __('app.builder_zip') }}</li>
            <li class="subnav-item" data-action="export-html">{{ __('app.builder_html') }}</li>
        </ul>
      </li>
    </ul>
    <div class="sidebar-footer">
      <a class="btn btn-main btn-save" href="#">{{ __('app.builder_save') }}</a>
      <a class="btn btn-main btn-cancel" href="#">{{ __('app.builder_exit') }}</a>
    </div>
  </div>
  <!-- Main Container -->
  <div class="main-container">
    <!-- Second Sidebar -->
    <div class="sidebar-second" data-type="sidebar-second">
      <!-- Modules -->
      <div class="sidebar-inner" data-sidebar="modules">
        <div class="inner-content" data-type="modules-container"></div>
      </div>
      <!-- Styles -->
      <div class="sidebar-inner" data-sidebar="styles">
        <div class="inner-header"></div>
        <div class="inner-content">
            <div data-type="module-options"></div><!-- module-options -->
        </div>
      </div>
    </div>
    <!-- Holder Container -->
    <div class="holder-container">
        <div class="form-group col-md-6">
          <input type="text" class="form-control" id="template-name" name="name" value="{{ Helper::decodeString($name) ?? '' }}" placeholder="{{ __('app.name') }}">
          <input type="hidden" id='action' name="action" value="{{$action}}">
          <input type="hidden" id='id' name="id" value="{{$id}}">
        </div>
      <!-- Editor Container -->
      <div class="editor-container">
        <!-- Editor Area -->
        <div class="editor" id='editor' data-type="editor" style="overflow-y: auto;">
          {!! !empty($html) ? $html : '' !!}
        </div> <!-- /.editor -->
      </div>
      <div class="sidebar-top">
        <span class="item template-preview-mobile"><i class="icon-mobile"></i></span>
        <span class="item template-preview-tablet"><i class="icon-tablet"></i></span>
        <span class="item template-clear item-last"><i class="icon-close"></i> {{ __('app.builder_clear') }}</span>
      </div>
    </div>
  </div>
  <form id="export-form" action="{{ url('/') }}/mc_builder/server/_export.php" method="POST">
    <input type="hidden" name="type" value="html"/>
    <input class="templateHTML" type="hidden" name="templateHTML" />
  </form> <!-- / Template Export Form  -->
</div>

<div id="linkeditor" class="modal-container">
  <div class="input-group">
    <input class="input-control" type="text" data-link="text" value="" placeholder="Text">
    <input class="input-control" type="text" data-link="url" value="" placeholder="https://mailcarry.com">
  </div>
  <div class="modal-controls">
    <button class="modal-btn-cancel">{{ __('app.builder_cancel') }}</button>
    <button class="modal-btn-ok">{{ __('app.builder_ok') }}</button>
  </div>
</div>

<div id="imageeditor" class="modal-container">
  <div class="modal-container-inner">
    <div class="input-group">
      <input class="input-control" type="text" data-image="url" value="" placeholder="URL">
      <input class="input-control" type="text" data-image="alt" value="" placeholder="Alt">
      <input class="input-control input-control-small" type="text" data-image="width" value="" placeholder="Width">px X
      <input class="input-control input-control-small" type="text" data-image="height" value="" placeholder="Height">px
    </div>
    <div>
      <div class="slim" id="modal-image-uploader">
        <input type="file" >
        <img src="" alt="" data-image="src">
      </div>
    </div>
  </div>
  <div class="modal-controls">
    <button class="modal-btn-cancel">{{ __('app.builder_cancel') }}</button>
    <button class="modal-btn-ok">{{ __('app.builder_ok') }}</button>
  </div>
</div>

<div id="bgeditor" class="modal-container">
  <div class="slim" id="modal-bg-uploader">
    <input type="file" >
    <img src="" alt="" data-image="src">
  </div>
  <div class="modal-controls">
    <button class="modal-btn-cancel">{{ __('app.builder_cancel') }}</button>
    <button class="modal-btn-ok">{{ __('app.builder_ok') }}</button>
  </div>
</div>
<span id="builder-msg-name-required" data-value="{{__('app.builder_msg_name_required')}}"></span>
<span id="msg-saved" data-value="{{__('app.msg_saved')}}"></span>
<span id="builder-mgs-cancel" data-value="{{__('app.builder_mgs_cancel')}}"></span>
<script src="{{('/')}}mc_builder/dist/js/editor.js"></script>
<script src="{{('/')}}mc_builder/dist/js/custom.js"></script>
<script src="{{asset('public/components/toastr/build/toastr.min.js')}}"></script>
<script src="{{asset('public/js/template1.js')}}"></script>
<script type="text/javascript">
var url = window.location.protocol+'//'+window.location.hostname;
var config = {
  host : url+"/resources",
  uploads : url+"/storage/users/{{Auth::user()->id}}/templates/images",
}
var emailBuilder = new $.EmailBuilder({theme: 'default'});
emailBuilder.init();
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
</script>
