<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
<div class="modal-content">
  <form class="form-horizontal" id="frm">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">{{ __('app.verify_list') }}</h4>
    </div>
    <div class="modal-body">
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.lists') }}
            <a href="{{ route('list.create') }}">
              <i class="fa fa-plus-square-o"></i>
            </a>
            <span class="required">*</span>
          </label>
          <div class="col-md-8">
            <div class="input-group from-group">
              @include('includes.multi_select_dropdown_list')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.verify_list') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.type') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <select name="type" id="type-email-verifier" class="form-control" >
                @foreach($email_verifiers as $verifier)
                <option value="{{ $verifier->id }}">{{ $verifier->name }}</option>
                @endforeach
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.email_verifiers_type') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div id="email_verifiers-attributes"></div>
      </div>
    </div>
    <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('verify.email.list') }}', 0, 0, 0, '{{ __('app.msg_list_verify') }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.verify') }}">{{ __('app.verify') }}</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button>
    </div>
  </form>
</div>
