<script src="{{asset('public/js/common.js')}}"></script>
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title">{{ __('app.add_new_group') }}</h4>
</div>
<div class="modal-body">
  <form class="form-horizontal" id="frm-group" method="post">
    <div class="box-body">
    <div class="form-group">
      <label class="col-md-2 control-label">{{ __('app.group_name') }} <span class="required">*</span></label>
      <div class="col-md-9">
        <div class="input-group">
          <input type="text" class="form-control" name="name" value="" placeholder="{{ __('app.group_name') }}">
          <div class="input-group-addon input-group-addon-right">
            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.group_name') }}"></i>
          </div>
        </div>
      </div>
      <span></span>
    </div>
    <div class="form-group">
      <input type="hidden" name="type_id" value="{{ $type_id }}" >
      <div class="col-md-offset-2 col-md-10">
        <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('group.save') }}');setTimeout(function(){dropdownDB('groups', '{{route('groups', ['type_id' => $type_id, 'return_type' => 'json'])}}');},3000)" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
        <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('group.save') }}', 1);setTimeout(function(){dropdownDB('groups', '{{route('groups', ['type_id' => $type_id, 'return_type' => 'json'])}}');},3000)" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save_add_new') }}">{{ __('app.save_add_new') }}</button>
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button></a>
      </div>
    </div>
  </div>
  </form>
</div>
</div>