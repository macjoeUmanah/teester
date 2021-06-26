<select name="broadcast_id" id="broadcasts" class="form-control" >
  <option value="">{{ __('app.none') }}</option>
  @foreach(\App\Models\Broadcast::groupBroadcasts() as $group)
    <optgroup label="{{ Helper::decodeString($group->name) }}">
      @foreach($group->broadcasts as $broadcast)
        <option value="{{ $broadcast->id }}" {{ !empty($broadcast_id) && $broadcast_id == $broadcast->id ? 'selected="selected"' : '' }}>{{ Helper::decodeString($broadcast->name) }}</option>
      @endforeach
    </optgroup>
  @endforeach
</select>