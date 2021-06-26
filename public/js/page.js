$(function () {
 'use strict';
 var datatable = $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [0, 3]}],
    "order": [[2, "DESC"]],
    "lengthMenu": [[15, 50], [15, 50]],
    "ajax": $('#route-pages').data('route'),
    "drawCallback": function ( settings, data ) {
      var api = this.api();
      var rows = api.rows( {page:'current'} ).nodes();
      var last=null;
      var groupColumn = 1;
      api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
        if ( last !== group ) {
          $(rows).eq( i ).before(
            '<tr class="dt_group"><td colspan="4">'+group+'</td></tr>'
          );
          last = group;
        }
      });
    },
  });
});