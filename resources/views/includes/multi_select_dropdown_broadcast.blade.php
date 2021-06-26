<select name="broadcast_ids[]" id="boradcasts" class="form-control multi" multiple="multiple">
  @foreach(\App\Models\Broadcast::groupBroadcasts() as $group)
    <optgroup label="{{ Helper::decodeString($group->name) }}">
      @foreach($group->broadcasts as $broadcast)
        <option value="{{ $broadcast->id }}" {{ !empty($broadcast_ids) && in_array($broadcast->id, $broadcast_ids) ? 'selected="selected"' : '' }}>{{ Helper::decodeString($broadcast->name) }}</option>
      @endforeach
    </optgroup>
  @endforeach
</select>