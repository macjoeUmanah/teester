@extends('layouts.app')
@section('title', __('app.edit_contact'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script>loadListCustomFieldsWithData()</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.edit_contact') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li><a href="{{ route('contacts.index') }}">{{ __('app.contacts') }}</a></li>
    <li class="active">{{ __('app.edit_contact') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- form start -->
  <form class="form-horizontal" id="frm-contact">
    <input type="hidden" name="list_id" id="list-id" value="{{ $contact->list_id }}">
    <input type="hidden" name="contact_id" id="contact-id" value="{{ $contact->id }}">
    <div class="box box-default margin-bottom-0">
      @csrf
      <div class="box-header">
        <h3 class="box-title">{{ __('app.basic_detail') }}</h3>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.list') }}<span class="required">*</span></label>
          <div class="col-md-6">
            <label class="control-label"><strong>{{ !empty($contact->list->name) ? $contact->list->name : '---' }}</strong></label>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.contact_email') }}<span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <input type="email" class="form-control" name="email" value="{{ $contact->email }}" placeholder="{{ __('app.contact_email') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.contact_email') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.options') }}</label>
          <div class="col-md-10">
            <a href="#" data-toggle="tooltip" title="{{ __('help.contact_html') }}">
              <input class="form-control" type="checkbox" name="format" data-toggle="toggle" data-size="small" data-on="{{ __('app.html') }}" data-off="{{ __('app.text') }}" {{ $contact->format == 'HTML' ? 'checked' : '' }}>
            </a>&nbsp;&nbsp;
            <a href="#" data-toggle="tooltip" title="{{ __('help.contact_active') }}">
              <input class="form-control" type="checkbox" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.active') }}" data-off="{{ __('app.inactive') }}" {{ $contact->active == 'Yes' ? 'checked' : '' }}>
            </a>&nbsp;&nbsp;
            <a href="#" data-toggle="tooltip" title="{{ __('help.contact_confirmed') }}">
              <input class="form-control" type="checkbox" name="confirmed" data-toggle="toggle" data-size="small" data-on="{{ __('app.confirmed') }}" data-off="{{ __('app.unconfirmed') }}" {{ $contact->confirmed == 'Yes' ? 'checked' : '' }}>
            </a>&nbsp;&nbsp;
            <a href="#" data-toggle="tooltip" title="{{ __('help.contact_verified') }}">
              <input class="form-control" type="checkbox" name="verified" data-toggle="toggle" data-size="small" data-on="{{ __('app.verified') }}" data-off="{{ __('app.unverified') }}" {{ $contact->verified == 'Yes' ? 'checked' : '' }}>
            </a>&nbsp;&nbsp;
            <a href="#" data-toggle="tooltip" title="{{ __('help.contact_unsubscribed') }}">
              <input class="form-control" type="checkbox" name="unsubscribed" data-toggle="toggle" data-size="small" data-on="{{ __('app.subscribe') }}" data-off="{{ __('app.unsubscribed') }}" {{ $contact->unsubscribed == 'No' ? 'checked' : '' }}>
            </a>&nbsp;&nbsp;
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.bounced') }}</label>
          <div class="col-md-6">
            <a href="#" data-toggle="tooltip" title="{{ __('help.contact_bounced') }}">
              <input class="form-control" type="checkbox" data-onstyle="danger" data-offstyle="success" name="bounced" data-toggle="toggle" data-size="small" data-on="{{ __('app.yes') }}" data-off="{{ __('app.no') }}" {{ App\Models\ScheduleCampaignStatLogBounce::whereEmail($contact->email)->exists() ? 'checked' : '' }}>
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- /.box-body -->

    <div class="box box-default">
      <div class="box-header">
        <h3 class="box-title">{{ __('app.custom_fields') }}</h3>
      </div>
      <div class="box-body" id="list_custom_fields">
        <div class="col-md-offset-2 col-md-10">
          <h3>{{ __('app.none') }}</h3>
        </div>
      </div>
    </div>
    <!-- /.box-body -->

    <div class="form-group">
      <div class="col-md-offset-2 col-md-10">
        <button type="button" class="btn btn-primary loader" onclick="submitData(this, this.form, 'PUT', '{{ route('contact.update', ['id' => $contact->id]) }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
        <button type="button" class="btn btn-danger" onclick="exit()">{{ __('app.exit') }}</button>
      </div>
    </div>
  </form>
</section>
<!-- /.content -->
@endsection
