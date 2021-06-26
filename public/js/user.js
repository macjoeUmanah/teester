$(function () {
  $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [0, 7]}],
    "order": [[ 2, "asc" ], [ 6, "desc" ]],
    "lengthMenu": [[15, 50, 100], [15, 50, 100]],
    "ajax": $('#route-users').data('route'),
    "drawCallback": function ( settings ) {
      var api = this.api();
      var rows = api.rows( {page:'current'} ).nodes();
      var last=null;
      api.column(groupColumn=2, {page:'current'} ).data().each( function ( group, i ) {
        if ( last !== group ) {
          $(rows).eq( i ).before(
            '<tr class="dt_group"><td colspan="8">'+group+'</td></tr>'
          );
          last = group;
        }
      });
    },
  });
});