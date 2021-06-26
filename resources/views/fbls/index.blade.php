@extends('layouts.app')
@section('title', __('app.setup_fbl'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/datatables/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/js/datatable.init.js')}}"></script>
<script src="{{asset('public/components/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('public/js/fbl.js')}}"></script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.setup_fbl') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.setup') }}</li>
    <li class="active">{{ __('app.setup_fbl') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="col-md-12 add-button-margin">
        <div class="left">
          <a href="javascript:;" onclick="viewModal('modal', '{{ route('fbl.create') }}')">
            <button class="btn btn-primary">{{ __('app.add_new_fbl') }}</button>
          </a>
        </div>
        <div class="right">
          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ __('app.actions') }} <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="javascript:;" onclick="destroyMany('{{ route('fbl.destroy', ['id' => 0]) }}')"><i class="fa fa-trash"></i>{{ __('app.delete') }}</a></li>
            </ul>
          </div>
        </div>
      </div>
      <table id="data" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th><input type="checkbox" id='checkAll' value="0"></th>
          <th>{{ __('app.id') }}</th>
          <th>{{ __('app.fbl_name') }}</th>
          <th>{{ __('app.fbl_host') }}</th>
          <th>{{ __('app.fbl_method') }}</th>
          <th>{{ __('app.active') }}</th>
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
<span id="route-fbls" data-route="{{ route('fbls') }}"></span>
<!-- /.content -->
@endsection
