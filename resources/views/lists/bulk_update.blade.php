<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
<link rel="stylesheet" href="{{asset('public/css/custom.css')}}">
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/js/bulk_update.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
<div class="modal-content">
  <form class="form-horizontal" id="frm-group">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">{{ __('app.bulk_update') }}</h4>
    </div>
    <div class="modal-body">

      <div class="box-body">
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.based_on') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <select name="based_on" id="based-on" class="form-control">
                <option value="global">{{ __('app.global') }}</option>
                <option value="list">{{ __('app.lists') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.bulk_update_based_on') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group based-on-list" style="display: none;">
          <label class="col-md-3 control-label">{{ __('app.lists') }}
            <a href="{{ route('list.create') }}">
              <i class="fa fa-plus-square-o"></i>
            </a>
            <span class="required">*</span>
          </label>
          <div class="col-md-8">
            <div class="input-group from-group">
              @include('includes.multi_select_dropdown_list')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.bulk_update_lists') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group based-on-global">
          <label class="col-md-3 control-label">{{ __('app.option') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <select name="option" id="option" class="form-control">
                <option value="write">{{ __('app.suppress_write_email_addresses') }}</option>
                <option value="file">{{ __('app.file') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.bulk_update_option') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group based-on-global" id="section-emails">
          <label class="col-md-3 control-label">{{ __('app.email_addresses') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <textarea class="form-control" name="emails" rows="8" placeholder="{{ __('app.enter_comma_placeholder') }}"></textarea>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.bulk_update_emails') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group" id="section-file">
          <label class="col-md-3 control-label">{{ __('app.file') }}</label>
          <div class="col-md-8" data-toggle="tooltip" title="{{ __('help.bulk_update_file') }}">
            <div class="input-group from-group col-md-12">
              <input type="file" id="file" name="file" class="form-control filestyle" data-buttonText="{{ __('app.contact_import_browse') }}" data-buttonBefore="true">
              <div class="input-group-addon input-group-addon-right">
                <a href="javascript:;"><i class="fa fa-eraser text-danger" id="clear" title="{{__('app.clear')}}"></i></a>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="col-md-offset-3 col-md-9" id="info-filesize">
          {!! \Helper::getMaxFileSize(false, true) !!}
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.action') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <select name="action" id="action" class="form-control" >
                <option value="active">Set as Active</option>
                <option value="inactive">Set as Inactive</option>
                <option value="confirmed">Set as Confirmed</option>
                <option value="unconfirmed">Set as Unconfirmed</option>
                <option value="subscribed">Set as Subscribed</option>
                <option value="unsubscribed">Set as Unsubscribed</option>
                <option value="verified">Set as Verified</option>
                <option value="unverified">Set as Unverified</option>
                <option value="HTML">Set format as HTML</option>
                <option value="Text">Set as Text</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.bulk_update_action') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>

      </div>

    </div>
    <div class="modal-footer">
      <div class="form-group">
        <div class="col-md-offset-3 col-md-9">
          <button id="btn-save" type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('bulk_update.post') }}', 0, 0, 0, '{{ __('app.msg_update') }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.update') }}</button>
          <button id="btn-import" type="button" class="btn btn-primary" onclick="importBulkUpdate(this, this.form);" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.import') }}">{{ __('app.import') }}</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button>
        </div>
      </div>
    </div>
  </form>
</div>