$(function() {
  'use strict';
  $('#btn-update').on('click', function() {
    swal({
      title: '',
      text: $('#update-proceed-msg').data('value'),
      type: "warning",
      showCancelButton: true,
      cancelButtonText: "Cancel",
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes",
      closeOnConfirm: true
    },
    function(){
      $.ajax({
        url: $(this).data('route'),
        method: 'POST',
        data: {license_key: $('#license_key').val()},
        beforeSend: function() {
          $('#btn-update').button('loading');
          $('#msg').html($('#update-warning-msg').data('value'));
          $('#msg').removeClass('text-red');
          $('#msg').removeClass('text-green');
        },
        success: function(result) {
          if(!result.verify) {
            $('#msg').addClass('text-red');
          } else {
            $('#msg').addClass('text-green');
          }
          if(result.message) {
            $('#msg').html(result.message);
          }
          else {
            $('#msg').html(result);
          }
          console.log(result);
          $('#btn-update').button('reset');
        }
      });
    });
  });
});