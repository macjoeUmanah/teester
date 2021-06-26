$('#btn-install').click(function () {

    $('#btn-install').button('loading');
    $(".form-group").removeClass("has-error");
    var curInputs = $(":input").each(function(){
        $(this).find(':input')
    });

    var invalid = false;
    for (var i = 0; i < curInputs.length; i++) {
      if (!curInputs[i].checkValidity()) {
        $(curInputs[i]).closest(".form-group").addClass("has-error");
        invalid = true;
      }
    }

    if(!invalid) {
      var server_ip = $('#server_ip').val(),
        app_url = $('#app_url').val(),
        email = $('#email').val();
      $.ajax({
        url: 'https://mailcarry.com/verify.php',
        method: 'GET',
        data: {is_verify: true, install_from: 'INSTALL-MAILCARRY-1'},
        beforeSend: function() {
          $('#msg').html('');
        },
        success: function(response) {
          if(response.verify) {
            $.ajax({
              url: $('#app_url').val()+'/installation',
              method: 'POST',
              data: $('#frm-install').serialize(),
              success: function(result) {
                console.log(result);
                if(result.ok) {
                  $('#cronjob').html(result.message);
                  $('#step1').hide();
                  $("#login").attr("href", $('#app_url').val());
                  $('#step2').show();
                } else {
                  $('#msg').html(result.message);
                }
                $('#btn-install').button('reset');
              },
              error: function (result) {
                $('#cronjob').html(result);
                $('#btn-install').button('reset');
              }
            });
          } else {
            $('#msg').html(response.message);
            $('#btn-install').button('reset');
          }
        }
      });
    } else {
      $('#btn-install').button('reset');
    }
  });