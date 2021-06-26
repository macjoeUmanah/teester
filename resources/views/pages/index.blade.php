@extends('layouts.app')
@section('title', __('app.pages_emails'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/datatables/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/js/datatable.init.js')}}"></script>
<script src="{{asset('public/components/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('public/js/page.js')}}"></script>

@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.pages_emails') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.layouts') }}</li>
    <li class="active">{{ __('app.pages_emails') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="col-md-12 add-button-margin">
        <div class="left">
          <div class="btn-group">
            <a href="{{route('page.create')}}"><button class="btn btn-primary">{{ __('app.create_new') }} {{ __('app.email') }}</button></a>
          </div>
        </div>
      </div>
      <table id="data" class="table table-bordered table-striped" style="width: 100%">
        <thead>
        <tr>
          <th>{{ __('app.page_name') }}</th>
          <th>{{ __('app.page_type') }}</th>
          <th>{{ __('app.page_eamil_subject') }}</th>
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
<span id="route-pages" data-route="{{ route('pages') }}"></span>
<!-- /.content -->
@endsection