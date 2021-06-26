@php $client_lists = \Helper::getClientAttributeValue(\Auth::user()->app_id, 'list_ids') @endphp
<select name="list_ids[]" id="lists" class="form-control" multiple="multiple">
  @if(!empty($client_lists))
    @foreach(\App\Models\Lists::groupListsClient($client_lists) as $group)
      <optgroup label="{{ Helper::decodeString($group->name) }}">
        @foreach($group->lists as $list)
          @if(in_array($list->id, $client_lists))
            <option value="{{ $list->id }}" {{ !empty($list_ids) && in_array($list->id, $list_ids) ? 'selected="selected"' : '' }}>{{ Helper::decodeString($list->name) }} ({{$list->contacts_count}})</option>
          @endif
        @endforeach
      </optgroup>
    @endforeach
  @endif
  @foreach(\App\Models\Lists::groupLists() as $group)
    <optgroup label="{{ $group->name }}">
      @foreach($group->lists as $list)
        <option value="{{ $list->id }}" {{ !empty($list_ids) && in_array($list->id, $list_ids) ? 'selected="selected"' : '' }}>{{ Helper::decodeString($list->name) }} ({{$list->contacts_count}})</option>
      @endforeach
    </optgroup>
  @endforeach
</select>