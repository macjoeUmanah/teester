<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
<script src="{{asset('public/js/common.js')}}"></script>
<div class="modal-content">
  <form class="form-horizontal" id="frm-group">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">{{ __('app.add_new_custom_field') }}</h4>
    </div>
    <div class="modal-body">
      <div class="box-body margin-bottom-70">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.custom_field_name') }} <span class="required">*</span></label>
          <div class="col-md-9">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="name" value="" placeholder="{{ __('app.custom_field_name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.custom_field_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.custom_field_type') }}</label>
          <div class="col-md-9">
            <div class="input-group from-group">
              <select name="type" id="type" class="form-control">
                @foreach($custom_field_type as $type => $name)
                <option value="{{ $type }}">{{ $name }}</option>
                @endforeach
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.custom_field_type') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group" id='values' style="display: none;">
          <label class="col-md-2 control-label">{{ __('app.custom_field_values') }}</label>
          <div class="col-md-9">
            <textarea class="form-control" name="values" rows="5" placeholder="{{ __('app.custom_field_values_placehoder') }}"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.lists') }}
            <a href="{{ route('list.create') }}">
              <i class="fa fa-plus-square-o"></i>
            </a>
          </label>
          <div class="col-md-9">
            <div class="input-group from-group">
              @include('includes.multi_select_dropdown_list')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.custom_fields_lists') }}"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
          <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('custom_field.store') }}');@if($multiselect) setTimeout(function(){dropdownDBMultiselect('custom-fields', '{{route('customFieldsData', ['return_type' => 'json'])}}');},3000)@endif" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
          <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('custom_field.store') }}', 1);$('#values').hide();@if($multiselect) setTimeout(function(){dropdownDBMultiselect('custom-fields', '{{route('customFieldsData', ['return_type' => 'json'])}}');},3000)@endif" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save_add_new') }}">{{ __('app.save_add_new') }}</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button>
        </div>
      </div>
    </div>

  </form>
</div>