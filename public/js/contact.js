$(function () {
  'use strict';
  $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [0, 3, 9]}],
    "order": [[0, "DESC"]],
    "lengthMenu": [[50, 100, 500], [50, 100, 500]],
    "ajax": {
      "url" : $('#route-contacts').data('route'),
      "data" : {
        "list_id" : $('#list-id').data('value')
      }
    },
  })
});