<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
<select name="custom_fields[]" id="custom-fields" class="form-control" multiple="multiple">
  @foreach($list_custom_fields as $custom_field)
    <option value="{{ $custom_field->custom_field_id  }}" @if($custom_field_ids) {{ (in_array($custom_field->custom_field_id, explode(',', $custom_field_ids))) ? 'selected' : '' }} @endif>{{ $custom_field->name  }}</option>
  @endforeach
</select>