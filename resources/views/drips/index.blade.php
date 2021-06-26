@extends('layouts.app')
@section('title', __('app.drips'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/datatables/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/js/datatable.init.js')}}"></script>
<script src="{{asset('public/components/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('public/js/drip.js')}}"></script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.drips') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li class="active"><a href="{{ route('drips.index') }}">{{ __('app.drips') }}</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  @include('includes.msgs')
  <div class="box">
    <div class="box-body">
      <div class="col-md-12 add-button-margin">
        <div  style="float: left;">
          <div class="btn-group">
            <a href="javascript:;" onclick="viewModal('modal', '{{ route('drip.create') }}')">
              <button class="btn btn-primary">{{ __('app.add_new_drip') }}</button>
            </a>
          </div>
        </div>
        <div style="float: right;">
          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ __('app.actions') }} <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="javascript:;" onclick="destroyMany('{{ route('drip.destroy', ['id' => 0]) }}')"><i class="fa fa-trash"></i>{{ __('app.delete') }}</a></li>
            </ul>
          </div>
        </div>
      </div>
      <table id="data" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th><input type="checkbox" id='checkAll' value="0"></th>
          <th>{{ __('app.name') }}</th>
          <th>{{ __('app.group') }}</th>
          <th>{{ __('app.broadcast') }}</th>
          <th>{{ __('app.send') }}</th>
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
  <input type="hidden" id="route" value="{{ route('group.delete', ['model' => 'drip']) }}">
  <span id="route-drips" data-route="{{ route('drips') }}"></span>
  <span id="tooltip-group-edit" data-value="{{ __('app.tooltip_group_edit') }}"></span>
  <span id="route-group-edit" data-route="{{ route('group.update') }}"></span>
  <span id="tooltip-group-delete-drip" data-value="{{ __('app.tooltip_group_delete_drip') }}"></span>
  <span id="msg-group-delete-drip" data-value="{{ __('app.msg_group_delete_drip') }}"></span>
  <span id="tooltip-group-eraser-drip" data-value="{{ __('app.tooltip_group_eraser_drip') }}"></span>
  <span id="route-group-eraser-drip" data-route="{{ route('group.delete', ['model' => 'drip']) }}"></span>
  <span id="msg-group-erase-drip" data-value="{{ __('app.msg_group_eraser_drip') }}"></span>
</section>
<!-- /.content -->
@include('groups.move')
@endsection
