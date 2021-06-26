<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  </div>
  <div class="modal-body">{!! Helper::XSSReplaceTags(Helper::decodeString($template->content)) !!}
  </div>
</div>