<select name="list_id" id="lists" class="form-control" >
  <option value="">{{ __('app.none') }}</option>
  @foreach(\App\Models\Lists::groupLists() as $group)
    <optgroup label="{{ Helper::decodeString($group->name) }}">
      @foreach($group->lists as $list)
        <option value="{{ $list->id }}" {{ !empty($list_id) && $list_id == $list->id ? 'selected="selected"' : '' }}>{{ Helper::decodeString($list->name) }} ({{$list->contacts_count}})</option>
      @endforeach
    </optgroup>
  @endforeach
</select>