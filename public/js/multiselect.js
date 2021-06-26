$(function () {
  'use strict';
  $('[data-toggle="tooltip"]').tooltip();
  $('#lists').multiselect({
    includeSelectAllOption: true,
    enableFiltering: false,
    enableCaseInsensitiveFiltering: true,
    buttonWidth: '100%',
    numberDisplayed: 7,
    nonSelectedText: $('#none_selected').data('value')
  });
  $('#options').multiselect({
    includeSelectAllOption: false,
    enableFiltering: false,
    enableCaseInsensitiveFiltering: true,
    buttonWidth: '100%',
    numberDisplayed: 7,
    nonSelectedText: $('#none_selected').data('value')
  });
  $('#custom-fields').multiselect({
    includeSelectAllOption: true,
    enableFiltering: true,
    enableCaseInsensitiveFiltering: true,
    buttonWidth: '100%',
    numberDisplayed: 7,
    nonSelectedText: $('#none_selected').data('value')
  });
  $('#broadcasts').multiselect({
    includeSelectAllOption: true,
    enableFiltering: true,
    enableCaseInsensitiveFiltering: true,
    buttonWidth: '100%',
    numberDisplayed: 7,
    nonSelectedText: $('#none_selected').data('value')
  });
  $('#notify-criteria').multiselect({
    includeSelectAllOption: true,
    buttonWidth: '100%',
    numberDisplayed: 7,
    nonSelectedText: $('#none_selected').data('value')
  });
  $('#sending-servers').multiselect({
    includeSelectAllOption: true,
    enableFiltering: true,
    enableCaseInsensitiveFiltering: true,
    buttonWidth: '100%',
    numberDisplayed: 7,
    nonSelectedText: $('#none_selected').data('value')
  });
  $('.multi').multiselect({
    includeSelectAllOption: true,
    enableFiltering: true,
    enableCaseInsensitiveFiltering: true,
    buttonWidth: '100%',
    numberDisplayed: 10,
    nonSelectedText: $('#none_selected').data('value')
  });
});