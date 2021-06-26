<script>
$(function () {
 $('#data-spam').DataTable({
    "order": [[5, "DESC"]],
    "lengthMenu": [[50, 100], [50, 100]],
    "ajax": {
      "url" : "{{ route('auto_followup.spam') }}",
      "data" : {
        "stat_id" : "{{ $stat_id }}"
      }
    }
  });
});
</script>
<table id="data-spam" class="table table-bordered table-striped" style="width: 100%">
  <thead>
  <tr>
    <th>{{ __('app.email') }}</th>
    <th>{{ __('app.list') }}</th>
    <th>{{ __('app.sending_server') }}</th>
    <th>{{ __('app.message_id') }}</th>
    <th>{{ __('app.detail') }}</th>
    <th>{{ __('app.datetime') }}</th>
  </tr>
  </thead>
  <tbody>
  </tbody>
</table>


