@extends('layouts.app')
@section('title', __('app.templates'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/datatables/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/js/datatable.init.js')}}"></script>
<script src="{{asset('public/components/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<script>
  $(function () {
   'use strict';
   var datatable = $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [0, 4]}],
    "order": [[0, "DESC"]],
    "lengthMenu": [[15, 50], [15, 50]],
    "ajax": "{{ route('templates') }}",
  });
 });
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.templates') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li class="active">{{ __('app.templates') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="col-md-12 add-button-margin">
        <div class="left">
          <a href="{{ route('template.create', ['t=1']) }}">
            <button class="btn btn-primary">{{ __('app.add_new_template') }}</button>
          </a>
          <a href="{{ route('template.create', ['t=2']) }}">
            <button class="btn btn-primary">{{ __('app.add_new_template_2') }}</button>
          </a>
          <a href="{{ route('template.create', ['t=3']) }}">
            <button class="btn btn-primary">{{ __('app.add_new_template_3') }}</button>
          </a>
        </div>
        <div class="btn-group right">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ __('app.actions') }} <span class="caret"></span></button>
          <ul class="dropdown-menu" role="menu">
            <li><a href="javascript:;" onclick="destroyMany('{{ route('template.destroy', ['id' => 0]) }}')"><i class="fa fa-trash"></i>{{ __('app.delete') }}</a></li>
          </ul>
        </div>
      </div>
      
      <table id="data" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th><input type="checkbox" id='checkAll' value="0"></th>
            <th>{{ __('app.id') }}</th>
            <th>{{ __('app.template_name') }}</th>
            <th>{{ __('app.created') }}</th>
            <th>{{ __('app.actions') }}</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
  <!-- /.box-body -->
</div>
</section>
<!-- /.content -->
@endsection