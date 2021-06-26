<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ __('app.detail') }}</h4>
  </div>
  <div class="modal-body">
    <div class="box-body">
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.name') }}</label>
        <div class="col-md-9">{{ $user->name }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.role') }}</label>
        <div class="col-md-9">{{ $user->role->name }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.package') }}</label>
        <div class="col-md-9">{{ $user->package->name }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.email') }}</label>
        <div class="col-md-9">{{ $user->email }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.address') }}</label>
        <div class="col-md-9">{{ $user->address }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.country') }}</label>
        <div class="col-md-9">{{ Helper::countries($user->country_code) }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.phone') }}</label>
        <div class="col-md-9">{{ $user->phone }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.time_zone') }}</label>
        <div class="col-md-9">{{ Helper::timeZones($user->time_zone) }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.language') }}</label>
        <div class="col-md-9">{{ Helper::languages($user->language)  }}</div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
  </div>
  </div>
</div>