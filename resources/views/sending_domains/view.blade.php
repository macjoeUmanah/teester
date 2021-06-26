@extends('layouts.app')
@section('title', __('app.setup_sending_domains'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script>
  $(function () {
    $('.fa-copy').click(function() {
      document.getElementById("public-key").select();
      document.execCommand("copy");
      toastr.success('Copied successfully!');
    })
  });
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>&nbsp;</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.setup') }}</li>
    <li class="active"><a href="{{ route('sending_domains.index') }}">{{ __('app.setup_sending_domains') }}</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="box">
    <div class="box-body">
      <div class="box-header with-border">
        <i class="fa fa-globe"></i>
        <h3 class="box-title">
          <select name="protocol" id="protocol-domain">
            <option value="https://" {{ $sending_domain->protocol == 'https://' ? 'selected="selected"' : '' }}>https://</option>
            <option value="http://" {{ $sending_domain->protocol == 'http://' ? 'selected="selected"' : '' }}>http://</option>
          </select> &nbsp;
          {{$sending_domain->domain}}</h3>
          <div class="box-tools pull-right">
            <input type="checkbox" data-onstyle="success" data-offstyle="danger" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.active') }}" data-off="{{ __('app.inactive') }}" id="active-domain" {{ $sending_domain->active == 'Yes' ? 'checked="checked"' : '' }}>
          </div>
        </div>
        <div class="box-body"></div>

        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">{{ __('app.keys') }} &nbsp;<a href="{{ route('download.keys', ['id' => $sending_domain->id]) }}"><i class="fa fa-download" title="Download"></i></a></h3>
            <div class="box-tools pull-right" data-toggle="tooltip" title="{{ __('help.sending_domain_signing') }}">
              <input type="checkbox" data-onstyle="success" data-offstyle="warning" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.signing_enabled') }}" data-off="{{ __('app.signing_disabled') }}" id='signing-domain' {{ $sending_domain->signing == 'Yes' ? 'checked="checked"' : '' }}>
            </div>
          </div>
          <div class="box-body">
            <div class="form-group">
              <label>{{ __('app.public_key') }}</label>
              <textarea class="form-control" disabled="disabled">{{ $sending_domain->public_key }}</textarea>
            </div>
            <div class="form-group">
              <label>{{ __('app.private_key') }}</label>
              <textarea class="form-control" disabled="disabled">{{ $sending_domain->private_key }}</textarea>
            </div>
          </div>
        </div>

        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">{{ __('app.verifications') }}</h3>
          </div>
          <div class="box-body">
            {!! str_replace('[domain-name]', $sending_domain->domain , __('app.help_text_setup_keys')) !!}
            <table class="table table-bordered text-left">
              <tbody>
                <tr>
                  <th width="10%">{{ __('app.type') }}</th>
                  <th width="20%">{{ __('app.host') }}</th>
                  <th width="50%">{{ __('app.value') }}</th>
                  <th width="20%">{{ __('app.verified') }}</th>
                </tr>
                <tr>
                  <td>TXT</td>
                  <td>{{ $sending_domain->dkim }}._domainkey.{{ $sending_domain->domain }}.</td>
                  <td>
                    <div class="input-group">
                      <input type="text" class="form-control" id="public-key" value="v=DKIM1; k=rsa; p={{ str_replace(['-----BEGINPUBLICKEY-----', '-----ENDPUBLICKEY-----'], ['', ''], $sending_domain->public_key) }};" readonly="readonly">
                      <div class="input-group-addon input-group-addon-right">
                        <a href="javascript:;"><i class="fa fa-copy"></i></a>
                      </div>
                    </div>
                  </td>
                  <td><span id='key'><i class="fa {{ $sending_domain->verified_key ? 'fa-check green-check' : 'fa-times red-times' }}"></i></span></td>
                </tr>
                <tr>
                  <td>TXT</td>
                  <td>{{ $sending_domain->domain }}.</td>
                  <td>
                    @if($sending_domain->pmta)
                    {{$sending_domain->spf_value}}
                    @else
                      @if($sending_domain->pmta)
                      {{$sending_domain->spf_value}}
                      @else
                        @if(!empty($spf_record[0]))
                          {{$spf_record[0]}}
                        @else
                          {!! __('app.no_spf_found') !!}
                          "v=spf1 mx a ip4:{{$_SERVER['SERVER_ADDR']}} ~all"
                        @endif
                      @endif
                    
                    @endif
                  </td>
                  <td><span id='spf'><i class="fa {{ $sending_domain->verified_spf ? 'fa-check green-check' : 'fa-times red-times' }}"></i></span></td>
                </tr>
                <tr>
                  <td>TXT</td>
                  <td>_dmarc</td>
                  <td>v=DMARC1;p=none;rua=mailto:{{$sending_domain->dmarc}}&#x40;{{$sending_domain->domain}};ruf=mailto:{{$sending_domain->dmarc}}&#x40;{{$sending_domain->domain}}</td>
                  <td><span id='dmarc'><i class="fa {{ $sending_domain->verified_dmarc ? 'fa-check green-check' : 'fa-times red-times' }}"></i></span></td>
                </tr>
                <tr>
                  <td>CNAME</td>
                  <td>{{ $sending_domain->tracking }}.{{ $sending_domain->domain }}.</td>
                  <td>{{ \Helper::getAppURL(true) }}</td>
                  <td><span id='tracking'><i class="fa {{ $sending_domain->verified_tracking ? 'fa-check green-check' : 'fa-times red-times' }}"></i></span></td>
                </tr>
              </tbody>
            </table>
            <div style="padding-top:30px;"><button class="btn btn-primary" id="verify-domain" data-route="{{route('domain.verifications', ['id' => $sending_domain->id, 'type' => 'all'])}}" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.verifying') }}">{{ __('app.verify_now') }}</button>

            </div>
          </div>
        </div>

        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">{{ __('app.selectors') }}</h3>
          </div>
          <form class="form-horizontal" id="frm-selectors">
            <div class="box-body">
              <div class="form-group">
                <label class="col-md-1 control-label">{{ __('app.dkim') }} <span class="required">*</span></label>
                <div class="col-md-2">
                  <div class="input-group">
                    <input type="text" class="form-control" name="dkim" value="{{$sending_domain->dkim}}" placeholder="{{ __('app.dkim') }}">
                    <div class="input-group-addon input-group-addon-right">
                      <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.dkim_selector') }}"></i>
                    </div>
                  </div>
                </div>
                <span></span>
              </div>
              <div class="form-group">
                <label class="col-md-1 control-label">{{ __('app.dmarc') }} <span class="required">*</span></label>
                <div class="col-md-2">
                  <div class="input-group">
                    <input type="text" class="form-control" name="dmarc" value="{{$sending_domain->dmarc}}" placeholder="{{ __('app.dmarc') }}">
                    <div class="input-group-addon input-group-addon-right">
                      <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.dmarc_selector') }}"></i>
                    </div>
                  </div>
                </div>
                <span></span>
              </div>
              <div class="form-group">
                <label class="col-md-1 control-label">{{ __('app.tracking') }} <span class="required">*</span></label>
                <div class="col-md-2">
                  <div class="input-group">
                    <input type="text" class="form-control" name="tracking" value="{{$sending_domain->tracking}}" placeholder="{{ __('app.tracking') }}">
                    <div class="input-group-addon input-group-addon-right">
                      <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.tracking_selector') }}"></i>
                    </div>
                  </div>
                </div>
                <span></span>
              </div>
              <div class="form-group">
                <div class="col-md-offset-1 col-md-2">
                  <button type="button" class="btn btn-primary loader" onclick="submitData(this, this.form, 'PUT', '{{route('sending_domain.update', ['id' => $sending_domain->id])}}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.update') }}">{{ __('app.update') }}</button>
                  <a href="{{route('sending_domain.show', ['id' => $sending_domain->id])}}"><button type="button" class="btn btn-success">{{ __('app.refresh') }}</button></a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <span id="sending-domain-update" data-route="{{route('sending_domain.update', ['id' => $sending_domain->id])}}"></span>
  <!-- /.content -->
  @endsection
