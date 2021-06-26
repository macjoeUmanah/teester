<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
<div class="modal-content">
  <form class="form-horizontal" id="frm-group">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">{{ __('app.edit_package') }}</h4>
    </div>
    <div class="modal-body">
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.name') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="name" value="{{ Helper::decodeString($package->name) ?? '' }}" placeholder="{{ __('app.name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.package_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.description') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <textarea class="form-control" name="description" rows="8" placeholder="{{ __('app.description') }}">{{ Helper::decodeString($package->description) ?? '' }}</textarea>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.package_description') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        @php $attributes = json_decode($package->attributes, true) @endphp
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.no_of_recipients') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
             <input type="number" class="form-control" name="no_of_recipients" value="{{ $attributes['no_of_recipients'] ?? '' }}" placeholder="-1">
             <div class="input-group-addon input-group-addon-right">
              <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.no_of_recipients') }}"></i>
            </div>
          </div>
        </div>
        <span></span>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">{{ __('app.no_of_sending_servers') }}</label>
        <div class="col-md-8">
          <div class="input-group from-group">
           <input type="number" class="form-control" name="no_of_sending_servers" value="{{ $attributes['no_of_sending_servers'] ?? '' }}" placeholder="-1">
           <div class="input-group-addon input-group-addon-right">
            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.no_of_sending_servers') }}"></i>
          </div>
        </div>
      </div>
      <span></span>
    </div>
    <div class="form-group">
      <label class="col-md-3 control-label">{{ __('app.lists') }}
        <a href="{{ route('list.create') }}">
          <i class="fa fa-plus-square-o"></i>
        </a>
      </label>
      <div class="col-md-8">
        <div class="input-group from-group">
          @php $list_ids = $attributes['list_ids'] @endphp
          @include('includes.multi_select_dropdown_list')
          <div class="input-group-addon input-group-addon-right">
            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.client_lists') }}"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-3 control-label">{{ __('app.sending_server') }}
        <a href="{{ route('sending_server.create') }}">
          <i class="fa fa-plus-square-o"></i>
        </a>
      </label>
      <div class="col-md-8">
        <div class="input-group from-group">
          @php $sending_server_ids = $attributes['sending_server_ids'] @endphp
          @include('includes.multi_select_dropdown_sending_server')
          <div class="input-group-addon input-group-addon-right">
            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.client_sending_servers') }}"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button id="btn-save" type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'PUT', '{{ route('package.update', ['id' => $package->id]) }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
  <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button>
</div>
</form>
</div>