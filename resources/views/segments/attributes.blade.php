<script src="{{asset('public/js/multiselect.js')}}"></script>
@if($segment_action == 'is_opened')
<div class="form-group" id="div-country">
  <label class="col-md-2 control-label">{{ __('app.country') }}</label>
  <div class="col-md-6">
    <div class="input-group from-group">
     <select class='form-control multi' multiple='multiple' name='countries[]'>
        @if(!empty($segment))
          @php $countries = !empty(json_decode($segment->attributes)->countries) ? json_decode($segment->attributes)->countries : '' @endphp
        @endif
        @foreach(\Helper::countries() as $code => $country)
        <option value="{{ $code }}"  {{ !empty($countries) && in_array($code, $countries) ? 'selected="selected"' : '' }}>{{ $country}}</option>
        @endforeach
      </select>
      <div class="input-group-addon input-group-addon-right">
        <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.segment_countries') }}"></i>
      </div>
    </div>
  </div>
</div>
@endif

@if($segment_action == 'is_clicked')
@php
if(!empty($segment)) {
  $segment_attributes =  json_decode($segment->attributes);
  $links = $segment_attributes->links;
}
@endphp
<div class="form-group" id="div-country">
  <label class="col-md-2 control-label">{{ __('app.link') }}</label>
  <div class="col-md-6">
    <div class="input-group from-group">
      <select class='form-control multi' multiple='multiple' name='links[]'>
        @if(!empty($scheduled_ids))
          @foreach(\App\Models\ScheduleCampaignStat::getScheduledCampaignLinks($scheduled_ids) as $link)
            <option value="{{ $link }}" {{ !empty($links) && in_array($link, $links) ? 'selected="selected"' : '' }}>{{ $link}}</option>
          @endforeach
        @else
          <option></option>
        @endif
      </select>
    <div class="input-group-addon input-group-addon-right">
      <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.segment_countries') }}"></i>
    </div>
  </div>
  </div>
</div>
@endif