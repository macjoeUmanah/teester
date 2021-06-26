$(function () {
  $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [0, 8]}],
    "order": [[3, "asc"], [8, "desc"]],
    "lengthMenu": [[15, 50, 100], [15, 50, 100]],
    "ajax": $('#sending-server-route').data('route'),
    "drawCallback": function ( settings, data ) {
      var api = this.api();
      var rows = api.rows( {page:'current'} ).nodes();
      var last=null;
      var groupColumn = 3;
      api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
        if ( last !== group ) {
          $(rows).eq( i ).before(
            '<tr class="dt_group"><td colspan="9">'+group+'</td>'+
            '<td>'+
              '&nbsp;<i class="fa fa-edit" style="cursor: pointer;" title="'+$('#tooltip-group-edit').data('value')+'" onclick="editGroup(this, \''+$('#route-group-edit').data('route')+'\')"></i>'+
              '&nbsp;&nbsp;<i class="fa fa-trash" style="cursor: pointer;" title="'+$('#tooltip-group-delete-sending-server').data('value')+'" onclick="deleteGroup(this, \''+$('#msg-group-delete-sending-server').data('value')+'\')"></i>'+
              '&nbsp;&nbsp;<i class="fa fa-eraser" style="cursor: pointer;" title="'+$('#tooltip-group-eraser-sending-server').data('value')+'" onclick="eraseGroup(this, \''+$('#route-group-eraser-sending-server').data('route')+'\', \''+$('#msg-group-erase-sending-server').data('value')+'\')"></i>'+
            '</td></tr>'
          );
          last = group;
        }
      });
    },
  });
});