<link rel="stylesheet" href="{{asset('public/components/iCheck/flat/blue.css')}}">
<script src="{{asset('public/components/iCheck/icheck.min.js')}}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      increaseArea: '20%' /* optional */
    });
    $('#backup').on('click', function() {
      toastr.success("{{ __('app.msg_backup') }}");
    });
  });
</script>
<div class="modal-content">
  <form class="form-horizontal" id="frm-group">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">{{ __('app.tools_backup') }}</h4>
    </div>
    <div class="modal-body">
      
      <div class="box-body">
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox" name="backup_db" value="db" checked="checked"> {{ __('app.database') }}
              </label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox" name="backup_files" value="files" checked="checked"> {{ __('app.files') }}
              </label>
            </div>
          </div>
        </div>
      </div>
      
    </div>
    <div class="modal-footer">
      <button type="button" id="backup" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('backup') }}', 0, 0);" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.start_backup') }}">{{ __('app.start_backup') }}</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
    </div>
  </form>
</div>