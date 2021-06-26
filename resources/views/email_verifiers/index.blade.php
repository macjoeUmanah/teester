@extends('layouts.app')
@section('title', __('app.email_verifiers'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/datatables/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/js/datatable.init.js')}}"></script>
<script src="{{asset('public/components/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('public/js/email_verifier.js')}}"></script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.email_verifiers') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.setup') }}</li>
    <li class="active">{{ __('app.email_verifiers') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="col-md-12 add-button-margin z-index-1">
        <div class="left">
          <a href="javascript:;" onclick="viewModal('modal', '{{ route('email_verifier.create') }}')">
            <button class="btn btn-primary">{{ __('app.add_new_email_verifier') }}</button>
          </a>
          <a href="javascript:;" onclick="viewModal('modal', '{{ route('verify.email.list') }}')">
            <button class="btn btn-primary">{{ __('app.verify_list') }}</button>
          </a>
        </div>
        <div class="right">
          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ __('app.actions') }} <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="javascript:;" onclick="destroyMany('{{ route('email_verifier.destroy', ['id' => 0]) }}')"><i class="fa fa-trash"></i>{{ __('app.delete') }}</a></li>
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
          <th>{{ __('app.type') }}</th>
          <th>{{ __('app.verified') }}</th>
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
<span id="route-email-verifiers" data-route="{{ route('email.verifiers') }}"></span>
<!-- /.content -->
@endsection
