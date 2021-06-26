<script src="{{asset('public/components/bootstrap-filestyle/src/bootstrap-filestyle.min.js')}}"></script>
<script>
$(function () {
  $('#clear').click(function() {
    $(":file").filestyle('clear');
  });
});
</script>
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title">{{ __('app.import_blacklist') }}</h4>
</div>
<div class="modal-body">
  <form class="form-horizontal" id="frm-group">
    <div class="box-body">
      <div class="col-md-offset-2 col-md-9">
      {{!! \Helper::getMaxFileSize(false, true) !!}
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">{{ __('app.file') }}</label>
      <div class="col-md-9">
        <div class="input-group from-group col-md-12">
          <input type="file" id="file" name="file" class="form-control filestyle" data-buttonText="{{ __('app.contact_import_browse') }}" data-buttonBefore="true">
          <div class="input-group-addon input-group-addon-right">
            <a href="javascript:;"><i class="fa fa-eraser text-danger" id="clear" title="{{__('app.clear')}}"></i></a>
          </div>
        </div>
      </div>
      <span></span>
    </div>

    <div class="box box-default" id="fields-mapping" style="display: none;">
      <div class="box-header">
        <h3 class="box-title">{{ __('app.fields_mapping') }}</h3>
      </div>
      <div class="box-body" id="bounce-fields">
      </div>
    </div>

    <div class="form-group">
      <div class="col-md-offset-2 col-md-10">
        <button type="button" class="btn btn-primary loader" id="btn-proceed" onclick="bouncesImport(this, this.form, '{{ route('global.bounced.import') }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.proceed') }}">{{ __('app.proceed') }}</button>
        <button type="button" class="btn btn-primary loader" id="btn-import" style="display: none;" onclick="doBouncesImport(this, this.form, '{{ route('global.bounced.import') }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.import') }}" id='exit'>{{ __('app.import') }}</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button>
      </div>
    </div>

  </div>
  </form>
</div>
</div>