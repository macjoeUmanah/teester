<script src="{{asset('public/js/custom.js')}}"></script>
<!-- Model -->
<div id="modal" class="modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" id="modal-data" ></div>
</div>
<!-- /.modal -->
<div class="modal-content">
<!-- Model -->
<div id="modal-refresh-license" class="modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" >
    <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="modal-title-group">{{ __('app.license_refresh') }}</h4>
    </div>
    <div class="modal-body">
      <form class="form-horizontal" id="frm-group_move">
        <div class="box-body">
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.license_key') }}</label>
          <div class="col-md-9" data-toggle="tooltip" title="{{ __('help.license_key') }}">
            <input type="text" class="form-control" id="license_key" name="license_key" value="{{ $settings->license_key }}" placeholder="{{ __('app.license_key') }}">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-3 col-md-9">
            <button type="button" class="btn btn-primary" id="btn-verify-license" data-route="{{ route('settings.license.verification') }}" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.refresh') }}">{{ __('app.refresh') }}</button>
            <span id="msg" class="text-red"></span>
          </div>
        </div>
      </div>
      </form>
    </div>
    </div>
  </div>
</div>
<!-- /.modal -->