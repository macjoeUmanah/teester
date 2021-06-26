<link rel="stylesheet" href="{{asset('public/components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script>
$(function () {
  $('#segments').multiselect({
    enableFiltering: true,
    buttonWidth: '100%',
    nonSelectedText: "{{ __('app.none_selected') }}"
  });
  $('#broadcasts').multiselect({
    enableFiltering: true,
    buttonWidth: '100%',
    nonSelectedText: "{{ __('app.none_selectedd') }}"
  });
  $('#sending-servers').multiselect({
    enableFiltering: true,
    buttonWidth: '100%',
    nonSelectedText: "{{ __('app.none_selected') }}"
  });
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ __('app.add_auto_followup') }}</h4>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" id="frm-group">
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.status') }}</label>
          <div class="col-md-3" data-toggle="tooltip" title="{{ __('help.auto_followup_status') }}">
            <input type="checkbox" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.active') }}" data-off="{{ __('app.inactive') }}" checked="checked">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.name') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="name" value="" placeholder="{{ __('app.name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.auto_followup_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.criteria') }}
            <a tabindex="-1" href="{{ route('segments.index') }}">
              <i class="fa fa-plus-square-o"></i>
            </a>
          </label>
          <div class="col-md-8">
            <div class="input-group from-group">
              @include('includes.one_select_dropdown_segment')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.auto_followup_segment') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.broadcast') }}
            <a tabindex="-1" href="{{ route('broadcast.create') }}">
              <i class="fa fa-plus-square-o"></i>
            </a>
          </label>
          <div class="col-md-8">
            <div class="input-group from-group">
              @include('includes.one_select_dropdown_broadcast')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.auto_followup_broadcast') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.sending_server') }}
            <a tabindex="-1" href="{{ route('sending_server.create') }}">
              <i class="fa fa-plus-square-o"></i>
            </a>
          </label>
          <div class="col-md-8">
            <div class="input-group from-group">
              @include('includes.one_select_dropdown_sending_server')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.auto_followup_sending_server') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <div class="col-md-offset-3 col-md-9">
            <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('auto_followup.store') }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
            <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('auto_followup.store') }}', 1);" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save_add_new') }}">{{ __('app.save_add_new') }}</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>