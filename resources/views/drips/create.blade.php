<link rel="stylesheet" href="{{asset('public/components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">

<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
<script src="{{asset('public/js/common.js')}}"></script>

<section class="content-header">
  <h1>{{ __('app.drips') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li><a href="{{ route('drips.index') }}">{{ __('app.drips') }}</a></li>
    <li>{{ __('app.add_new_drip') }}</li>
  </ol>
</section>

<div class="modal-content">
  <form class="form-horizontal" id="frm-group">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">{{ __('app.add_new_drip') }}</h4>
    </div>
    <div class="modal-body">
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.status') }}</label>
          <div class="col-md-2" data-toggle="tooltip" title="{{ __('help.drip_status') }}">
            <input type="checkbox" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.active') }}" data-off="{{ __('app.inactive') }}" checked="checked">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.group') }}
            <a href="javascript:;" onclick="viewModal('modal', '{{route('group.create', ['type_id' => config('mc.groups.drips')])}}');">
              <i class="fa fa-plus-square-o"></i>
            </a>
          </label>
          <div class="col-md-9">
            <div class="input-group from-group">
              <select name="group_id" id="groups" class="form-control">
                @foreach(\App\Models\Group::groups(config('mc.groups.drips')) as $id => $group_name)
                <option value="{{ $id }}">{{ Helper::decodeString($group_name) }}</option>
                @endforeach
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.drip_group') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.name') }} <span class="required">*</span></label>
          <div class="col-md-9">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="name" value="" placeholder="{{ __('app.name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.drip_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.broadcast') }}
            <a tabindex="-1" href="{{ route('broadcast.create') }}">
              <i class="fa fa-plus-square-o"></i>
            </a>
          </label>
          <div class="col-md-9">
            <div class="input-group from-group">
              @include('includes.one_select_dropdown_broadcast')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.drip_broadcast') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.send') }}</label>
          <div class="col-md-9">
            <div class="input-group from-group">
              <select name="send" id="send" class="form-control">
                <option value="Instant">{{ __('app.instant') }}</option>
                <option value="After">{{ __('app.after') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.drip_send') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group" id="send-datetime" style="display: none;">
          <label class="col-md-2 control-label">&nbsp;</label>
          <div class="col-md-5">
            <input type="number" min="0" class="form-control" name="time" value="" placeholder="">
          </div>
          <div class="col-md-4 padding-left-0">
            <select name="duration" class="form-control">
              <option value="minutes">{{ __('app.minutes') }}</option>
              <option value="hours">{{ __('app.hours') }}</option>
              <option value="days">{{ __('app.days') }}</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('drip.store') }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
      <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('drip.store') }}', 1);" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save_add_new') }}">{{ __('app.save_add_new') }}</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button>
    </div>
  </form>
</div>