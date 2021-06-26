<script>
$(function () {
 $('#data-logs').DataTable({
    "order": [[5, "DESC"]],
    "lengthMenu": [[50, 100], [50, 100]],
    "ajax": {
      "url" : "{{ route('auto_followup.logs') }}",
      "data" : {
        "stat_id" : "{{ $stat_id }}"
      }
    }
  });
});
</script>
<table id="data-logs" class="table table-bordered table-striped" style="width: 100%">
  <thead>
  <tr>
    <th>{{ __('app.email') }}</th>
    <th>{{ __('app.list') }}</th>
    <th>{{ __('app.sending_server') }}</th>
    <th>{{ __('app.message_id') }}</th>
    <th>{{ __('app.latest_activity') }}</th>
    <th>{{ __('app.datetime') }}</th>
  </tr>
  </thead>
  <tbody>
  </tbody>
</table>


