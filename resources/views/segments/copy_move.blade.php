<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
<div class="modal-content">
  <form class="form-horizontal" id="frm-list">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title" id="modal-title-group">{{$action}}</h4>
    </div>
    <div class="modal-body">
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ ($action == 'Move' || $action == 'Keep Moving') ? __('app.move_to') : __('app.copy_to') }}</label>
          <div class="col-md-9">
            @include('includes.one_select_dropdown_list')
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <input type="hidden" name="id" value="{{ $id }}">
      <input type="hidden" name="action" value="{{ $action }}">
      @if($action == 'Move' || $action == 'Keep Moving')
      <button type="button" class="btn btn-primary" onclick="moveCopySegment(this, '{{ route('segment.update.action', ['id' => $id]) }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.move') }}">{{ __('app.move') }}</button>
      @else
      <button type="button" class="btn btn-primary" onclick="moveCopySegment(this, '{{ route('segment.update.action', ['id' => $id]) }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.copy') }}">{{ __('app.copy') }}</button>
      @endif
      <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button></a>
    </div>
  </form>
</div>

