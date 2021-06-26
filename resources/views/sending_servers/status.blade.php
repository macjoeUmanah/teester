<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ __('app.setup_sending_servers') }}</h4>
  </div>
  <div class="modal-body">
    <div class="box-body" style="border-style: ridge;">
      <div class="col-md-12" class="form-group">
        <label class="col-md-4">{{ __('app.sending_server') }}</label>
        <label class="col-md-2">{{ __('app.status') }}</label>
        <label class="col-md-6">{{ __('app.description') }}</label>
      </div>
      @php $sending_server_ids = explode(',', $id) @endphp
      @foreach(\App\Models\SendingServer::getInActiveSeningServers($sending_server_ids) as $sending_server)
        <div class="col-md-12" class="form-group">
          <div class="col-md-4">{{ $sending_server->name }}</div>
          <div class="col-md-2">{{ $sending_server->status }}</div>
          <div class="col-md-6">{{ $sending_server->notification }}</div>
        </div>
      @endforeach
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
  </div>
</div>