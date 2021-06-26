$(function() {
  'use strict';
  $('.btn-save').on('click', function() {
    $("input.form-control").removeClass('has-error');
    var name = $('#template-name').val();
    if($.trim(name) == '') {
      var v = $("[name='name']").closest("input.form-control");
      v.addClass('has-error');
      toastr.error($('#builder-msg-name-required').data('value'));
      return;
    }

    var action = $('#action').val();
    var id = $('#id').val();
    var html = atob($('.templateHTML').val());
    if($.trim(html) == '') {
      return;
    }

    $.ajax({
      type: "POST",
      url: getAppURL()+"/template_save",
      data: {action: action, id: id, name: name, content: html, type:1},
      success: function(id) {
        console.log(id);
        toastr.success($('#msg-saved').data('value'));
        $('#action').val('edit');
        $('#id').val(id);
      }
    });
  });

  $('.btn-cancel').on('click', function() {
    swal({
      title: $('#builder-mgs-cancel').data('value'),
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes",
      closeOnConfirm: false
    }, function (isConfirm) {
      if(isConfirm) {
       window.top.location.href = getAppURL()+"/templates";
     }
   });
  });
})
function getAppURL(){
  return window.location.protocol+'//'+window.location.hostname;
}