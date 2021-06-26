@extends('layouts.app')
@section('title', __('app.setup_sending_servers'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/datatables/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/js/datatable.init.js')}}"></script>
<script src="{{asset('public/components/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('public/js/sending_server.js')}}"></script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.setup_sending_servers') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.setup') }}</li>
    <li class="active">{{ __('app.setup_sending_servers') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  @include('includes.msgs')
  <div class="box">
    <div class="box-body">
        <div class="col-md-12 add-button-margin">
          <div class="left">
            <div class="btn-group">
              <a href="{{route('sending_server.create')}}"><button class="btn btn-primary">{{ __('app.add_new_sending_server') }}</button></a>
            </div>
          </div>
          <div class="right">
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ __('app.actions') }} <span class="caret"></span></button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="javascript:;" onclick="destroyMany('{{ route('sending_server.destroy', ['id' => 0]) }}')"><i class="fa fa-trash"></i>{{ __('app.delete') }}</a></li>
              </ul>
            </div>
          </div>
        </div>
      <table id="data" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th><input type="checkbox" id='checkAll' value="0"></th>
          <th>{{ __('app.id') }}</th>
          <th>{{ __('app.name') }}</th>
          <th>{{ __('app.group') }}</th>
          <th>{{ __('app.type') }}</th>
          <th>{{ __('app.speed') }}</th>
          <th>{{ __('app.sent') }}</th>
          <th>{{ __('app.status') }}</th>
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
<input type="hidden" id="route" value="{{ route('group.delete', ['model' => 'sending_server']) }}">
<span id="sending-server-route" data-route="{{ route('sending_servers') }}">
<span id="tooltip-group-edit" data-value="{{ __('app.tooltip_group_edit') }}"></span>
<span id="route-group-edit" data-route="{{ route('group.update') }}"></span>
<span id="tooltip-group-delete-sending-server" data-value="{{ __('app.tooltip_group_delete_sending-server') }}"></span>
<span id="msg-group-delete-sending-server" data-value="{{ __('app.msg_group_delete_sending_server') }}"></span>
<span id="tooltip-group-eraser-sending-server" data-value="{{ __('app.tooltip_group_eraser_sending-server') }}"></span>
<span id="route-group-eraser-sending-server" data-route="{{ route('group.delete', ['model' => 'sending-server']) }}"></span>
<span id="msg-group-erase-sending-server" data-value="{{ __('app.msg_group_eraser_sending_server') }}"></span>
<!-- /.content -->
@include('groups.move')
@endsection
