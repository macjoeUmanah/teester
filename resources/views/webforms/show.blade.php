<script>
  $(function () {
    $('.btn-copy').click(function() {
      document.getElementById("form-html").select();
      document.execCommand("copy");
      toastr.success('Copied successfully!');
    })
  });
</script>
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ $webform->name }}</h4>
  </div>
  <div class="modal-body"> 
      <div class="box-body">
        @if($get_html)
          <textarea class="form-control" id="form-html" style="height: 500px;">
        @endif
        <form class="form-horizontal" method="post" action="{{ route('webform.save.data') }}">
          <div class="form-group">
            <label class="col-md-2 control-label">{{ __('app.contact_email') }}</label>
            <div class="col-md-6 ">
              <input type="email" class="form-control" name="email" value="" required="required">
            </div>
          </div>
          @include('contacts.list_custom_fields')
          <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
              <input type="hidden" name="form_id" value="{{ $webform->id }}">
              <button type="submit" class="btn btn-primary">{{ __('app.submit') }}</button>
            </div>
          </div>
        </form>
        @if($get_html)
          </textarea>
        @endif
    </div>
  </div>
  <div class="modal-footer">
    @if($get_html)
      <button type="button" class="btn btn-primary" onclick="viewModal('modal', '{{route('webform.show', ['id' => $webform->id])}}')">{{ __('app.view') }}</button>
      <button type="button" class="btn btn-primary btn-copy">{{ __('app.copy') }}</button>
    @endif
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
  </div>
</div>