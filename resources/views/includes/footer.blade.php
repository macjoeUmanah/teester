<footer class="main-footer">
  <span id="exit-msg" data-value="{{ __('app.exit_msg')}}"></span>
  <span id="btn-exit" data-value="{{ __('app.exit')}}"></span>
  <span id="btn-cancel" data-value="{{ __('app.cancel')}}"></span>
  <span id="dt_loadingRecordsl" data-value="{{ __('app.dt_loadingRecordsl')}}"></span>
  <span id="dt_processing" data-value="{{ __('app.dt_processing')}}"></span>
  <span id="dt_zeroRecords" data-value="{{ __('app.dt_zeroRecords')}}"></span>
  <span id="dt_info" data-value="{{ __('app.dt_info')}}"></span>
  <span id="dt_infoEmpty" data-value="{{ __('app.dt_infoEmpty')}}"></span>
  <span id="dt_infoFiltered" data-value="{{ __('app.dt_infoFiltered')}}"></span>
  <span id="dt_previous" data-value="{{ __('app.dt_previous')}}"></span>
  <span id="dt_next" data-value="{{ __('app.dt_next')}}"></span>
  <span id="dt_first" data-value="{{ __('app.dt_first')}}"></span>
  <span id="dt_last" data-value="{{ __('app.dt_last')}}"></span>
  <span id="dt_btn_search" data-value="{{ __('app.dt_btn_search')}}"></span>
  <span id="dt_btn_show_all" data-value="{{ __('app.dt_btn_show_all')}}"></span>
  <span id="none_selected" data-value="{{__('app.none_selected')}}"></span>
  <span id="msg_update" data-value="{{__('app.msg_update')}}"></span>
  <span class="pull-right">
    <b>{{ __('app.version') }}</b> {{ $settings->current_version }}
  </span>
  <strong>{{date('Y')}} &copy; {{ Helper::decodeString($settings->app_name) }}</strong>
</footer>