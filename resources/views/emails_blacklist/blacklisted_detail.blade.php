<style>
  .row-custom{height: 30px;padding-top: 5px;}
  .row-custom:nth-child(even) {background: #F0F0F0}
  .row-custom:nth-child(odd) {background: #E0E0E0}
</style>
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ __('app.blacklist_monitor') }} ({{$blacklisted->name}})</h4>
  </div>
  <div class="modal-body">
    <div class="box-body">
      <div class="col-md-12">
        <label class="col-md-6"><h3>{{ __('app.domain') }}</h3></label>
        <div class="col-md-6"><h3>{{ __('app.listed') }}</h3></div>
      </div>
      @php $detail = json_decode($blacklisted->detail) @endphp
      @foreach($detail as $domain => $pass)
        <div class="row-custom col-md-12">
          <div class="col-md-6">{{ $domain }}</div>
          <div class="col-md-6 {{ $pass == 'No' ? 'text-green' : 'text-red' }}">{{ $pass }}</div>
        </div>
      @endforeach
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
  </div>
  </div>
</div>