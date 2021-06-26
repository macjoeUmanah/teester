$(function() {
  $('[data-toggle="tooltip"]').tooltip();
  $('.nav-tabs > li a[title]').tooltip();
  //Wizard
  $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
    var $target = $(e.target);
    if ($target.parent().hasClass('disabled')) {
      return false;
    }
  });

  $(".next-step").click(function (e) {
    var tab = e.target.id;
    $(".form-group").removeClass("has-error");
    var invalid = false;

    if(tab == 'server-settings' || tab == 'pmta-settings' || tab == 'ips-domains') {
      if(tab == 'server-settings') {
        var curInputs = $("#step1 :input").each(function(){
          $(this).find(':input')
        });
      } else if(tab == 'pmta-settings') {
        var curInputs = $("#step2 :input").each(function(){
          $(this).find(':input')
        });
      } else if(tab == 'ips-domains') {
        var curInputs = $("#step3 :input").each(function(){
          $(this).find(':input')
        });
      }
      
      for (var i = 0; i < curInputs.length; i++) {
        if (!curInputs[i].checkValidity()) {
          $(curInputs[i]).closest(".form-group").addClass("has-error");
          invalid = true;
        }
      }
    }

    if(!invalid) {
      var $active = $('.wizard .nav-tabs li.active');
      $active.next().removeClass('disabled');
      nextTab($active);
    }
  });
  $(".prev-step").click(function (e) {
    var $active = $('.wizard .nav-tabs li.active');
    prevTab($active);
  });

  function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
  }
  function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
  }

  $('#validate').click(function() {
    $.ajax({
      url: '/pmta_steps/0',
      method: 'POST',
      data: {ip:$('#server-ip').val(), port: $('#server-port').val(), username: $('#server-username').val(), password: $('#server-password').val()},
      beforeSend: function() {
        $('#validate').button('loading');
        $('#server-msg').empty();
      },
      success: function(data) {
        $('#server-msg').html(data);
        $('#validate').button('reset');
        if(data.indexOf('success') !== -1) {
          $('#btn-next-server').show();
        } else {
          $('#btn-next-server').hide();
        }
      }
    });
  });
});

function deletePmta(id, msg='Are you sure to delete?')
{
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
      url: '/pmta_steps/15',
      method: 'POST',
      beforeSend: function() {
        $('#action').html('<i class="fa fa-spinner fa-spin fa-2x" aria-hidden="true"></i>');
      },
      success: function(result) {
        document.location.href = '/pmta';
      }
    });
  });
}

function downloadPmtaSettings(pmta) 
{
  $.ajax({
      url: '/pmta_steps/16',
      method: 'POST',
      beforeSend: function() {
        $('#action').html('<i class="fa fa-spinner fa-spin fa-2x" aria-hidden="true"></i>');
      },
      success: function(data) {
        console.log(data.msg);
        if(data.msg == 'success') {
          $('#action').html('<a href="'+data.file+'"><button type="button" class="btn btn-success">Download</button></a>');
        }
      }
    });
}

function pmtaSteps(step, div_id)
{
  $.ajax({
    url: '/pmta_steps/'+step,
    method: 'POST',
    data: $('#frm-pmta').serialize(),
    beforeSend: function() {
      if(step != 6) {
        $('#'+div_id).html('<i class="fa fa-spinner fa-spin fa-3x" aria-hidden="true"></i>');
      }
      if(step == 7) {
        $('#previous-finish').hide();
      }
    },
    success: function(data) {
      if(step == 7) {
        if(data == 'success') {
          document.location.href = '/pmta';
        } else {
          $('#previous-finish').show();
        }
      } else {
        $('#'+div_id).html(data);
      }
    }
  });
}

function validateBounce(div) {
var inputs = $('input[name="'+div+'[]"]')
  .map(function(){return $(this).val();}).get();
  var selects = $('select[name="'+div+'[]"]')
  .map(function(){return $(this).val();}).get();
  $.ajax({
    url: '/pmta_steps/10',
    method: 'POST',
    data: {inputs:inputs, selects:selects},
    beforeSend: function() {
      $('#msg-'+div).html('<i class=\"fa fa-spinner fa-spin\" aria-hidden=\"true\"></i>');
    },
    success: function(data) {
      $('#msg-'+div).html(data);
    }
  });
}