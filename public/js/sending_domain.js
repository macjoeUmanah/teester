$(function () {
  'use strict';
  $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [0, 10]}],
    "order": [[0, "DESC"]],
    "lengthMenu": [[15, 50], [15, 50]],
    "ajax": $('#route-sending-domain').data('route'),
  })
});