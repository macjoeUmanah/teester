$(function () {
  'use strict';
  var datatable = $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [1]}],
    "order": [[1, "DESC"]],
    "lengthMenu": [[50, 100, 500], [50, 100, 500]],
    "ajax": $('#route-logs').data('route'),
    "fnRowCallback" : function(row, data, displayNum){
      $("td:first", row).html(displayNum +1);
      return row;
    },
  });
});