$(function () {
 'use strict';
 var datatable = $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [0, 3]}],
    "order": [[0, "DESC"]],
    "lengthMenu": [[15, 50], [15, 50]],
    "ajax": $('#spintags').data('route'),
  });
  $("#modal").on("hidden.bs.modal", function () {
    datatable.ajax.reload(null, false); // user paging is not reset on reload
  });
});