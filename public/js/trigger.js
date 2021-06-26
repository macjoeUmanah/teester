$(function () {
  var datatable = $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [0, 5]}],
    "order": [[0, "DESC"]],
    "lengthMenu": [[15, 50], [15, 50]],
    "ajax": $('#route-triggers').data('route'),
  });
  $("#modal").on("hidden.bs.modal", function () {
    datatable.ajax.reload(null, false); // user paging is not reset on reload
  });
});
function restartTrigger(id, msg='Are you sure to restart the trigger?') {
  swal({
    title: '',
    text: msg,
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Restart Trigger",
    closeOnConfirm: true
  },
  function(){
    $.ajax({
      url: getAppURL()+"/restartTrigger/"+id,
      method: 'PUT',
      data: {in_progress:0},
      beforeSend: function() {
        //$('#modal-list').html("<i class='fa fa-circle-o-notch fa-spin fa-5x'></i>");
        $('#modal').modal('show');
      },
      success: function(result) {
        if(result) {
          $('#modal').modal('hide');
          toastr.success('Trigger restarted successfully.');
        } else {
          toastr.error('Found some error(s).');
        }
      }
    });
    
  });
}