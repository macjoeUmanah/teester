<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
<form class="form-horizontal" id="frm-split">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ __('app.send_email') }}</h4>
  </div>
  <div class="modal-body">
    <div class="box-body">
      <div class="form-group">
        <label class="col-md-3 control-label">{{ __('app.email') }} <span class="required">*</span></label>
        <div class="col-md-6">
          <div class="input-group from-group">
            <input type="email" name="email" class="form-control">
            <div class="input-group-addon input-group-addon-right">
              <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.test_send_email') }}"></i>
            </div>
          </div>
        </div>
        <span></span>
      </div>
      @if(!empty($broadcast_id) || !empty($template_id))
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.setup_sending_servers') }} 
            <a href="{{ route('sending_server.create') }}">
              <i class="fa fa-plus-square-o"></i>
            </a>
          </label>
          <div class="col-md-6">
            <div class="input-group from-group">
              @include('includes.one_select_dropdown_sending_server')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.test_send_sending_server') }}"></i>
              </div>
            </div>
          </div>
      </div>
      @else
        <input type="hidden" name="sending_server_id" value="{{ $sending_server_id }}">
      @endif
      <div class="form-group">
        <div class="col-md-offset-3 col-md-8" id="msg"></div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <input type="hidden" name="broadcast_id" value="{{ $broadcast_id }}">
    <input type="hidden" name="template_id" value="{{ $template_id }}">
    <button type="button" class="btn btn-primary loader" onclick="sendEmailTest(this, this.form)" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.send') }}">{{ __('app.send') }}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
  </div>
 
</div>
</form>