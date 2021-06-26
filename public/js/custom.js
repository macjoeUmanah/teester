$(function () {
  $('.btn-auth').on('click', function() {
    var $this = $(this);
    $this.button('loading');
  });
});
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
// get errors 
function errors(button, result) 
{
  try {
    var errors = result.responseJSON.errors;
    for (error in errors) {
      toastr.error(errors[error]);
      var v = $("[name='"+error+"']").closest("div.form-group");
      v.addClass('has-error');
      v.children('span').html('<i class="fa fa-question-circle-o" title="'+errors[error]+'""></i>');
    }
  }
  catch(err) {
    alert(err.message);
  }
  //toastr.error('Found some error(s).');
  $(button).button('reset');
}
function submitData(button, frm, method, route, save_add_action=0, display_msg=1, redirect=0, custom_msg=null) {
  $("div.form-group").removeClass('has-error');
  $("div.form-group").children('span').html('');
  $(button).button('loading');

    if($('#file').length){
      var frm_data = new FormData(frm);
      var file_data = $('#file').prop('files')[0];
      frm_data.append('file', file_data);
      var content_type = false;
    } else {
      var content_type = 'application/x-www-form-urlencoded';
      var frm_data = $(frm).serialize();
    }

  $.ajax({
    url: route,
    type: method,
    data: frm_data,
    cache: false,
    contentType: content_type,
    processData: false,
    success: function(result) {
      //console.log(result);
      if(display_msg) {
        toastr.success('Saved successfully.');
      }
      if(custom_msg) {
        toastr.success(custom_msg);
      }
      if(save_add_action == 1) {
        $('#'+frm.id)[0].reset();
      } else if(save_add_action == 2) {
        setInterval(function(){ window.history.back(); }, 500);
      }
      if(redirect) {
        document.location.href = result;
      }
      $(button).button('reset');
    },
    error: function(result) {
      errors(button, result);
      return false;
    }
  });
  return true;
}

function bouncesImport(button, frm, route) {
  $("div.form-group").removeClass('has-error');
  $("div.form-group").children('span').html('');
  $(button).button('loading');

  var frm_data = new FormData(frm);
  var file_data = $('#file').prop('files')[0];
  frm_data.append('file', file_data);

  $.ajax({
    url: route,
    type: 'POST',
    data: frm_data,
    cache: false,
    contentType: false,
    processData: false,
    success: function(result) {
      $.ajax({
        url: route,
        method: 'POST',
        data: {fieldMapping: 1},
        beforeSend: function() {
          $("#file").prop('disabled', true);
          $('#fields-mapping').show();
          $('#bounce-fields').html('<div class="col-md-offset-2 col-md-10">'+
            '<i class="fa fa-spinner fa-spin fa-3x" aria-hidden="true"></i></div>');
        },
        success: function(result) {
          $('#bounce-fields').html(result);
          $(button).button('reset');
          $('#btn-import').show();
          $('#btn-proceed').hide();
        }
      });
    },
    error: function(result) {
      errors(button, result);
      return false;
    }
  });
  return true;
}

function doBouncesImport(button, frm, route) {
  var frm_data = new FormData(frm);
  var file_data = $('#file').prop('files')[0];
  frm_data.append('file', file_data);
  frm_data.append('do_import', 1);
  

  $.ajax({
    url: route,
    type: 'POST',
    data: frm_data,
    cache: false,
    contentType: false,
    processData: false,
    beforeSend: function() {
      $(button).button('loading');
    },
    success: function(data) {
      $('#fields-mapping').hide();
      $('#btn-import').hide();
      toastr.success('Import successfully.');
    }
  });
  return true;
}

function contactsImport(button, frm, route) {
  $("div.form-group").removeClass('has-error');
  $("div.form-group").children('span').html('');
  $(button).button('loading');
  var frm_data = new FormData(frm);
  var file_data = $('#file').prop('files')[0];
  frm_data.append('file', file_data);

  $.ajax({
    url: route,
    type: 'POST',
    data: frm_data,
    cache: false,
    contentType: false,
    processData: false,
    success: function(result) {
      var list_id = $('#lists').val();
      $.ajax({
        url: route,
        method: 'POST',
        data: {fieldMapping: 1, list_id: list_id},
        beforeSend: function() {
          $("#file").prop('disabled', true);
          $('#fields-mapping').show();
          $('#list-custom-fields').html('<div class="col-md-offset-2 col-md-10">'+
            '<i class="fa fa-spinner fa-spin fa-3x" aria-hidden="true"></i></div>');
        },
        success: function(result) {
          $('#list-custom-fields').html(result);
          $(button).button('reset');
          $('#btn-import').show();
          $('#btn-proceed').hide();
        }
      });
    },
    error: function(result) {
      errors(button, result);
      return false;
    }
  });
  return true;
}

function doContactsImport(frm, route) {
  var frm_data = new FormData(frm);
  var file_data = $('#file').prop('files')[0];
  frm_data.append('file', file_data);
  frm_data.append('do_import', 1);
  

  $.ajax({
    url: route,
    type: 'POST',
    data: frm_data,
    cache: false,
    contentType: false,
    processData: false,
    beforeSend: function() {
      $("#lists,#duplicates,#format,#active,#confirmed,#unsubscribed").prop('disabled', true);
      $('#btn-import').hide();
      $('#fields-mapping').hide();
      $('#import-contacts').show();
    },
    success: function(id) {
      contactsImportStatus(id);
    }
  });
  return true;
}

function contactsImportStatus(id) {
  var route = getAppURL()+"/contacts-import-status/"+id;
  $.ajax({
    url: route,
    type: 'GET',
    success: function(result) {
      var obj = JSON.parse(result);
      var percent = (obj.processed/obj.total)*100;
      var percentage = Math.round(percent)+'%';
      $('.progress-bar').width(percentage).html(percentage);
      $('#total').html(obj.total);
      $('#processed').html(obj.processed);
      $('#duplicates-data').html(obj.duplicates);
      $('#invalids').html(obj.invalids);
      $('#suppressed-data').html(obj.suppressed);
      $('#bounced-data').html(obj.bounced);
      if(percent != 100) {
        if(obj.total != obj.processed) setTimeout(contactsImportStatus(id), 5000);
      }
    }
  });
}

function importSuppression(button, frm) {
  $("div.form-group").removeClass('has-error');
  $("div.form-group").children('span').html('');
  var route =  getAppURL()+"/suppression";
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
      //console.log(result);
      $(button).button('reset');
      toastr.success('Import successfully.');
    },
    error: function(result) {
      errors(button, result);
      return false;
    }
  });
  return true;
}

function getAppURL(){
  return window.location.protocol+'//'+window.location.hostname;
  //var re = new RegExp(/^.*\//);
  //return re.exec(window.location.href);
}

function viewModal(modal, route) {
  $.ajax({
    url: route,
    method: 'GET',
    success: function(result) {
      $('#modal-data').html(result);
      $('#'+modal).modal('show');
    }
  });
}

function resetSentCounter(id, msg='Are you sure to clear the sent counter?') {
  swal({
    title: '',
    text: msg,
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Reset counter",
    closeOnConfirm: true
  },
  function(){
    $.ajax({
      url: getAppURL()+"/sending_server/reset_counter/"+id,
      method: 'PUT',
      beforeSend: function() {
        //$('#modal-list').html("<i class='fa fa-circle-o-notch fa-spin fa-5x'></i>");
        $('#modal').modal('show');
      },
      success: function(result) {
        if(result) {
          $('#modal').modal('hide');
          toastr.success('Counter reset successfully.');
          $('#data').DataTable().ajax.reload(null, false);
        } else {
          toastr.error('Found some error(s).');
        }
      }
    });
    
  });
}

function emptyList(id, route, msg='Are you sure to empty?') {
  swal({
    title: '',
    text: msg,
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Empty List",
    closeOnConfirm: true
  },
  function(){
    $.ajax({
      url: route,
      method: 'POST',
      beforeSend: function() {
        //$('#modal-list').html("<i class='fa fa-circle-o-notch fa-spin fa-5x'></i>");
        $('#modal').modal('show');
      },
      success: function(result) {
        if(result) {
          $('#modal').modal('hide');
          toastr.success('Empty successfully.');
        } else {
          toastr.error('Found some error(s).');
        }
      }
    });
    
  });
}
function destroy(id, route, msg='Are you sure to delete?') {
  swal({
    title: '',
    text: msg,
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Delete",
    closeOnConfirm: true
  },
  function(){
    var row_id = '#'+'row_'+id;
    $(row_id).css('backgroundColor','#f7cdcd');
    $.ajax({
      url: route,
      method: 'DELETE',
      beforeSend: function() {
        $(row_id).css('backgroundColor','#f25252');
      },
      success: function(destroy) {
        if(destroy) {
          toastr.success('Deleted successfully.');
          $(row_id).fadeOut();
          $('#data').DataTable().ajax.reload(null, false);
        } else {
          toastr.error('Found some error(s).');
          $(row_id).removeCss('backgroundColor');
        }
      }
    });
    
  });
}

function destroyMany(route, msg='Are you sure to delete?') {

  if(!$('input:checkbox:checked').length){
   swal("Please select at least one checkbox.");
   return false;
  }

  var ids = $('input:checkbox:checked').map(function() {
    return this.value;
  }).get();

  swal({
    title: '',
    text: msg,
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Delete",
    closeOnConfirm: true
  },
  function(){
    $.ajax({
      url: route,
      method: 'DELETE',
      data: {action: 'many', ids: ids},
      success: function(destroy) {
        //console.log(destroy)
        if(destroy) {
          toastr.success('Deleted successfully.');
          $('input:checkbox:checked').map(function() {
            $('#'+'row_'+this.value).css('backgroundColor','#f25252');
            $('#'+'row_'+this.value).fadeOut();
            $('#data').DataTable().ajax.reload(null, false);
          }).get();
        } else {
          toastr.error('Found some error(s).');
        }
      }
    });
  });
}

function dropdownDB(id, route) {
  $.getJSON(route, function( data ) {
    var $dropdown = $("#"+id);
    $dropdown.empty();
    $.each(data, function(key,value) {
      $dropdown.append($("<option></option>").attr("value", key).text(value));
    });
  });
}

function dropdownDBMultiselect(id, route) {
  $.getJSON(route, function( data ) {
    var $dropdown = $("#"+id);
    $dropdown.multiselect('destroy');
    $dropdown.empty();
    $.each(data, function(key,value) {
      $dropdown.append($("<option></option>").attr("value", key).text(value));
    });
    $dropdown.multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      buttonWidth: '100%',
      numberDisplayed: 5
    });
  });

}

function renameRole(id) {
  $("#role-label-"+id).hide();
  $("#role-text-"+id).show();
}
function exitRole(id) {
  $("#role-text-"+id).hide();
  $("#role-label-"+id).show();
}
function saveRole(id, route){
  var role_name = $('#new_role_name_'+id).val();
  var v = $('#input-role-'+id);
  v.removeClass('has-error');
  $.ajax({
    type: "PUT",
    url: route,
    data: {id: id, name: role_name},
    success: function(result) {
      $("#role-label-"+id).html(role_name.replace(/(<([^>]+)>)/ig,""));
      $("#role-text-"+id).hide();
      $("#role-label-"+id).show();
      toastr.success('Saved successfully.');
    },
    error: function(result) {
        var errors = result.responseJSON.errors;
        for (error in errors) {
          v.addClass('has-error');
          toastr.error(errors[error]);
        }
      }
  });
}

function editGroup($this, route) {
  var span = $($this).parent().closest('tr').children('td').children('span');
  var group_id = span.attr('id');
  var group_name = span.html().replace(/(<([^>]+)>)/ig,""); // strip_tags
  var html = "<span id='group-label-"+group_id+"'>"+group_name+"</span>"+
    "<span class='input-group' style='float:none;display:none;' id='group-text-"+group_id+"'>"+
      "<span id=input-group-"+group_id+">"+
      "<input type='text' class='form-control' id='new_group_name_"+group_id+
      "' style='width:200px; display:inline-block' value='"+group_name+"' />"+
      "</span>"+
      "<div class='input-group-addon' onclick=\"saveGroup('"+group_id+"', '"+route+"')\" style='cursor:pointer;'>"+
        "<i class='fa fa-check green-check'></i>"+
      "</div>"+
      "<div class='input-group-addon' onclick=\"exitGroup('"+group_id+"')\" style='cursor:pointer;'>"+
        "<i class='fa fa-times red-times'></i>"+
      "</div>"+
    "</span>";
   span.html(html);

  $("#group-label-"+group_id).hide();
  $("#group-text-"+group_id).show();
}
function exitGroup(group_id) {
  $("#group-text-"+group_id).hide();
  $("#group-label-"+group_id).show();
}
function saveGroup(id, route){
  var group_name = $('#new_group_name_'+id).val();
  var v = $('#input-group-'+id);
  v.removeClass('has-error');
  $.ajax({
    type: "PUT",
    url: route,
    data: {id: id, name: group_name},
    success: function(result) {
      $("#group-label-"+id).html(group_name.replace(/(<([^>]+)>)/ig,""));
      $("#group-text-"+id).hide();
      $("#group-label-"+id).show();
      toastr.success('Saved successfully.');
    },
    error: function(result) {
        var errors = result.responseJSON.errors;
        for (error in errors) {
          v.addClass('has-error');
          toastr.error(errors[error]);
        }
      }
  });
}

function eraseGroup($this, route, msg='Are you sure to delete?') {
  var span = $($this).parent().closest('tr').children('td').children('span');
  var id = span.attr('id');
  swal({
    title: '',
    text: msg,
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Delete",
    closeOnConfirm: true
  },
  function(){
    $.ajax({
      method: 'DELETE',
      url: route,
      data: {id: id, action: 'erase'},
      success: function(destroy) {
        if(destroy) {
          toastr.success('Deleted successfully.');
          $('#data').DataTable().ajax.reload(null, false);
        } else {
          toastr.error('Found some error(s).');
        }
      }
    });
  });
}

function deleteGroup($this, msg='Are you sure to delete?') {
  var span = $($this).parent().closest('tr').children('td').children('span');
  var id = span.attr('id');
  var group_name = span.html().replace(/(<([^>]+)>)/ig,"");
  swal({
    title: '',
    text: msg,
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Proceed",
    closeOnConfirm: true
  },
  function(){
    $('#group-id-old').val(id);
    $('#move-id').val('');
    $('#modal-title-group').html(group_name);
    $('#modal-group-move').modal('show');
  });
}

function moveGroup(button) {
  var group_id_new = $('#groups-move').val();
  var group_id_old = $('#group-id-old').val();
  var move_id = $('#move-id').val();
  var route = $('#route').val();

  $(button).button('loading');
  $.ajax({
    method: 'DELETE',
    url: route,
    data: {id: group_id_old, group_id_new: group_id_new, move_id: move_id,  action: 'move'},
    success: function(destroy) {
      $('#modal-group-move').modal('hide');
      toastr.success('Moved successfully.');
      $('#data').DataTable().ajax.reload(null, false);
      $(button).button('reset');
    },
    error: function(result) {
      $(button).button('reset');
    }
  });
}

function move(id, name) {
  $('#move-id').val(id);
  $('#modal-title-group').html(name);
  $('#modal-group-move').modal('show');
}

var exit = function() {
  swal({
    title: $('#exit-msg').data('value'),
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: $('#btn-exit').data('value'),
    cancelButtonText: $('#btn-cancel').data('value'),
    closeOnConfirm: true
  },
  function(){
    window.history.back();
  });
}

var copy = function(id) {
  $('#'+id).select();
  document.execCommand("copy");
  toastr.success('Copied successfully.');
}

$("#checkAll").on('click', function() {
  $('input:checkbox').not(this).prop('checked', this.checked);
});

$('.select-all').on('click', function() {
  if($(this).is(':checked')) {
    $('.'+this.value).prop('checked', true);
  } else {
    $('.'+this.value).prop('checked', false);
  }
});

$("#double-optin").change(function() {
  $("#confirmation-email-data").slideToggle('slow');
});
$("#welcome-email").change(function() {
  $("#welcome-email-data").slideToggle('slow');
});
$("#unsub-email").change(function() {
  $("#unsub-email-data").slideToggle('slow');
});


$("#notification").change(function() {
  $("#notify-email").slideToggle('slow');
  $("#notify-criteria-div").slideToggle('slow');
});
$("#speed").change(function() {
  var value = $("#speed option:selected" ).text();
  if(value == 'Limited' || value == 'limited') {
    $("#speed-attributes").show('slow');
  } else {
    $("#speed-attributes").hide('slow');
  }
});

$('#clear').on('click', function() {
  $(":file").filestyle('clear');
});

$("#action-open").change(function() {
  $("#action-open").val() == 'is_opened' ? $("#div-country").show() : $("#div-country").hide();
});

function loadEmailVerifiersAttributes(type, action, id=null) {
  var route = getAppURL()+"/get_email_verifiers_fields/"+type+"/"+action+"/"+id;
  $.ajax({
    type: "GET",
    url: route,
    beforeSend: function() {
      $('#email_verifiers-attributes').show();
      $('#email_verifiers-attributes').html('<div class="form-group"><div class="col-md-offset-4 col-md-4">'+
        '<i class="fa fa-spinner fa-spin fa-2x" aria-hidden="true"></i></div>');
    },
    success: function(result) {
      $('#email_verifiers-attributes').html(result);
    }
  });
}

$("#type").change(function() {
  var type = $("#type").val();
  loadSendingServerAttributes(type, 'create');
});
function loadSendingServerAttributes(type, action, id=null) {
  var route = getAppURL()+"/get_sending_server_fields/"+type+"/"+action+"/"+id;
  $.ajax({
    type: "GET",
    url: route,
    beforeSend: function() {
      $('#sending-attributes').show();
      $('#sending-attributes').html('<div class="form-group"><div class="col-md-offset-4 col-md-4">'+
        '<i class="fa fa-spinner fa-spin fa-2x" aria-hidden="true"></i></div>');
    },
    success: function(result) {
      $('#sending-attributes').html(result);
    }
  });
}
function validateImap(button, frm) {
  $(button).button('loading');
  var frm_data = $(frm).serialize();
  var route = getAppURL()+"/validate_imap";
  $.ajax({
    url: route,
    method: 'GET',
    data: frm_data,
    beforeSend: function() {
      $("#imap-msg").html('');
    },
    success: function(result) {
      $(button).button('reset');
      $("#imap-msg").html(result);
    }
  });
}

function sendEmailTest(button, frm) {
  $("div.form-group").removeClass('has-error');
  $("div.form-group").children('span').html('');
  $(button).button('loading');
  var frm_data = $(frm).serialize();
  var route = getAppURL()+"/send_email_test";
  $.ajax({
    url: route,
    method: 'POST',
    data: frm_data,
    beforeSend: function() {
      $("#msg").html('');
    },
    success: function(result) {
      $(button).button('reset');
      $("#msg").html(result);
    },
    error: function(result) {
      errors(button, result);
      return false;
    }
  });
}
function playCampaign(id) {
  $.ajax({
    url: getAppURL()+'/update_schedule_campaign_status/'+id,
    method: 'PUT',
    data: {status: 'Paused'},
    success: function(result) {
      $('#pause-'+id).hide();
      $('#play-'+id).show();
      $('#status-'+id).html($('#paused').data('value'));
      toastr.error($('#paused-msg').data('value'));
    }
  });
  
}
function pauseCampaign(id) {
  $.ajax({
    url: getAppURL()+'/update_schedule_campaign_status/'+id,
    method: 'PUT',
    data: {status: 'Resume'},
    success: function(result) {
      $('#play-'+id).hide();
      $('#pause-'+id).show();
      $('#status-'+id).html($('#running').data('value'));
      toastr.success($('#running-msg').data('value'));
    }
  });
}
function detailStats(id, type) {
  var route = '/detail/stat/campaign/'+id+'/'+type;
  $('#tab_stat_campaign_'+type).html('<i class="fa fa-spinner fa-spin fa-4x" aria-hidden="true"></i>');
  $.get(route, function( data ) {
    $('#tab_stat_campaign_'+type).html(data);
  });
}

function detailStatsDrip(id, type) {
  var route = '/detail/stat/drip/'+id+'/'+type;
  $('#tab_stat_drip_'+type).html('<i class="fa fa-spinner fa-spin fa-4x" aria-hidden="true"></i>');
  $.get(route, function( data ) {
    $('#tab_stat_drip_'+type).html(data);
  });
}

function detailStatsAutoFollowup(id, type) {
  var route = '/detail/stat/auto_followup/'+id+'/'+type;
  $('#tab_stat_auto_followup_'+type).html('<i class="fa fa-spinner fa-spin fa-4x" aria-hidden="true"></i>');
  $.get(route, function( data ) {
    $('#tab_stat_auto_followup_'+type).html(data);
  });
}

$('#stat-export').on('click', function() {
  $('#stat-export').button('loading');
  $('#export-download').empty();
  var route = $('#stat-export').data('route');
  $.get(route, function(result) {
    var route = $('#export-download').data('route');
    $('#export-download').html('<a href="'+route+'">'+$('#export-download').data('value')+'</a>');
    $('#stat-export').button('reset');
  });
});

function goList(val) {
  location.href = getAppURL()+"/contacts?list_id="+val
}
function listExport(frm, route, msg) {
  var frm_data = $(frm).serialize();
  $.ajax({
    url: route,
    method: 'POST',
    data: frm_data,
    success: function(result) {
      toastr.success(msg);
    }
  });

  /*$.get(route, function( data ) {
    toastr.success(msg);
  });*/
}

function loadBasedOnData(type, action, id=null) {
  var route = getAppURL()+"/get_based_on_data/"+type+"/"+action+"/"+id;
  $.ajax({
    type: "GET",
    url: route,
    beforeSend: function() {
      $('#based-on-data').html('<div class="form-group"><div class="col-md-offset-4 col-md-4">'+
        '<i class="fa fa-spinner fa-spin fa-2x" aria-hidden="true"></i></div>');
    },
    success: function(result) {
      $('#based-on-data').html(result);
    }
  });
}

function loadBasedOnAction(type, action, id=null) {
  var route = getAppURL()+"/get_based_on_data/"+type+"/"+action+"/"+id;
  $.ajax({
    type: "GET",
    url: route,
    beforeSend: function() {
      $('#action-data').html('<div class="form-group"><div class="col-md-offset-4 col-md-4">'+
        '<i class="fa fa-spinner fa-spin fa-2x" aria-hidden="true"></i></div>');
    },
    success: function(result) {
      $('#action-data').html(result);
    }
  });
}

function getSetmentAttributes(action, segment_action, id=null) {
  var scheduled_ids = $('#boradcasts').val();
  if(scheduled_ids == '') var scheduled_ids = null;
  var route = getAppURL()+"/get_segment_attributes/"+action+"/"+segment_action+"/"+scheduled_ids+"/"+id;

  $.ajax({
    type: "GET",
    url: route,
    beforeSend: function() {
      $('#attributes').html('<div class="form-group"><div class="col-md-offset-4 col-md-4">'+
        '<i class="fa fa-spinner fa-spin fa-2x" aria-hidden="true"></i></div>');
    },
    success: function(result) {
      $('#attributes').html(result);
    }
  });
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

function verifyEmail(button, frm) {
  $(button).button('loading');
  var frm_data = $(frm).serialize();
  var route = getAppURL()+"/verify_email";
  $.ajax({
    url: route,
    method: 'GET',
    data: frm_data,
    beforeSend: function() {
      $("div.form-group").removeClass('has-error');
      $("div.form-group").children('span').html('');
      $(button).button('loading');
      $("#verify-msg").html('');
    },
    success: function(result) {
      $(button).button('reset');
      $("#verify-msg").html(result);
    },
    error: function(result) {
      errors(button, result);
      return false;
    }
  });
}

function loadListCustomFields(list_id, view=null, custom_field_ids=null) {
  $.ajax({
    url: getAppURL()+"/lists-custom-fields",
    method: 'GET',
    data: {list_id: list_id, view: view, custom_field_ids: custom_field_ids},
    beforeSend: function() {
      $('#list_custom_fields').html('<div class="col-md-offset-2 col-md-10"><i class="fa fa-spinner fa-spin fa-3x" aria-hidden="true"></i></div>');
    },
    success: function(result) {
      $('#list_custom_fields').html(result);
    }
  });
}
function loadListCustomFieldsWithData() {
  $.ajax({
    url: getAppURL()+"/lists-custom-fields",
    method: 'GET',
    data: {list_id: $('#list-id').val(), contact_id: $('#contact-id').val()},
    beforeSend: function() {
      $('#list_custom_fields').html('<div class="col-md-offset-2 col-md-10"><i class="fa fa-spinner fa-spin fa-3x" aria-hidden="true"></i></i></div>');
    },
    success: function(result) {
      $('#list_custom_fields').html(result);
    }
  });
}

function moveCopySegment(button, route) {
  $(button).button('loading');
  var frm_data = $('#frm-list').serialize();
  $.ajax({
    method: 'PUT',
    url: route,
    data: frm_data,
    success: function(msg) {
      toastr.success(msg);
      //console.log(msg);
      $(button).button('reset');
      $('#modal').modal('hide');
    }
  });
}
function domainVerifications(id, type) {
  var route = getAppURL()+"/domain_verfications/"+id+"/"+type;
  $.ajax({
    url: route,
    type: 'GET',
    beforeSend: function() {
      if(type=='all' || type=='dkim') {
        $('#key-'+id).html("<i class='fa fa-spinner fa-spin'></i>");
      }
      if(type=='all' || type=='spf') {
        $('#spf-'+id).html("<i class='fa fa-spinner fa-spin'></i>");
      }
      if(type=='all' || type=='dmarc') {
        $('#dmarc-'+id).html("<i class='fa fa-spinner fa-spin'></i>");
      }
      if(type=='all' || type=='tracking') {
        $('#tracking-'+id).html("<i class='fa fa-spinner fa-spin'></i>");
      }
    },
    success: function(data) {
      var obj = JSON.parse(data);
      if(type=='all' || type=='dkim') {
        $('#key-'+id).html(obj.key ? "<i class='fa fa-check green-check'></i>" : "<i class='fa fa-times red-times'></i>");
      }
      if(type=='all' || type=='spf') {
        $('#spf-'+id).html(obj.spf ? "<i class='fa fa-check green-check'></i>" : "<i class='fa fa-times red-times'></i>");
      }
      if(type=='all' || type=='dmarc') {
        $('#dmarc-'+id).html(obj.dmarc ? "<i class='fa fa-check green-check'></i>" : "<i class='fa fa-times red-times'></i>");
      }
      if(type=='all' || type=='tracking') {
        $('#tracking-'+id).html(obj.tracking ? "<i class='fa fa-check green-check'></i>" : "<i class='fa fa-times red-times'></i>");
      }
    }
  });
}
$(function () {
  'use strict';
$('#active-domain').change(function() {
    var val = $(this).prop('checked') == true ? 'Yes' : 'No';
    $.ajax({
      url: $('#sending-domain-update').data('route'),
      type: 'PUT',
      data: "field=active&value="+val,
      success: function(data) {
        toastr.success($('#msg_update').data('value'));
      }
    });
  });
  $('#protocol-domain').change(function() {
    var val = $('#protocol-domain').val();
    $.ajax({
      url: $('#sending-domain-update').data('route'),
      type: 'PUT',
      data: "field=protocol&value="+val,
      success: function(data) {
        toastr.success($('#msg_update').data('value'));
      }
    });
  });
  $('#signing-domain').change(function() {
    var val = $(this).prop('checked') == true ? 'Yes' : 'No';
    $.ajax({
      url: $('#sending-domain-update').data('route'),
      type: 'PUT',
      data: "field=signing&value="+val,
      success: function(data) {
        toastr.success($('#msg_update').data('value'));
      }
    });
  });
  $('#verify-domain').on('click', function() {
    var button = $(this);
    button.button('loading');
    $.ajax({
      url: $(this).data('route'),
      type: 'GET',
      beforeSend: function() {
        $('#key, #spf, #tracking, #dmarc').html("<i class='fa fa-spinner fa-spin'></i>");
      },
      success: function(data) {
        var obj = JSON.parse(data);
        $('#key').html(obj.key ? "<i class='fa fa-check green-check'></i>" : "<i class='fa fa-times red-times'></i>");
        $('#spf').html(obj.spf ? "<i class='fa fa-check green-check'></i>" : "<i class='fa fa-times red-times'></i>");
        $('#tracking').html(obj.tracking ? "<i class='fa fa-check green-check'></i>" : "<i class='fa fa-times red-times'></i>");
        $('#dmarc').html(obj.dmarc ? "<i class='fa fa-check green-check'></i>" : "<i class='fa fa-times red-times'></i>");
        button.button('reset');
      }
    });
  });
});
$('#copy-api-token').on('click', function() {
  document.getElementById("api-key").select();
  document.execCommand("copy");
  toastr.success('Copied successfully!');
});

$('#copy-api-url').on('click', function() {
  document.getElementById("api-base-url").select();
  document.execCommand("copy");
  toastr.success('Copied successfully!');
});

$('#active-api').change(function() {
  var val = $(this).prop('checked') == true ? 'Enabled' : 'Disabled';
  $.ajax({
    url: $(this).data('route'),
    type: 'PUT',
    data: "value="+val,
    success: function(data) {
      toastr.success('Updated successfully.');
    }
  });
});

$(function(){
$('#btn-verify-license').on('click', function() {
  $('#btn-verify-license').button('loading');
  $('#msg').html();
  $.ajax({
    url: $(this).data('route'),
    method: 'POST',
    data: {license_key: $('#license_key').val()},
    success: function(result) {
      if(result.verify) {
        document.location.href = getAppURL()+'/dashboard';
      } else {
        $('#msg').html(result.message);
      }
      $('#btn-verify-license').button('reset');
    }
  });
});
});
function systemVariables(key) {
  $('#shortcode').val(key);
  toastr.success('Copied successfully!');
}
function customFields(key) {
  $('#shortcode').val(key);
  toastr.success('Copied successfully!');
}
function spinTags(key) {
  $('#shortcode').val(key);
  toastr.success('Copied successfully!');
}
function insertCKEDITOR(id) {
  swal({
    title: $('#insert-template-msg').data('value'),
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes",
    closeOnConfirm: true
  }, function (isConfirm) {
    if(isConfirm) {
      CKEDITOR.instances['content_html'].setData('');
      $.get(getAppURL()+"/template/html/"+id, function(content_html) {
        content_html = content_html.replace("MailCarry - Email Template", "");
        CKEDITOR.instances['content_html'].insertHtml(content_html);
        $('#modal').modal('hide');
      });
    }
  });
}
function reschedule(id, msg) {
  swal({
    title: '',
    text: msg,
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Reschedule",
    closeOnConfirm: true
  },
  function(){
    location.href = getAppURL()+"/reschedule/"+id;
  });
}
function runLimitedToUnlimited(id, msg){
  swal({
    title: 'This action will never rollback!',
    text: msg,
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Run as Unlimited",
    closeOnConfirm: true
  },
  function(){
    $.ajax({
      url: getAppURL()+"/limited_to_unlimited",
      method: 'PUT',
      data: {id: id},
      success: function(result) {
        toastr.success('Set successfully.');
      }
    });
  });
}

