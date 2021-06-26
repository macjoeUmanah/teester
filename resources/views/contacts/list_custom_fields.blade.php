@php $include_js = false; @endphp
@forelse($list_custom_fields as $custom_field)
  <div class="form-group">
    <label class="col-md-2 control-label">{{ $custom_field->name }}</label>
    <div class="col-md-6 {{ ($custom_field->type == 'radio' || $custom_field->type == 'checkbox') ? 'radio' : '' }}">
      @if($custom_field->type == 'number')
        <input type="number" class="form-control" name="custom_fields[{{$custom_field->custom_field_id}}]" value="{{ !empty($contact_data) && !empty($contact_data[$custom_field->custom_field_id]) ? $contact_data[$custom_field->custom_field_id] : '' }}">
      @elseif($custom_field->type == 'textarea')
        <textarea class="form-control" name="custom_fields[{{$custom_field->custom_field_id}}]">{{ !empty($contact_data) && !empty($contact_data[$custom_field->custom_field_id]) ? $contact_data[$custom_field->custom_field_id] : '' }}</textarea>
      @elseif($custom_field->type == 'date')
        @php $include_js = true; @endphp
        <input type="text" id="date-{{$custom_field->custom_field_id}}" name="custom_fields[{{$custom_field->custom_field_id}}]" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask="" onfocus="$('#date-{{$custom_field->custom_field_id}}').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })" placeholder="dd-mm-yyyy" value="{{ !empty($contact_data) && !empty($contact_data[$custom_field->custom_field_id]) ? $contact_data[$custom_field->custom_field_id] : '' }}">
      @elseif($custom_field->type == 'radio')
        @foreach (\Helper::splitLineBreakWithComma($custom_field->values) as $value)
          <div class="radio list-custom-fields"><label>
            <input type="radio" name="custom_fields[{{$custom_field->custom_field_id}}]" value="{{ $value }}" {{ !empty($contact_data) && !empty($contact_data[$custom_field->custom_field_id]) && $contact_data[$custom_field->custom_field_id] == $value ? 'checked="checked"' : '' }}>{{$value}}
            </label>
          </div>
        @endforeach
      @elseif($custom_field->type == 'checkbox')
        @foreach (\Helper::splitLineBreakWithComma($custom_field->values) as $value)
        @php $contact_data_chks = !empty($contact_data) && !empty($contact_data[$custom_field->custom_field_id])  ? preg_split("/(,|[||])/", $contact_data[$custom_field->custom_field_id]) : ''; 
        if(!empty($contact_data_chks)) {$contact_data_chks = array_map('trim', $contact_data_chks);} @endphp
          <div class="checkbox list-custom-fields"><label>
            <input type="checkbox" name="custom_fields[{{$custom_field->custom_field_id}}][]" value="{{ $value }}" {{ !empty($contact_data) && !empty($contact_data[$custom_field->custom_field_id]) && in_array($value, $contact_data_chks) ? 'checked="checked"' : '' }}>{{$value}}
            </label>
          </div>
        @endforeach
      @elseif($custom_field->type == 'dropdown')
        <select name="custom_fields[{{$custom_field->custom_field_id}}]"  class="form-control">
          @foreach (\Helper::splitLineBreakWithComma($custom_field->values) as $value)
             <option value="{{ $value }}" {{ !empty($contact_data) && !empty($contact_data[$custom_field->custom_field_id]) && $contact_data[$custom_field->custom_field_id] == $value ? 'selected="selected"' : '' }}>{{ $value }}</option>
          @endforeach
        </select>
      @else
        <input type="text" class="form-control" name="custom_fields[{{$custom_field->custom_field_id}}]" value="{{ !empty($contact_data) && !empty($contact_data[$custom_field->custom_field_id]) ? $contact_data[$custom_field->custom_field_id] : '' }}">
      @endif
    </div>
  </div>
@empty
  <div class="col-md-offset-2 col-md-10"><h3>{{ __('app.none') }}</h3></div>
@endforelse
@if($include_js)
<script src="{{asset('public/components/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{asset('public/components/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('public/components/input-mask/jquery.inputmask.extensions.js')}}"></script>
@endif