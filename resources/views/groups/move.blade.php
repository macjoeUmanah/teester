<!-- Model role -->
<form class="form-horizontal" id="frm-group_move">
  <div id="modal-group-move" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="modal-title-group"></h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.move_to') }}</label>
              <div class="col-md-9">
                <div class="input-group from-group">
                  <select name="group_id_new" id="groups-move" class="form-control">
                    @foreach($groups as $id => $group_name)
                    <option value="{{ $id }}">{{ $group_name }}</option>
                    @endforeach
                  </select>
                  <div class="input-group-addon input-group-addon-right">
                    <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.move_to_group') }}"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="form-group">
              <div class="col-md-offset-2 col-md-10">
                <input type="hidden" name="group_id_old" id="group-id-old" value="">
                <input type="hidden" name="move_id" id="move-id" value="">
                <button type="button" class="btn btn-primary" onclick="moveGroup(this)" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.move') }}">{{ __('app.move') }}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- /.modal -->