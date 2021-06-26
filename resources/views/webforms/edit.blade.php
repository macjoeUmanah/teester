<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
<script src="{{asset('public/js/common.js')}}"></script>
<script>
  $(function() {
    $("#lists").change(function () {
      loadListCustomFields($('#lists').val(), 'list_custom_fields_dropdown_multiselect');
    });
  });
  loadListCustomFields("{{$webform->list_id}}", 'list_custom_fields_dropdown_multiselect', "{{$webform->custom_field_ids}}");
</script>
@php $attributes = json_decode($webform->attributes); @endphp
<div class="modal-content">
  <form class="form-horizontal" id="frm-group">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">{{ __('app.edit') }} - {{ $webform->name ?? '' }}</h4>
    </div>
    <div class="modal-body">
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.webform_name') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="name" value="{{  Helper::decodeString($webform->name) }}" placeholder="{{ __('app.webform_name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.webform_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.duplicates') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <select name="duplicates" class="form-control">
                <option value="Skip" {{ $webform->duplicates == 'Skip' ? 'selected' : '' }}>Skip</option>
                <option value="Overwrite" {{ $webform->duplicates == 'Overwrite' ? 'selected' : '' }}>Overwrite</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.webform_duplicate') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.list') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
              @php $list_id = $webform->list_id @endphp
              @include('includes.one_select_dropdown_list')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.webform_list') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.custom_fields') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <div id="list_custom_fields"><select class="form-control"></select></div>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.webform_custom_fields') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.thankyou_page_option') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <select id="thankyou_page_option" name="thankyou_page_option" class="form-control">
                <option value="system" {{ !empty($attributes->thankyou_page_option) && $attributes->thankyou_page_option == 'system' ? 'selected' : '' }}>{{ __('app.system_thankyou_page') }}</option>
                <option value="custom" {{ !empty($attributes->thankyou_page_option) && $attributes->thankyou_page_option == 'custom' ? 'selected' : '' }}>{{ __('app.custom_thankyou_page') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.thankyou_page_option') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group thankyou_page_option" style="display: {{ !empty($attributes->thankyou_page_option) && $attributes->thankyou_page_option == 'system' ? '' : 'none' }}">
          <label class="col-md-3 control-label">{{ __('app.webform_thankyou_page') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <label class="form-control"><a target="_balnk"  href="{{route('page.edit', ['id' => 8])}}">{{ __('app.webform_thankyou_page') }}</a></label>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.webform_thankyou_page') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group thankyou_page_option" style="display: {{ !empty($attributes->thankyou_page_option) && $attributes->thankyou_page_option == 'custom' ? '' : 'none' }}">
          <label class="col-md-3 control-label">{{ __('app.webform_custom_thankyou_page_url') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="thankyou_page_custom_url" value="{{$attributes->thankyou_page_custom_url ?? ''}}" placeholder="http://example.com">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.webform_thankyou_page') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.confirmation_page_option') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <select id="confirmation_page_option" name="confirmation_page_option" class="form-control">
                <option value="system" {{ !empty($attributes->confirmation_page_option) && $attributes->confirmation_page_option == 'system' ? 'selected' : '' }}>{{ __('app.system_confirmation_page') }}</option>
                <option value="custom" {{ !empty($attributes->confirmation_page_option) && $attributes->confirmation_page_option == 'custom' ? 'selected' : '' }}>{{ __('app.custom_confirmation_page') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.confirmation_page_option') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group confirmation_page_option" style="display: {{ !empty($attributes->confirmation_page_option) && $attributes->confirmation_page_option == 'system' ? '' : 'none' }}">
          <label class="col-md-3 control-label">{{ __('app.webform_confirmation_page') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <label class="form-control"><a target="_balnk"  href="{{route('page.edit', ['id' => 10])}}">{{ __('app.webform_confirmation_page') }}</a></label>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.webform_confirmation_page') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group confirmation_page_option" style="display: {{ !empty($attributes->confirmation_page_option) && $attributes->confirmation_page_option == 'custom' ? '' : 'none' }}">
          <label class="col-md-3 control-label">{{ __('app.webform_custom_confirmation_page_url') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="confirmation_page_custom_url" value="{{$attributes->confirmation_page_custom_url ?? ''}}" placeholder="{{ __('app.webform_custom_confirmation_page_url') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.webform_confirmation_page') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-offset-3 col-md-8 control-label text-left">{!! __('help.webform_confirmation_help') !!}</label>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="viewModal('modal', '{{route('webform.show', ['id' => $webform->id])}}')">{{ __('app.view') }}</button>
      <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'PUT', '{{ route('webform.update', ['id' => $webform->id]) }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button>
    </div>
  </form>
</div>