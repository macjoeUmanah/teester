<select name="segment_id" id="segments" class="form-control" >
  <option value="">{{ __('app.none') }}</option>
  @php $segments = \App\Models\Segment::whereAppId(\Auth::user()->app_id)->get() @endphp
  @foreach($segments as $segment)
        <option value="{{ $segment->id }}" {{ !empty($segment_id) && $segment_id == $segment->id ? 'selected="selected"' : '' }}>{{ Helper::decodeString($segment->name) }}</option>
  @endforeach
</select>