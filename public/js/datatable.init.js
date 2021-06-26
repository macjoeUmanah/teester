$.extend( $.fn.dataTable.defaults, {
  "processing" : true,
  "serverSide" : true,
  "searching"  : true,
  //"sScrollX"   : '100%',
  //"responsive": true,
  "pagingType" : "full_numbers",
  "language": {
    "search": "",
    "lengthMenu"    : "_MENU_",
    "loadingRecords": $('#dt_loadingRecords').data('value'),
    "processing"    : $('#dt_processing').data('value'),
    "zeroRecords"   : $('#dt_zeroRecords').data('value'),
    "info"          : $('#dt_info').data('value'),
    "infoEmpty"     : $('#dt_infoEmpty').data('value'),
    "infoFiltered"  : $('#dt_infoFiltered').data('value'),
    "paginate" : {
      "previous": $('#dt_previous').data('value'),
      "next"    : $('#dt_next').data('value'),
      "first"   : $('#dt_first').data('value'),
      "last"    : $('#dt_last').data('value'),
    }
  },
  initComplete : function() {
    var input = $('.dataTables_filter input').unbind(),
      self = this.api(),
      $searchButton = $('<button class="form-control input-sm">')
        .text($('#dt_btn_search').data('value'))
        .click(function() {
          self.search(input.val()).draw();
      });
      $showAllButton = $('<button class="form-control input-sm">')
        .text($('#dt_btn_show_all').data('value'))
        .click(function() {
        self.search('').draw();
      });
      $('.dataTables_filter').append($searchButton);
      $('.dataTables_filter').append($showAllButton);
  }
});

// For responsive
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
  $.extend( $.fn.dataTable.defaults, {
    "sScrollX"   : '100%',
  });
}