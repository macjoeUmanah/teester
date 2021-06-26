@extends('layouts.app')
@section('title', __('app.contacts'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/datatables/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/js/datatable.init.js')}}"></script>
<script src="{{asset('public/components/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('public/js/contact.js')}}"></script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.contacts') }} {!! !empty($list_id) ? "<small> ( $list_name ) </small>" : '' !!}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.contacts') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="col-md-12 add-button-margin">
        <div class="left">
          <div class="btn-group">
            <a href="{{ route('contact.create') }}"><button class="btn btn-primary">{{ __('app.add_new_contact') }}</button></a>
            @can('import_contacts')
            <a href="{{ route('contacts.import', ['list_id' => 0]) }}"><button class="btn btn-primary">{{ __('app.import_contacts') }}</button></a>
            @endcan
          </div>
        </div>
        <div class="right">
          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ __('app.actions') }} <span class="caret"></span></button>
            <ul class="dropdown-menu pull-right">
              @can('delete_user')
                <li><a href="javascript:;" onclick="destroyMany('{{route('contact.destroy', ['id' => 0])}}')"><i class="fa fa-trash"></i>{{ __('app.delete') }}</a></li>
              @endcan
              @can('export_contacts')
                @if($list_id != 0)
                  <li><a href="javascript:;" onclick="listExport('{{route('contacts.export', ['list_id' => $list_id])}}', '{{__('app.msg_export_list')}}')"><i class="fa fa-upload"></i>{{ __('app.export_all_contacts') }}</a></li>
                  <li><a href="javascript:;" onclick="listExport('{{route('contacts.export', ['list_id' => $list_id, 'active'])}}', '{{__('app.msg_export_list')}}')"><i class="fa fa-upload"></i>{{ __('app.export_contacts_active') }}</a></li>
                  <li><a href="javascript:;" onclick="listExport('{{route('contacts.export', ['list_id' => $list_id, 'inactive'])}}', '{{__('app.msg_export_list')}}')"><i class="fa fa-upload"></i>{{ __('app.export_contacts_inactive') }}</a></li>
                  <li><a href="javascript:;" onclick="listExport('{{route('contacts.export', ['list_id' => $list_id, 'confirmed'])}}', '{{__('app.msg_export_list')}}')"><i class="fa fa-upload"></i>{{ __('app.export_contacts_confirmed') }}</a></li>
                  <li><a href="javascript:;" onclick="listExport('{{route('contacts.export', ['list_id' => $list_id, 'notconfirmed'])}}', '{{__('app.msg_export_list')}}')"><i class="fa fa-upload"></i>{{ __('app.export_contacts_not_confirmed') }}</a></li>
                  <li><a href="javascript:;" onclick="listExport('{{route('contacts.export', ['list_id' => $list_id, 'verified'])}}', '{{__('app.msg_export_list')}}')"><i class="fa fa-upload"></i>{{ __('app.export_contacts_verified') }}</a></li>
                  <li><a href="javascript:;" onclick="listExport('{{route('contacts.export', ['list_id' => $list_id, 'notverified'])}}', '{{__('app.msg_export_list')}}')"><i class="fa fa-upload"></i>{{ __('app.export_contacts_not_verified') }}</a></li>
                  <li><a href="javascript:;" onclick="listExport('{{route('contacts.export', ['list_id' => $list_id, 'notunsubscribed'])}}', '{{__('app.msg_export_list')}}')"><i class="fa fa-upload"></i>{{ __('app.export_contacts_not_unsubscribed') }}</a></li>
                  <li><a href="javascript:;" onclick="listExport('{{route('contacts.export', ['list_id' => $list_id, 'unsubscribed'])}}', '{{__('app.msg_export_list')}}')"><i class="fa fa-upload"></i>{{ __('app.export_contacts_unsubscribed') }}</a></li>
                @endif
              @endcan
            </ul>
          </div>
        </div>
        <div class="col-md-3">
          <select class="form-control" name="list_id" onchange="goList(this.value)">
            <option value="0">{{ __('app.view_all_contacts') }}</option>
            @foreach(\App\Models\Lists::groupLists() as $group)
              <optgroup label="{{ $group->name }}">
              @foreach($group->lists as $list)
                <option value="{{$list->id}}" {{$list->id == $list_id ? 'selected' : ''}}>{{$list->name}}</option>
              @endforeach
            @endforeach
          </select>
        </div>
      </div>
      <table id="data" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th><input type="checkbox" id='checkAll' value="0"></th>
            <th>{{ __('app.id') }}</th>
            <th>{{ __('app.contact_email') }}</th>
            <th>{{ __('app.list_name') }}</th>
            <th>{{ __('app.format') }}</th>
            <th>{{ __('app.active') }}</th>
            <th>{{ __('app.confirmed') }}</th>
            <th>{{ __('app.verified') }}</th>
            <th>{{ __('app.unsubscribed') }}</th>
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
<span id="route-contacts" data-route="{{ route('contacts') }}"></span>
<span id="list-id" data-value="{{ $list_id }}"></span>
<!-- /.content -->
@endsection
