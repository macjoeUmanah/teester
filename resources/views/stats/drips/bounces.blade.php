<script>
$(function () {
 $('#data-bounces').DataTable({
    "order": [[7, "DESC"]],
    "lengthMenu": [[50, 100], [50, 100]],
    "ajax": {
      "url" : "{{ route('drip.bounces') }}",
      "data" : {
        "stat_id" : "{{ $stat_id }}"
      }
    }
  });
});
</script>
<table id="data-bounces" class="table table-bordered table-striped" style="width: 100%">
  <thead>
  <tr>
    <th>{{ __('app.drip') }}</th>
    <th>{{ __('app.email') }}</th>
    <th>{{ __('app.list') }}</th>
    <th>{{ __('app.sending_server') }}</th>
    <th>{{ __('app.message_id') }}</th>
    <th>{{ __('app.type') }}</th>
    <th>{{ __('app.code') }}</th>
    <th>{{ __('app.detail') }}</th>
    <th>{{ __('app.datetime') }}</th>
  </tr>
  </thead>
  <tbody>
  </tbody>
</table>


