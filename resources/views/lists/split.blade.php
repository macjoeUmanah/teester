<script src="{{asset('public/js/custom.js')}}"></script>
<form class="form-horizontal" id="frm-split">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ __('app.list_split') }} ({{ $list->name }})</h4>
  </div>
  <div class="modal-body">
    <div class="box-body">
      <div class="form-group">
        <label class="col-md-3 control-label">{{ __('app.no_of_lists') }} <span class="required">*</span></label>
        <div class="col-md-6">
          <div class="input-group from-group">
            <input type="number" name="no_of_lists" class="form-control" min="0">
            <div class="input-group-addon input-group-addon-right">
              <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_split') }}"></i>
            </div>
          </div>
        </div>
        <span></span>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-primary loader" onclick="submitData(this, this.form, 'POST', '{{ route('list.split', ['id' => $list->id]) }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.spliting') }}">{{ __('app.split') }}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
  </div>
</div>
</form>