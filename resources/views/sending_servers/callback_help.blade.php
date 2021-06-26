<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><strong>{{ __('help.webhook_help_heading') }} {{ ucfirst(str_replace('_', ' ', $type)) }}</strong></h4>
  </div>
  <div class="modal-body">
    <div class="box-body">
      @if($type == 'mailgun')
        {!! __('help.webhook_help_mailgun') !!}
      @elseif($type == 'sendgrid')
        {!! __('help.webhook_help_sendgrid') !!}
      @elseif($type == 'mailjet')
        {!! __('help.webhook_help_mailjet') !!}
      @elseif($type == 'elasticemail')
        {!! __('help.webhook_help_elastic_email') !!}
      @elseif($type == 'amazon')
        {!! str_replace('APP_URL', Helper::getAppURL(), __('help.webhook_help_amazon_ses')) !!}
      @endif
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
  </div>
</div>