$(function () {
  'use strict';
  $('[data-toggle="tooltip"]').tooltip();
  $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [0, 6]}],
    "order": [[3, "asc"], [0, "desc"]],
    "lengthMenu": [[15, 50, 100], [15, 50, 100]],
    "ajax": $('#get-lists').data('route'),
    "drawCallback": function ( settings, data ) {
      var api = this.api();
      var rows = api.rows( {page:'current'} ).nodes();
      var last=null;
      var groupColumn=3;
      api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
        if ( last !== group ) {
          $(rows).eq( i ).before(
            '<tr class="dt_group"><td colspan="6">'+group+'</td>'+
            '<td>'+
              '&nbsp;<i class="fa fa-edit" style="cursor: pointer;" title="'+$('#tooltip-group-edit').data('value')+'" onclick="editGroup(this, \''+$('#route-group-edit').data('route')+'\')"></i>'+
              '&nbsp;&nbsp;<i class="fa fa-trash" style="cursor: pointer;" title="'+$('#tooltip-group-delete-list').data('value')+'" onclick="deleteGroup(this, \''+$('#msg-group-delete-list').data('value')+'\')"></i>'+
              '&nbsp;&nbsp;<i class="fa fa-eraser" style="cursor: pointer;" title="'+$('#tooltip-group-eraser-list').data('value')+'" onclick="eraseGroup(this, \''+$('#route-group-eraser-list').data('route')+'\', \''+$('#msg-group-erase-list').data('value')+'\')"></i>'+
            '</td></tr>'
          );
          last = group;
        }
      });
    },
  });
});