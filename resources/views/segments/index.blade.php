@extends('layouts.app')
@section('title', __('app.automation_segments'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/datatables/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/js/datatable.init.js')}}"></script>
<script src="{{asset('public/components/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('public/js/segment.js')}}"></script>
<script src="{{asset('public/js/segment_datatable.js')}}"></script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.automation_segments') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.automation') }}</li>
    <li class="active">{{ __('app.automation_segments') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="col-md-12 add-button-margin">
        <div class="left">
          <div class="btn-group">
            <a href="{{ route('segment.create', ['by' => 'list']) }}"><button class="btn btn-primary">{{ __('app.add_new_segment_by_list') }}</button></a>
          </div>
          <div class="btn-group">
            <a href="{{ route('segment.create', ['by' => 'campaign']) }}"><button class="btn btn-primary">{{ __('app.add_new_segment_by_campaign') }}</button></a>
          </div>
        </div>
        <div class="right">
          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ __('app.actions') }} <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="javascript:;" onclick="destroyMany('{{ route('segment.destroy', ['id' => 0]) }}')"><i class="fa fa-trash"></i>{{ __('app.delete') }}</a></li>
            </ul>
          </div>
        </div>
      </div>
      <table id="data" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th><input type="checkbox" id='checkAll' value="0"></th>
          <th>{{ __('app.segment_name') }}</th>
          <th>{{ __('app.type') }}</th>
          <th>{{ __('app.total') }}</th>
          <th>{{ __('app.action') }}</th>
          <th>{{ __('app.created') }}</th>
          <th>{{ __('app.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
  </div>
</section>
<span id="segments" data-route="{{ route('segments') }}"></span>
<!-- /.content -->
@endsection
