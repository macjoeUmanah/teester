<script>
  $("#modal").on("hidden.bs.modal", function () {
    dropdownDB('role-id', "{{route('get_roles', ['return_type' => 'json'])}}");
  });
</script>
<div class="modal-content">
  <form class="form-horizontal" id="frm-role" method="post" action="{{ route('roles_permissions.save.role') }}">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">{{ __('app.add_new_role') }}</h4>
    </div>
    <div class="modal-body">
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.name') }} <span class="required">*</span></label>
          <div class="col-md-9">
            <input type="text" class="form-control" name="name" value="" placeholder="{{ __('app.name') }}">
          </div>
          <span></span>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('roles_permissions.save.role') }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
      <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('roles_permissions.save.role') }}', 1)" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save_add_new') }}">{{ __('app.save_add_new') }}</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
    </div>
  </form>
</div>