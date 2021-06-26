@php 
session_start();
$_SESSION['mc_user_id'] = Auth::user()->id;
@endphp
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset('public/components/toastr/build/toastr.min.css')}}">
<link rel="stylesheet" href="{{('/')}}mc_builder/dist/css/editor.css">
<link rel="stylesheet" href="{{('/')}}mc_builder/dist/css/custom.css">
<link rel="stylesheet" href="{{('/')}}builder/mc_builder_2/style/grapes.min.css">
<link rel="stylesheet" href="{{('/')}}builder/mc_builder_2/style/material.css">
<link rel="stylesheet" href="{{('/')}}builder/mc_builder_2/style/tooltip.css">
<link rel="stylesheet" href="{{('/')}}builder/mc_builder_2/style/toastr.min.css">
<link rel="stylesheet" href="{{('/')}}builder/mc_builder_2/style/grapesjs-preset-newsletter.css">
<link rel="stylesheet" type="text/css" href="{{asset('public/components/sweetalert/sweetalert.css')}}">

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{('/')}}builder/mc_builder_2/dist/grapes.min.js"></script>
<script src="{{('/')}}builder/mc_builder_2/dist/grapesjs-preset-newsletter.min.js"></script>
<script src="{{asset('public/components/toastr/build/toastr.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/components/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('public/components/ckeditor/ckeditor.js')}}"></script>
<script src="{{('/')}}builder/mc_builder_2/dist/grapesjs-plugin-ckeditor.min.js"></script>
<style>body, html{ height: 100%; margin: 0;}</style>
<?php
$images = [];
$path_templates = str_replace('[user-id]', Auth::user()->id, config('mc.path_templates'));
$images_folder=$path_templates.DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR;
if(is_dir($images_folder)) {
  $files = scandir($images_folder);
  foreach($files as $file) {
    if($file != '.' && $file != '..') {
      $url = url('/')."/storage/users/".Auth::user()->id."/templates/images/".$file;
      array_push($images, $url);
    }
  }
}
?>
<body>
  <div class="form-group col-md-6">
    <input type="text" class="form-control" id="template-name" name="name" value="{{ Helper::decodeString($name) ?? '' }}" placeholder="{{ __('app.name') }}">
    <input type="hidden" id='action' name="action" value="{{$action}}">
    <input type="hidden" id='id' name="id" value="{{$id}}">
  </div>
  <br>
  <div id="gjs">
    {!! !empty($html) ? $html : '' !!}
  </div>
<span id="clean-canvas" data-value="{{__('app.clean_canvas')}}"></span>
<span id="builder-msg-name-required" data-value="{{__('app.builder_msg_name_required')}}"></span>
<span id="msg-saved" data-value="{{__('app.msg_saved')}}"></span>
<span id="builder-mgs-cancel" data-value="{{__('app.builder_mgs_cancel')}}"></span>
</body>
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var images_array = <?php echo json_encode($images); ?>;
</script>
<script src="{{asset('public/js/template2.js')}}"></script>