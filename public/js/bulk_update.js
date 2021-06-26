$("#option").change(function() {
  var option = $("#option option:selected").val();
  if(option == 'file') {
    $("#section-emails,#btn-save").hide();
    $("#section-file,#btn-import,#info-filesize").show();
  } else {
    $("#section-emails,#btn-save").show();
    $("#section-file,#btn-import,#info-filesize").hide();
  }
});

$("#section-file,#btn-import,#info-filesize").hide();
$('#clear').click(function() {
  $(":file").filestyle('clear');
});

$("#based-on").change(function() {
  if(this.value == 'list') {
    $(".based-on-global").hide('slow');
    $(".based-on-list").show('slow');
    $("#section-emails,#section-file,#btn-import,#info-filesize").hide();
    $("#btn-save").show();
  } else {
    $(".based-on-list").hide('slow');
    $(".based-on-global").show('slow');
  }
});
function getAppURL(){
  return window.location.protocol+'//'+window.location.hostname;
}
function importBulkUpdate(button, frm) {
  $("div.form-group").removeClass('has-error');
  $("div.form-group").children('span').html('');
  var route =  getAppURL()+"/list/bulk_update";
  $(button).button('loading');

  var frm_data = new FormData(frm);
  if($('#file').length){
    var file_data = $('#file').prop('files')[0];
    frm_data.append('file', file_data);
  }

  $.ajax({
    url: route,
    type: 'POST',
    data: frm_data,
    cache: false,
    contentType: false,
    processData: false,
    success: function(result) {
      $(button).button('reset');
      toastr.success($('#msg_update').data('value'));
    },
    error: function(result) {
      errors(button, result);
      return false;
    }
  });
  return true;
}