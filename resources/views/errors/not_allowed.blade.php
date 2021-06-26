@extends('layouts.app')
@section('title', 403)
@section('content')
  <!-- Main content -->
  <section class="content">
    <div class="error-page">
      <h2 class="headline text-yellow"> 403</h2>

      <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i>{{ __('app.msg_limit_over') }} {{ $module}}</h3>
      </div>
      <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
  </section>
  <!-- /.content -->
@endsection
