$(function() {
  'use strict';
  var datatable = $('#data').DataTable({
    "lengthMenu": [[15, 50], [15, 50]],
    "columnDefs": [{"sortable": false, "targets": [0, 5]}],
    "order": [[0, "DESC"]],
    "ajax": $('#route-custom-fields').data('route'),
  });
  $("#modal").on("hidden.bs.modal", function () {
    datatable.ajax.reload(null, false); // user paging is not reset on reload
  });
});