function loadContactAction($this) {
  var contact_filter_action = $this.name.replace('name', 'action');
  var contact_filter_value = $this.name.replace('name', 'value');
  var select_action =  $("[name='"+contact_filter_action+"']");
  var select_value =  $("[name='"+contact_filter_value+"']");

  if($this.value == '') {
    select_action.replaceWith(
      "<select class='form-control' name='"+contact_filter_action+"'></select>"
    );
    select_value.replaceWith(
      "<select class='form-control' name='"+contact_filter_value+"'></select>"
    );
  } else if($this.value == 'email') {
    select_action.replaceWith(
      "<select class='form-control' name='"+contact_filter_action+"'>"+
      "<option value='is'>is</option>"+
      "<option value='is_not'>is not</option>"+
      "<option value='contain'>contain</option>"+
      "<option value='not_contain'>doesn\'t</option>"+
      "</select>"
    );
    select_value.replaceWith(
      "<input type='text' class='form-control' placeholder='Use comma for multiples' name='"+contact_filter_value+"' >"
    );
  } else {
    select_action.replaceWith(
      "<select class='form-control' name='"+contact_filter_action+"'>"+
      "<option value='is'>is</option>"+
      "<option value='is_not'>is not</option>"+
      "</select>"
    );

    if($this.value == 'status') {
      select_value.replaceWith(
        "<select class='form-control' name='"+contact_filter_value+"'>"+
        "<option value='active'>Active</option>"+
        "<option value='inactive'>Inactive</option>"+
        "</select>"
      );
    } else if($this.value == 'format') {
      select_value.replaceWith(
        "<select class='form-control' name='"+contact_filter_value+"'>"+
        "<option value='html'>HTML</option>"+
        "<option value='text'>Text</option>"+
        "</select>"
      );
    } else if($this.value == 'source') {
      select_value.replaceWith(
        "<select class='form-control' name='"+contact_filter_value+"'>"+
        "<option value='app'>App</option>"+
        "<option value='form'>Web Form</option>"+
        "<option value='api'>API</option>"+
        "<option value='import'>Import</option>"+
        "</select>"
      );
    }
  }
}

function loadDate($this) {
  var date_filter_value = $this.name.replace('action', 'value');
  var date_value =  $("[name='"+date_filter_value+"']");
  date_value.datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy'
  });
}

function segmentExport(route) {
  $.ajax({
    method: 'PUT',
    data: {action: 'Export'},
    url: route,
    success: function(msg) {
      toastr.success(msg);
      $('#data').DataTable().ajax.reload(null, false);
    }
  });
}

function segmentStop(route) {
  $.ajax({
    method: 'PUT',
    url: route,
    success: function(msg) {
      $('#data').DataTable().ajax.reload(null, false);
    }
  });
}