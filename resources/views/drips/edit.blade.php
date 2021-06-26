<link rel="stylesheet" href="{{asset('public/components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
<script src="{{asset('public/js/common.js')}}"></script>

<div class="modal-content">
  <form class="form-horizontal" id="frm-group">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">{{ __('app.edit_drip') }}</h4>
    </div>
    <div class="modal-body">
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.status') }}</label>
          <div class="col-md-2" data-toggle="tooltip" title="{{ __('help.drip_status') }}">
            <input type="checkbox" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.active') }}" data-off="{{ __('app.inactive') }}" {{ $drip->active == 'Yes' ? 'checked="checked"' : ''}}>
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
                <option value="{{ $id }}" {{ $id == $drip->group_id ? 'selected="selected"' : '' }}>{{ Helper::decodeString($group_name) }}</option>
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
            <input type="text" class="form-control" name="name" value="{{ Helper::decodeString($drip->name) }}" placeholder="{{ __('app.drip_name') }}">
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
              @php $broadcast_id = $drip->broadcast_id @endphp
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
                <option value="Instant" {{ $drip->send == 'Instant' ? 'selected="selected"' : '' }}>{{ __('app.instant') }}</option>
                <option value="After" {{ $drip->send == 'After' ? 'selected="selected"' : '' }}>{{ __('app.after') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.drip_send') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group" style="{{ $drip->send == 'Instant' ? 'display:none' : '' }}" id="send-datetime">
          <label class="col-md-2 control-label">&nbsp;</label>
          <div class="col-md-5">
            <input type="number" min="0" class="form-control" name="time" value="{{ json_decode($drip->send_attributes)->time }}" placeholder="">
          </div>
          <div class="col-md-4 padding-left-0"> 
            <select name="duration" class="form-control">
              <option value="minutes" {{ json_decode($drip->send_attributes)->duration == 'minutes' ? 'selected="selected"' : '' }}>{{ __('app.minutes') }}</option>
              <option value="hours" {{ json_decode($drip->send_attributes)->duration == 'hours' ? 'selected="selected"' : '' }}>{{ __('app.hours') }}</option>
              <option value="days" {{ json_decode($drip->send_attributes)->duration == 'days' ? 'selected="selected"' : '' }}>{{ __('app.days') }}</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'PUT', '{{ route('drip.update', ['id' => $drip->id]) }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button>
    </div>
  </form>
</div>