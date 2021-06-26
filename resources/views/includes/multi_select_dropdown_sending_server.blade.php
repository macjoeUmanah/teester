@php $client_sending_servers = \Helper::getClientAttributeValue(\Auth::user()->app_id, 'sending_server_ids') @endphp
<select name="sending_server_ids[]" id="sending-servers" class="form-control" multiple="multiple">
  @if(!empty($client_sending_servers))
    @foreach(\App\Models\SendingServer::groupSendingServersClient($client_sending_servers) as $group)
      <optgroup label="{{ Helper::decodeString($group->name) }}">
        @foreach($group->sendingServers as $sending_server)
          @if(in_array($sending_server->id, $client_sending_servers))
            <option value="{{ $sending_server->id }}" {{ !empty($sending_server_ids) && in_array($sending_server->id, $sending_server_ids) == $sending_server->id ? 'selected="selected"' : '' }}>{{ Helper::decodeString($sending_server->name) }}</option>
          @endif
        @endforeach
      </optgroup>
    @endforeach
  @endif
  @foreach(\App\Models\SendingServer::groupSendingServers() as $group)
    <optgroup label="{{ Helper::decodeString($group->name) }}">
      @foreach($group->sendingServers as $sending_server)
        <option value="{{ $sending_server->id }}" {{ !empty($sending_server_ids) && in_array($sending_server->id, $sending_server_ids) == $sending_server->id ? 'selected="selected"' : '' }}>{{ Helper::decodeString($sending_server->name) }}</option>
      @endforeach
    </optgroup>
  @endforeach
</select>