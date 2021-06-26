<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ __('app.broadcast') }}</h4>
  </div>
  <div class="modal-body">
    <div class="box-body">
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.name') }}</label>
        <div class="col-md-9">{{ Helper::decodeString($broadcast->name) }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.group') }}</label>
        <div class="col-md-9">{{ Helper::decodeString($broadcast->group->group_name) }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.email_subject') }}</label>
        <div class="col-md-9">{{ Helper::decodeString($broadcast->email_subject) }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.created') }}</label>
        <div class="col-md-9">{{ \Helper::datetimeDisplay($broadcast->created_at) }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.created') }}</label>
        <div class="col-md-9">{!! Helper::decodeString($broadcast->content_html) !!}</div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <a href="{{ route('broadcast.edit', ['id' => $broadcast->id]) }}"><button type="button" class="btn btn-primary">{{ __('app.edit') }}</button></a>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
  </div>
  </div>
</div>