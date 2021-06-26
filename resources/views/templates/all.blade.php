<script src="{{asset('public/js/custom.js')}}"></script>
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ __('app.templates') }}</h4>
  </div>
  <div class="modal-body">
    <div class="box-body margin-bottom-70">
      @forelse(\App\Models\Template::all() as $template)
      <div class='col-md-4 padding-top-10'><button class="btn btn-default btn-xs btn-block" onclick="insertCKEDITOR('{{ $template->id }}')">{{ $template->name }}</button></div>
      @empty
      <div class="col-md-offset-2 col-md-10">
        <h3>{{ __('app.no_record_found') }}</h3>
      </div>
      @endforelse
    </div>
  </div>
  <div class="modal-footer">
    <div class="col-md-offset-2 col-md-10">
      <a href="{{ route('template.create', ['t=1']) }}">
        <button class="btn btn-primary">{{ __('app.add_new_template') }}</button>
      </a>
      <a href="{{ route('template.create', ['t=2']) }}">
        <button class="btn btn-primary">{{ __('app.add_new_template_2') }}</button>
      </a>
      <a href="{{ route('template.create', ['t=3']) }}">
        <button class="btn btn-primary">{{ __('app.add_new_template_3') }}</button>
      </a>
      <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button>
    </div>
  </div>
</div>
<span id="insert-template-msg" data-value="{{__('app.insert_template_msg')}}"></span>