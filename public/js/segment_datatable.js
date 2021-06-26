$(function () {
  var datatable = $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [0, 6]}],
    "order": [[0, "DESC"]],
    "lengthMenu": [[15, 50], [15, 50]],
    "ajax": {
      "url" : $('#segments').data('route')
    },
  });
  $("#modal").on("hidden.bs.modal", function () {
    datatable.ajax.reload(null, false); // user paging is not reset on reload
  });
  setInterval(function(){ datatable.ajax.reload(null, false); }, 60*1000); // 60 sec
});