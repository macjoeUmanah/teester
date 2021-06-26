$(function () {
  'use strict';
  $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [0, 5]}],
    "order": [[3, "asc"], [0, "desc"]],
    "lengthMenu": [[15, 50], [15, 50]],
    "ajax": $('#broadcasts').data('route'),
    "drawCallback": function ( settings, data ) {
      var api = this.api();
      var rows = api.rows( {page:'current'} ).nodes();
      var last=null;
      var groupColumn = 3;
      api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
        if ( last !== group ) {
          $(rows).eq( i ).before(
            '<tr class="dt_group"><td colspan="5">'+group+'</td>'+
            '<td>'+
            '&nbsp;<i class="fa fa-edit" style="cursor: pointer;" title="'+$('#tooltip-group-edit').data('value')+'" onclick="editGroup(this, \''+$('#route-group-edit').data('route')+'\')"></i>'+
              '&nbsp;&nbsp;<i class="fa fa-trash" style="cursor: pointer;" title="'+$('#tooltip-group-delete-broadcast').data('value')+'" onclick="deleteGroup(this, \''+$('#msg-group-delete-broadcast').data('value')+'\')"></i>'+
              '&nbsp;&nbsp;<i class="fa fa-eraser" style="cursor: pointer;" title="'+$('#tooltip-group-eraser-broadcast').data('value')+'" onclick="eraseGroup(this, \''+$('#route-group-eraser-broadcast').data('route')+'\', \''+$('#msg-group-erase-broadcast').data('value')+'\')"></i>'+
            '</td></tr>'
          );
          last = group;
        }
      });
    },
  });
});