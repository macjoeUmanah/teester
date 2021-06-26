$(function () {
  'use strict';
  $('[data-toggle="tooltip"]').tooltip();
    // Custom Fields
  $("#type").change(function () {
    var type = $('#type').val();
    (type == 'radio' || type == 'checkbox' || type == 'dropdown') ? $('#values').show() : $('#values').hide();
  });

  // Email Verifier
  $("#type-email-verifier").change(function() {
    var type = $("#type-email-verifier").val();
    loadEmailVerifiersAttributes(type, 'create');
  });
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
  $('#clear').on('click', function() {
    $(":file").filestyle('clear');
  });

  $("#based-on").change(function() {
    $("#based-list").slideToggle('slow');
  });

  $("#lists").change(function () {
    var list_id = $('#lists').val();
    if(list_id == '') {
      $('#list_custom_fields').html('');
      return;
    }
    loadListCustomFields(list_id);
  });
  $("#segment-action,#boradcasts").change(function() {
    getSetmentAttributes('create', $("#segment-action").val());
  });
  $("#send").change(function() {
    $("#send-datetime").slideToggle('slow');
  });
  $("#based-on-trigger").change(function() {
    loadBasedOnData($("#based-on-trigger").val(), 'create');
  });

  $("#thankyou_page_option").change(function () {
    $('.thankyou_page_option').toggle('slow');
  });
  $("#confirmation_page_option").change(function () {
    $('.confirmation_page_option').toggle('slow');
  });
});