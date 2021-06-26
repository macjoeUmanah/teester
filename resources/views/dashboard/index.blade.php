@extends('layouts.app')
@section('title', __('app.dashboard'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/jvectormap/jquery-jvectormap-2.0.3.css')}}">
<link rel="stylesheet" href="{{asset('public/components/bootstrap-daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{asset('public/components/datatables/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/js/datatable.init.js')}}"></script>
<script src="{{asset('public/components/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('public/components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('public/components/Chart.js/dist/Chart.min.js')}}"></script>
<script src="{{asset('public/components/jvectormap/jquery-jvectormap-2.0.3.min.js')}}"></script>
<script src="{{asset('public/components/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<script src="{{asset('public/js/dashboard.js')}}"></script>
<script>
domiansChart(moment().subtract(6, 'days'), moment());
countryChart(moment().subtract(6, 'days'), moment());
campaignsChart(moment().subtract(6, 'days'), moment());
</script>
@endsection

@section('content')
<div id="domain" data-route="{{ route('campaigns.sent.data', ['type' => 'domain']) }}"></div>
<div id="country" data-route="{{ route('campaigns.sent.data', ['type' => 'country']) }}"></div>
<div id="campaign" data-route="{{ route('campaigns.sent.data', ['type' => 'campaigns']) }}"></div>
<div id="no-found" data-value="{{ __('app.no_record_found') }}"></div>
<div id="opens" data-value="{{ __('app.opens')}}"></div>
<div id="data-campaigns-route" data-value="{{ route('stats.campaigns') }}"></div>
<div id="data-triggers-route" data-value="{{ route('stats.triggers') }}"></div>
<div id="data-clients-route" data-value="{{ route('clients') }}"></div>

<!-- Main content -->
<section class="content">
  <!-- Display warning if cron executed more than 3 minutes -->
  @if(\Helper::getCronLatExecutedMinutes() > 3)
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="alert alert-danger-light">
        <i class="icon fa fa-warning"></i>
        {!! __('app.msg_cron_setup') !!} 
        [{{ \Helper::getCronCommand() }}]
      </div>
    </div>
  </div>
  @endif

  @if(file_exists(base_path().DIRECTORY_SEPARATOR.'install'))
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="alert alert-danger">
        <i class="icon fa fa-warning"></i>
        Please remove the install directory from "{{base_path().DIRECTORY_SEPARATOR.'install'}}"
      </div>
    </div>
  </div>
  @endif

  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-md-3 ">
      <div class="info-box">
        <span class="info-box-icon bg-olive"><i class="fa fa-list"></i></span>
        <div class="info-box-content">
          <span class="pull-right"><a href="{{ route('list.create') }}" title="{{ __('app.add_new_list') }}"><i class="fa fa-plus-square-o"></i></a></span>
          <span class="info-box-text">{{ __('app.lists') }}</span>
          <span class="info-box-number"><a href="{{ route('lists.index') }}" title="{{ __('app.view_all_lists') }}">{{\App\Models\Lists::whereAppId(\Auth::user()->app_id)->count() }}</a></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-maroon"><i class="fa fa-address-card-o"></i></span>
        <div class="info-box-content">
          <span class="pull-right"><a href="{{ route('contact.create') }}" title="{{ __('app.add_new_contact') }}"><i class="fa fa-plus-square-o"></i></a></span>
          <span class="info-box-text">{{ __('app.contacts') }}</span>
          <span class="info-box-number"><a href="{{ route('contacts.index') }}" title="{{ __('app.view_all_contacts') }}">{{\App\Models\Contact::whereAppId(\Auth::user()->app_id)->count() }}</a>

          @if(Auth::user()->id != config('mc.app_id'))
            / {!! \Helper::displayValueOrUnlimited(Auth::user()->app_id, 'no_of_recipients') !!}
          @endif

          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 ">
      <div class="info-box">
        <span class="info-box-icon bg-purple"><i class="fa fa-globe"></i></span>
        <div class="info-box-content">
          <span class="pull-right"><a href="{{ route('sending_domains.index') }}" title="{{ __('app.add_new_sending_domain') }}"><i class="fa fa-plus-square-o"></i></a></span>
          <span class="info-box-text">{{ __('app.setup_sending_domains') }}</span>
          <span class="info-box-number"><a href="{{ route('sending_domains.index') }}" title="{{ __('app.view_all_sending_domains') }}">{{\App\Models\SendingDomain::whereAppId(\Auth::user()->app_id)->count() }}</a>

          @if(Auth::user()->id != config('mc.app_id'))
            / {!! \Helper::displayValueOrUnlimited(Auth::user()->app_id, 'no_of_sending_servers') !!}
          @endif
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-random"></i></span>
        <div class="info-box-content">
          <span class="pull-right"><a href="{{ route('sending_server.create') }}" title="{{ __('app.add_new_sending_server') }}"><i class="fa fa-plus-square-o"></i></a></span>
          <span class="info-box-text">{{ __('app.setup_sending_servers') }}</span>
          <span class="info-box-number"><a href="{{ route('sending_servers.index') }}" title="{{ __('app.view_all_sending_servers') }}">{{\App\Models\SendingServer::whereAppId(\Auth::user()->app_id)->count() }}</a></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <div class="row">
    <div class="col-md-8">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{ __('app.campaigns') }}</h3> &nbsp;<small id="campaigns-range"></small>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-primary btn-sm daterange-campaigns pull-right" data-toggle="tooltip" title="Date range">
              <i class="fa fa-calendar"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-md-12">
            <div class="chart">
              <div id="div-chart-campaigns"></div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-4">
      <div class="box" id="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{ __('app.top_10_domains') }} &nbsp;<small id="domain-range"></small></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-primary btn-sm daterange-domain pull-right" data-toggle="tooltip" title="Date range">
              <i class="fa fa-calendar"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <!-- Map box -->
        <div class="box box-solid">
          <div class="box-body">
            <div class="col-md-12">
              <div class="chart">
                <div id="div-chart-domain"></div>
              </div>
              <!-- ./chart-responsive -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.box-body-->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.box -->
    </div>
  </div>
  <!-- /.row -->

  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{ __('app.stats') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab_stat_campaigns">{{ __('app.campaigns') }}</a></li>
            <li><a data-toggle="tab" href="#tab_stat_triggers">{{ __('app.triggers') }}</a></li>
          </ul>
          <div class="tab-content" style="padding: 10px;">
            <div id="tab_stat_campaigns" class="tab-pane fade in active">
              <table id="data-campaigns" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>{{ __('app.schedule_campaign_name') }}</th>
                    <th>{{ __('app.schedule_by') }}</th>
                    <th>{{ __('app.start_datetime') }}</th>
                    <th>{{ __('app.total') }}</th>
                    <th>{{ __('app.scheduled') }}</th>
                    <th>{{ __('app.sent') }}</th>
                    <th>{{ __('app.opens') }}</th>
                    <th>{{ __('app.clicks') }}</th>
                    <th>{{ __('app.created') }}</th>
                    <th>{{ __('app.detail') }}</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
            <div id="tab_stat_triggers" class="tab-pane fade">
              <table id="data-triggers" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <th>{{ __('app.name') }}</th>
                    <th>{{ __('app.based_on') }}</th>
                    <th>{{ __('app.action') }}</th>
                    <th>{{ __('app.schedule_by') }}</th>
                    <th>{{ __('app.created') }}</th>
                    <th>{{ __('app.detail') }}</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->

  <div class="row">
    @can('logs')
    <div class="col-md-5">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{ __('app.activity_log') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12 dashboard-activity-log">
              <table id="data" class="table table-bordered table-striped">
                <tbody>
                  <tr>
                    <th>{{ __('app.activity') }}</th>
                    <th>{{ __('app.user') }}</th>
                    <th>{{ __('app.datetime') }}</th>
                  </tr>
                  @foreach ($activities as $activity)
                  <tr>
                    <td>{{ Helper::decodeString($activity->description) ?? '---' }}</td>
                    <td>{{ $activity->causer['name'] ?? '---' }}</td>
                    <td>{{ \Helper::datetimeDisplay($activity->created_at) ?? '---' }}</td>
                  </tr>
                  @endforeach
                  @if(count($activities))
                  <tr>
                    <td colspan="3"><a href="{{ route('logs.index') }}">{{ __('app.view_all') }}</a></td>
                  </tr>
                  @endif
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- ./box-body -->
      </div>
      <!-- /.box -->
    </div>
    @endcan
    <div @can('logs') class="col-md-7" @else class="col-md-12" @endcan >
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{ __('app.open_by_countries') }}</h3>  &nbsp;<small id="country-range"></small>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-primary btn-sm daterange-country pull-right" data-toggle="tooltip" title="Date range">
              <i class="fa fa-calendar"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <!-- Map box -->
        <div class="box box-solid">
          <div class="box-body">
            <div id="world-map" class="dashboard-world-map"></div>
          </div>
          <!-- /.box-body-->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

    <!-- Clients -->
  @if(Auth::user()->id == config('mc.app_id'))
    @can('logs')
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('app.clients') }}</h3>
              <div class="right">
              <a href="{{route('client.create')}}"><button class="btn btn-primary">{{ __('app.add_new_client') }}</button></a>
            </div>
            </div>
            <div class="box-body">
              <table id="data-clients" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>{{ __('app.name') }}</th>
                    <th>{{ __('app.package') }}</th>
                    <th>{{ __('app.role') }}</th>
                    <th>{{ __('app.email') }}</th>
                    <th>{{ __('app.country') }}</th>
                    <th>{{ __('app.active') }}</th>
                    <th>{{ __('app.created') }}</th>
                    <th>{{ __('app.actions') }}</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    @endcan
  @endif
  <!-- /.row -->


</section>
<!-- /.content -->
@endsection
