@extends('layouts.app')
@section('title', __('app.setup_pmta'))

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('public/css/pmta.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/js/pmta.js')}}"></script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.setup_pmta') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.setup') }}</li>
    <li class="active">{{ __('app.setup_pmta') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  @include('includes.msgs')
  <div class="box box-default">
    <div class="box-body">
      @if(!empty($pmta))
        <div class="col-md-12 add-button-margin">
          <div>
            <div class="btn-group col-md-1 col-xs-1 col-sm-1">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ __('app.actions') }} <span class="caret"></span></button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="javascript:;" onclick="downloadPmtaSettings(1)"><i class="fa fa-download"></i>{{ __('app.pmta_msg_download_config') }}</a></li>
                <li><a href="javascript:;" onclick="deletePmta(1, '{{ __("app.pmta_msg_delete") }}' )"><i class="fa fa-trash"></i>{{ __('app.delete') }}</a></li>
              </ul>
            </div>
            <div id="action" class="col-md-11 col-xs-11 col-sm-11"></div>
          </div>
        </div>
      @endif
      <div class="container">
        <div class="row">
          <section>
            <div class="wizard">
              <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">

                  <li role="presentation" class="active text-center">
                    <strong>{{ __('app.pmta_tab_server_settings') }}</strong>
                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Server Settings">
                      <span class="round-tab">
                        <i class="fa fa-server"></i>
                      </span>
                    </a>

                  </li>
                  <li role="presentation" class="disabled text-center">
                    <strong>{{ __('app.pmta_tab_pmta_settings') }}</strong>
                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="PowerMTA Settings">
                      <span class="round-tab">
                        <i class="fa fa-gear"></i>
                      </span>
                    </a>
                  </li>
                  <li role="presentation" class="disabled text-center">
                    <strong>{{ __('app.pmta_tab_ips_domains') }}</strong>
                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="IPs & Domains">
                      <span class="round-tab">
                        <i class="fa fa-globe"></i>
                      </span>
                    </a>
                  </li>
                  <li role="presentation" class="disabled text-center">
                    <strong>{{ __('app.pmta_tab_ips_domains_mapping') }}</strong>
                    <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="IPs & Domains Mapping">
                      <span class="round-tab">
                        <i class="fa fa-random"></i>
                      </span>
                    </a>
                  </li>
                  <li role="presentation" class="disabled text-center">
                    <strong>{{ __('app.pmta_tab_bounces') }}</strong>
                    <a href="#step5" data-toggle="tab" aria-controls="step5" role="tab" title="Bounces">
                      <span class="round-tab">
                        <i class="fa fa-undo"></i>
                      </span>
                    </a>
                  </li>
                  <li role="presentation" class="disabled text-center">
                    <strong>{{ __('app.pmta_tab_dns_entries') }}</strong>
                    <a href="#step6" data-toggle="tab" aria-controls="step6" role="tab" title="Sending Domains Authentication">
                      <span class="round-tab">
                        <i class="fa fa-key"></i>
                      </span>
                    </a>
                  </li>
                  <li role="presentation" class="disabled text-center">
                    <strong>{{ __('app.pmta_tab_review') }}</strong>
                    <a href="#step7" data-toggle="tab" aria-controls="step7" role="tab" title="Config Review">
                      <span class="round-tab">
                        <i class="fa fa-eye"></i>
                      </span>
                    </a>
                  </li>
                  <li role="presentation" class="disabled text-center">
                    <strong>{{ __('app.pmta_tab_finish') }}</strong>
                    <a href="#step8" data-toggle="tab" aria-controls="step8" role="tab" title="Finish">
                      <span class="round-tab">
                        <i class="fa fa-flag-checkered"></i>
                      </span>
                    </a>
                  </li>
                </ul>
              </div>

              <form class="form-horizontal" id="frm-pmta">
                @csrf
                <div class="tab-content">
                  <div class="tab-pane active" role="tabpanel" id="step1">
                    <h3>{{ __('app.pmta_tab_server_settings') }}</h3>
                    <div>{{ __('app.pmta_tab_server_settings_text') }}</div><br>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_server_name') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="text" class="form-control" name="server_name" value="{{ !empty($pmta->server_name) ? $pmta->server_name : '' }}" placeholder="{{ __('app.pmta_server_name') }}" required="required">
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_server_name') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_server_os') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <select name="server_os" class="form-control">
                            <option value="centos8.x" {{ !empty($pmta->server_os) && $pmta->server_os == 'centos8.x' ? 'selected' : '' }}>CentOS 8.x</option>
                            <option value="centos7.x" {{ !empty($pmta->server_os) && $pmta->server_os == 'centos7.x' ? 'selected' : '' }}>CentOS 7.x</option>
                            <option value="centos6.x" {{ !empty($pmta->server_os) && $pmta->server_os == 'centos6.x' ? 'selected' : '' }}>CentOS 6.x</option>
                            <option value="ubuntu20.04" {{ !empty($pmta->server_os) && $pmta->server_os == 'ubuntu20.04' ? 'selected' : '' }}>Ubuntu 20.04</option>
                            <option value="ubuntu18.04" {{ !empty($pmta->server_os) && $pmta->server_os == 'ubuntu18.04' ? 'selected' : '' }}>Ubuntu 18.04</option>
                            <option value="ubuntu16.04" {{ !empty($pmta->server_os) && $pmta->server_os == 'ubuntu16.04' ? 'selected' : '' }}>Ubuntu 16.04</option>
                            <option value="other" {{ !empty($pmta->server_os) && $pmta->server_os == 'other' ? 'selected' : '' }}>Other</option>
                          </select>
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_server_os') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.setup_pmta') }} {{ __('app.version') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <select name="version" class="form-control">
                            <option value="5.0" {{ !empty($pmta->version) && $pmta->version == '5.0' ? 'selected' : '' }}>5.0</option>
                            <option value="4.0" {{ !empty($pmta->version) && $pmta->version == '4.0' ? 'selected' : '' }}>4.0</option>
                          </select>
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_version') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_server_ip') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="text" class="form-control" name="server_ip" id="server-ip" value="{{ !empty($pmta->server_ip) ? $pmta->server_ip : '' }}" placeholder="{{ __('app.pmta_server_ip') }}" required="required">
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_server_ip') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_server_port') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="number" class="form-control" name="server_port" id="server-port" value="{{ !empty($pmta->server_port) ? $pmta->server_port : '22' }}" placeholder="22" required="required" min="0">
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_server_port') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_server_username') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="text" class="form-control" name="server_username" id="server-username" value="{{ !empty($pmta->server_username) ? $pmta->server_username : 'root' }}" required="required">
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_server_username') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_server_password') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="password" class="form-control" name="server_password" id="server-password" value="" placeholder="{{ __('app.pmta_server_password') }}">
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_server_password') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-offset-2 col-md-10">
                        <button type="button" class="btn btn-success" id="validate" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.validate') }}">{{ __('app.validate') }}</button>
                        <button type="button" id="btn-next-server" class="btn btn-primary next-step" id="server-settings" style="display: none;">{{ __('app.next') }}</button>
                        <span id="server-msg"></span>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" role="tabpanel" id="step2">
                    <h3>{{ __('app.pmta_tab_pmta_settings') }}</h3>
                    <div>{{ __('app.pmta_tab_pmta_settings_text') }}</div><br>
                    <strong>{{ __('app.pmta_smtp_detail') }}</strong>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_smtp_host') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="text" class="form-control" name="smtp_host" value="{{ !empty($pmta->smtp_host) ? $pmta->smtp_host : '' }}" placeholder="smtp" required="required">
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_smtp_host') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_smtp_port') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="number" class="form-control" name="smtp_port" value="{{ !empty($pmta->smtp_port) ? $pmta->smtp_port : '25' }}" placeholder="25" required="required" min="0">
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_smtp_port') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_smtp_encryption') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <select name="smtp_encryption" class="form-control">
                            <option value="none"  {{ !empty($pmta->smtp_encryption) && $pmta->smtp_encryption == 'none' ? 'selected' : '' }}>None</option>
                            <option value="tls"  {{ !empty($pmta->smtp_encryption) && $pmta->smtp_encryption == 'tls' ? 'selected' : '' }}>TLS</option>
                          </select>
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_smtp_encryption') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.smtp_body_encoding') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <select name="body_encoding" class="form-control" >
                            <option value="quoted-printable" {{ !empty($pmta->body_encoding) && $pmta->body_encoding == 'quoted-printable' ? 'selected="selected"' : '' }}>quoted-printable</option>
                            <option value="base64" {{ !empty($pmta->body_encoding) && $pmta->body_encoding == 'base64' ? 'selected="selected"' : '' }}>base64</option>
                            <option value="7-bit" {{ !empty($pmta->body_encoding) && $pmta->body_encoding == '7-bit' ? 'selected="selected"' : '' }}>7-bit</option>
                          </select>
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.smtp_body_encryption') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <strong>{{ __('app.pmta_settings') }}</strong>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_path') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="text" class="form-control" name="path" value="{{ !empty($pmta->path) ? $pmta->path : '/etc/pmta' }}" placeholder="/etc/pmta" required="required">
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_path') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_management_port') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="number" class="form-control" name="management_port" value="{{ !empty($pmta->management_port) ? $pmta->management_port : '' }}" placeholder="8080" required="required" min="0">
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_management_port') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_admin_ips') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="text" class="form-control" name="admin_ips" value="{{ !empty($pmta->admin_ips) ? $pmta->admin_ips : $_SERVER['SERVER_ADDR'] }}" placeholder="" required="required">
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_admin_ips') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_log_file_path') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="text" class="form-control" name="log_file_path" value="{{ !empty($pmta->log_file_path) ? $pmta->log_file_path : '/var/log/pmta/pmta.log' }}" placeholder="/var/log/pmta/pmta.log" required="required">
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_log_file_path') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_acct_file_path') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="text" class="form-control" name="acct_file_path" value="{{ !empty($pmta->acct_file_path) ? $pmta->acct_file_path : '/etc/pmta/files/acct/acct.csv' }}" placeholder="/etc/pmta/files/acct/acct.csv" required="required">
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_acct_file_path') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_diag_file_path') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="text" class="form-control" name="diag_file_path" value="{{ !empty($pmta->diag_file_path) ? $pmta->diag_file_path : '/etc/pmta/files/diag/diag.csv' }}" placeholder="/etc/pmta/files/diag/diag.csv" required="required">
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_diag_file_path') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_spool_path') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="text" class="form-control" name="spool_path" value="{{ !empty($pmta->spool_path) ? $pmta->spool_path : '/var/spool/pmta' }}" placeholder="/var/spool/pmta" required="required">
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_spool_path') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_dkim_path') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="text" class="form-control" name="dkim_path" value="{{ !empty($pmta->dkim_path) ? $pmta->dkim_path : '/etc/pmta/dkim' }}" placeholder="/etc/pmta/dkim" required="required">
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_dkim_path') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_vmta_prefix') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="text" class="form-control" name="vmta_prefix" value="{{ !empty($pmta->vmta_prefix) ? $pmta->vmta_prefix : 'vmta' }}" placeholder="">
                          <div class="input-group-addon input-group-addon-right" required="required">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_vmta_prefix') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_dkim_selector') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="text" class="form-control" name="dkim_selector" value="{{ !empty($pmta->dkim_selector) ? $pmta->dkim_selector : config('mc.dkim_selector') }}" placeholder="">
                          <div class="input-group-addon input-group-addon-right" required="required">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_dkim_selector') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_dmarc_selector') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="text" class="form-control" name="dmarc_selector" value="{{ !empty($pmta->dmarc_selector) ? $pmta->dmarc_selector : config('mc.dmarc_selector') }}" placeholder="">
                          <div class="input-group-addon input-group-addon-right" required="required">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_dmarc_selector') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_tracking_selector') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <input type="text" class="form-control" name="tracking_selector" value="{{ !empty($pmta->tracking_selector) ? $pmta->tracking_selector : config('mc.tracking_selector') }}" placeholder="">
                          <div class="input-group-addon input-group-addon-right" required="required">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_tracking_selector') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-offset-2 col-md-10">
                        <button type="button" class="btn btn-default prev-step">{{ __('app.previous') }}</button>
                        <button type="button" class="btn btn-primary next-step" id="pmta-settings">{{ __('app.next') }}</button>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" role="tabpanel" id="step3">
                    <h3>{{ __('app.pmta_tab_ips_domains') }}</h3>
                    <div>{{ __('app.pmta_tab_ips_domains_text') }}</div><br>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_domains') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <textarea class="form-control" name="domains" id="domains" rows="5" required="required">{{ !empty($pmta->domains) ? $pmta->domains : '' }}</textarea>
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_domains') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">{{ __('app.pmta_ips') }} <span class="required">*</span></label>
                      <div class="col-md-7">
                        <div class="input-group from-group">
                          <textarea class="form-control" name="ips" id="ips" rows="5" required="required">{{ !empty($pmta->ips) ? $pmta->ips : '' }}</textarea>
                          <div class="input-group-addon input-group-addon-right">
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.pmta_ips') }}"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-offset-2 col-md-10">
                        <button type="button" class="btn btn-default prev-step">{{ __('app.previous') }}</button>
                        <button type="button" class="btn btn-primary next-step" id="ips-domains" onclick="pmtaSteps(3, 'mapping-ips-domains')">{{ __('app.next') }}</button>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" role="tabpanel" id="step4">
                    <h3>{{ __('app.pmta_tab_ips_domains_mapping') }}</h3>
                    <div>{{ __('app.pmta_tab_ips_domains_mapping_text') }}</div><br>
                    <div id="mapping-ips-domains"></div>
                    <div class="form-group">
                      <div class="col-md-offset-2 col-md-10">
                        <button type="button" class="btn btn-default prev-step">{{ __('app.previous') }}</button>
                        <button type="button" class="btn btn-primary next-step" onclick="pmtaSteps(4, 'bounces-data')">{{ __('app.next') }}</button>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" role="tabpanel" id="step5">
                    <h3>{{ __('app.pmta_tab_bounces') }}</h3>
                    <div id="bounces-data"></div>
                    <div class="form-group">
                      <div class="col-md-offset-2 col-md-10">
                        <button type="button" class="btn btn-default prev-step">{{ __('app.previous') }}</button>
                        <button type="button" class="btn btn-primary next-step" onclick="pmtaSteps(5, 'authentication-data')">{{ __('app.next') }}</button>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" role="tabpanel" id="step6">
                    <h3>{{ __('app.pmta_tab_dns_entries') }}</h3>
                    <div>{{ __('app.pmta_tab_dns_entries_text') }}</div><br>
                    <div id="authentication-data"></div>
                    <div class="form-group">
                      <div class="col-md-offset-2 col-md-10">
                        <button type="button" class="btn btn-default prev-step">{{ __('app.previous') }}</button>
                        <button type="button" class="btn btn-primary next-step" onclick="pmtaSteps(6, 'review-data')">{{ __('app.next') }}</button>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" role="tabpanel" id="step7">
                    <h3>{{ __('app.pmta_tab_review') }}</h3>
                    <div><textarea id="review-data" readonly='readonly' style='width:100%;height:500px;border:none;'></textarea></div>
                    <div class="form-group">
                      <div class="col-md-offset-2 col-md-10">
                        <button type="button" class="btn btn-default prev-step">{{ __('app.previous') }}</button>
                        <button type="button" class="btn btn-success next-step" onclick="pmtaSteps(7, 'finish-data')">{{ __('app.finish') }}</button>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" role="tabpanel" id="step8">
                    <h3>{{ __('app.pmta_tab_finish') }}</h3>
                    <h4 class="text-danger">{{ __('app.pmta_tab_finish_text') }}</h4>
                    <div id="finish-data"></div>
                    <div class="form-group">
                      <div class="col-md-offset-2 col-md-10">
                        <button type="button" class="btn btn-default prev-step" id="previous-finish">{{ __('app.previous') }}</button>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </form>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->
@endsection
