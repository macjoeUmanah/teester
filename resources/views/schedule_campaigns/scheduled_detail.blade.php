<style>
  .row-custom{height: 30px;}
  .row-custom:nth-child(even) {background: #F0F0F0}
  .row-custom:nth-child(odd) {background: #E0E0E0}
</style>
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ $name }}</h4>
  </div>
  <div class="modal-body">
    <div class="box-body col-md-12" style="border-style: ridge;">
      <div class="row-custom">
        <label class="col-md-4">{{ __('app.total') }}</label>
        <div class="col-md-6">
          <label class="control-label">{{ $scheduled_detail->Total ?? '---'  }}</label>
        </div>
      </div>
      <div class="row-custom">
        <label class="col-md-4">{{ __('app.scheduled') }}</label>
        <div class="col-md-6">
          <label class="control-label">{{ $scheduled_detail->Scheduled ?? '---'  }}</label>
        </div>
      </div>
      <div class="row-custom">
        <label class="col-md-4">{{ __('app.inactive') }}</label>
        <div class="col-md-6">
          <label class="control-label">{{ $scheduled_detail->Inactive ?? '---' }}</label>
        </div>
      </div>
      <div class="row-custom">
        <label class="col-md-4">{{ __('app.unsubscribed') }}</label>
        <div class="col-md-6">
          <label class="control-label">{{ $scheduled_detail->Unsubscribed ?? '---'  }}</label>
        </div>
      </div>
      <div class="row-custom">
        <label class="col-md-4">{{ __('app.duplicates') }}</label>
        <div class="col-md-6">
          <label class="control-label">{{ $scheduled_detail->Duplicates ?? '---'  }}</label>
        </div>
      </div>
      <div class="row-custom">
        <label class="col-md-4">{{ __('app.suppressed') }}</label>
        <div class="col-md-6">
          <label class="control-label">{{ $scheduled_detail->Suppressed ?? '---'  }}</label>
        </div>
      </div>
      <div class="row-custom">
        <label class="col-md-4">{{ __('app.bounced') }}</label>
        <div class="col-md-6">
          <label class="control-label">{{ $scheduled_detail->Bounced ?? '---'  }}</label>
        </div>
      </div>
      <div class="row-custom">
        <label class="col-md-4">{{ __('app.spammed') }}</label>
        <div class="col-md-6">
          <label class="control-label">{{ $scheduled_detail->Spammed ?? '---'  }}</label>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
  </div>
</div>