$(function () {
  $('#campaigns').multiselect({
    enableFiltering: true,
    buttonWidth: '100%',
  });
  $('#lists, #sending_servers').multiselect({
    includeSelectAllOption: true,
    enableFiltering: true,
    buttonWidth: '100%',
    numberDisplayed: 5,
    nonSelectedText: $('#none-selected').data('value')
  });
  $("#send").change(function() {
    $("#send-datetime").slideToggle('slow');
  });
  $('.timepicker').timepicker({
    showInputs: false
  });
  var date = new Date();
  date.setDate(date.getDate());
  $('.datepicker').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy',
    startDate: date
  });
});