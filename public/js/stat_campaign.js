$(function () {
  'use strict';
  $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [6,7,9]}],
    "order": [[6, "DESC"]],
    "lengthMenu": [[15, 50], [15, 50]],
    "ajax": {
      "url" : "{{ route('stats.campaigns') }}"
    },
  });
});