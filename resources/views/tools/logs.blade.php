@extends('layouts.app')
@section('title', __('app.tools_logs'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/datatables/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/js/datatable.init.js')}}"></script>
<script src="{{asset('public/components/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('public/js/logs.js')}}"></script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.tools_logs') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.tools') }}</li>
    <li class="active">{{ __('app.tools_logs') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <table id="data" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th></th>
          <th>{{ __('app.activity') }}</th>
          <th>{{ __('app.user') }}</th>
          <th>{{ __('app.created') }}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
  </div>
</section>
<span id="route-logs" data-route="{{ route('logs') }}"></span>
<!-- /.content -->
@endsection
