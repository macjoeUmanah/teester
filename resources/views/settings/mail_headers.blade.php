@extends('layouts.app')
@section('title', __('app.settings_mail_headers'))

@section('styles')

@endsection

@section('scripts')
<script src="{{asset('public/components/jquery-repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('public/js/custom.js')}}"></script>
<script type="text/javascript">
$(function() {
  $('.repeater-contact').repeater({
    show: function () {
      $(this).slideDown();
    },
    hide: function (deleteElement) {
      if(confirm("{{ __('app.msg_delete_repeater_element') }}")) {
        $(this).slideUp(deleteElement);
      }
    },
    isFirstItemUndeletable: true
  });
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
  <h1>{{ __('app.settings_mail_headers') }}
  	<button type="button" class="btn btn-primary loader" onclick="viewModal('modal', '{{ route('shortcodes') }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.shortcodes') }}">{{ __('app.shortcodes') }}</button> <input type="text" id="shortcode" value="" style="border: none; width: 1px; background: #ECF0F5;"> &nbsp;&nbsp;{!! __('help.mail_headers') !!}
	</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.settings') }}</li>
    <li class="active">{{ __('app.settings_mail_headers') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box box-default">
    <!-- form start -->
    <form class="form-horizontal" id="frm-mail-headers">
      @csrf
      @method('PUT')
      <div class="box-body">
	     <div class="row box-body" style="padding-top: 10px;">
          <label class="col-md-4">{{ __('app.header_name') }}</label>
          <label class="col-md-1 control-label">:</label>
          <label class="col-md-4">{{ __('app.header_value') }}</label>
        </div>
	      <div class="box-body repeater-contact">
	        <div data-repeater-list="mail_headers">
	        	@if(!empty($mail_headers))
	        		@foreach($mail_headers as $key => $value)
			          <div data-repeater-item class="row" style="padding-top: 10px;">
			            <div class="col-md-4">
			              <input type="text" class="form-control" name="key" value="{{ Helper::decodeString($key) }}">
			            </div>
			            <label class="col-md-1 control-label">:</label>
			            <div class="col-md-4">
			              <input type="text" class="form-control" name="value" value="{{ Helper::decodeString($value) }}">
			            </div>
			            <div class="col-md-3">
			              <input data-repeater-delete type="button" class="btn btn-primary" value="Delete"/>
			            </div>
			          </div>
		          @endforeach
		        @else
		        	<div data-repeater-item class="row" style="padding-top: 10px;">
		            <div class="col-md-4">
		              <input type="text" class="form-control" name="key" value="">
		            </div>
		            <label class="col-md-1 control-label">:</label>
		            <div class="col-md-4">
		              <input type="text" class="form-control" name="value" value="">
		            </div>
		            <div class="col-md-3">
		              <input data-repeater-delete type="button" class="btn btn-primary" value="Delete"/>
		            </div>
		          </div>
	          @endif
	        </div>
	        <div class="col-md-12 row" style="margin-top: 10px;">
	          <input data-repeater-create type="button" class="btn btn-primary" value="Add"/>
	        </div>
	      </div>

	      <div class=" box-body  form-group">
          <div class="col-md-12">
            <button type="button" class="btn btn-primary loader" onclick="submitData(this, this.form, 'POST', '{{ route('settings.mail.headers') }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
          </div>
        </div>
    	</div>
    </form>
  </div>
  <!-- /.box-body -->
</section>
<!-- /.content -->
@endsection
