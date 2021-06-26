$(function () {
 'use strict';
 var datatable = $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [0, 6]}],
    "order": [[2, "asc"], [4, "asc"]],
    "lengthMenu": [[15, 50, 100], [15, 50, 100]],
    "ajax": $('#route-drips').data('route'),
    "drawCallback": function ( settings, data ) {
      var api = this.api();
      var rows = api.rows( {page:'current'} ).nodes();
      var last=null;
      var groupColumn = 2;
      api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
        if ( last !== group ) {
          $(rows).eq( i ).before(
            '<tr class="dt_group"><td colspan="6">'+group+'</td>'+
            '<td>'+
              '&nbsp;<i class="fa fa-edit" style="cursor: pointer;" title="'+$('#tooltip-group-edit').data('value')+'" onclick="editGroup(this, \''+$('#route-group-edit').data('route')+'\')"></i>'+
              '&nbsp;&nbsp;<i class="fa fa-trash" style="cursor: pointer;" title="'+$('#tooltip-group-delete-drip').data('value')+'" onclick="deleteGroup(this, \''+$('#msg-group-delete-drip').data('value')+'\')"></i>'+
              '&nbsp;&nbsp;<i class="fa fa-eraser" style="cursor: pointer;" title="'+$('#tooltip-group-eraser-drip').data('value')+'" onclick="eraseGroup(this, \''+$('#route-group-eraser-drip').data('route')+'\', \''+$('#msg-group-erase-drip').data('value')+'\')"></i>'+
            '</td></tr>'
          );
          last = group;
        }
      });
    },
  });
  $("#modal").on("hidden.bs.modal", function () {
    datatable.ajax.reload(null, false); // user paging is not reset on reload
  });
});