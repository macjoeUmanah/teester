$(function () {
  'use strict';

  $('.daterange-domain').daterangepicker({
    maxDate: new Date,
    ranges   : {
      'Today'       : [moment(), moment()],
      'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month'  : [moment().startOf('month'), moment().endOf('month')],
      'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
      'This Year'   : [moment().startOf('year'), moment().endOf('year')],
      'Last Year'   : [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
    },
    startDate: moment().subtract(6, 'days'),
    endDate  : moment()
  }, function (start, end) {
    domiansChart(start, end);
  });

  $('.daterange-country').daterangepicker({
    maxDate: new Date,
    ranges   : {
      'Today'       : [moment(), moment()],
      'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month'  : [moment().startOf('month'), moment().endOf('month')],
      'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
      'This Year'   : [moment().startOf('year'), moment().endOf('year')],
      'Last Year'   : [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
    },
    startDate: moment().subtract(6, 'days'),
    endDate  : moment()
  }, function (start, end) {
    countryChart(start, end);
  });

  $('.daterange-campaigns').daterangepicker({
    maxDate: new Date,
    ranges   : {
      'Today'       : [moment(), moment()],
      'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month'  : [moment().startOf('month'), moment().endOf('month')],
      'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
      'This Year'   : [moment().startOf('year'), moment().endOf('year')],
      'Last Year'   : [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
    },
    startDate: moment().subtract(6, 'days'),
    endDate  : moment()
  }, function (start, end) {
    campaignsChart(start, end);
  });

  $('#data-campaigns').DataTable({
    "columnDefs": [{"sortable": false, "targets": [6,7,9]}],
    "order": [[6, "DESC"]],
    "lengthMenu": [[3], [3]],
    "lengthChange" : false,
    "searching": false,
    "ajax": {
      "url" : $('#data-campaigns-route').data('value')
    },
  });

  $('#data-triggers').DataTable({
    "columnDefs": [{"sortable": false, "targets": [3,5]}],
    "order": [[4, "DESC"]],
    "lengthMenu": [[3], [3]],
    "lengthChange" : false,
    "searching": false,
    "ajax": {
      "url" : $('#data-triggers-route').data('value')
    },
  });


  $('#data-clients').DataTable({
    "columnDefs": [{"sortable": false, "targets": [0, 7]}],
    "order": [[ 1, "asc" ], [ 6, "desc" ]],
    "lengthMenu": [[3], [3]],
    "lengthChange" : false,
    "searching": false,
    "ajax": $('#data-clients-route').data('value'),
    "drawCallback": function ( settings ) {
      var api = this.api();
      var rows = api.rows( {page:'current'} ).nodes();
      var last=null;
      var groupColumn=1;
      api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
        if ( last !== group ) {
          $(rows).eq( i ).before(
            '<tr class="dt_group"><td colspan="8">'+group+'</td></tr>'
          );
          last = group;
        }
      });
    },
  });

});

function domiansChart(start, end) {
  var start_datetime = start.format('YYYY-MM-DD 00:00:00');
  var end_datetime = end.format('YYYY-MM-DD 23:59:59');
  $.ajax({
    url: $('#domain').data('route'),
    data: {start_datetime: start_datetime, end_datetime: end_datetime},
    beforeSend: function( xhr ) {  
      $('#div-chart-domain').html('<i class="fa fa-spinner fa-spin fa-4x" aria-hidden="true"></i>');
      $('#domain-range').html('( ' +start.format('YYYY-MM-DD')+ ' - '+end.format('YYYY-MM-DD')+' )');
    }
  })
  .done(function( data ) {
    $('#div-chart-domain').html('<canvas id="canvas-chart-domain" style="height: 250px;"></canvas>');
    var canvas_chart_sent = $('#canvas-chart-domain').get(0).getContext('2d');
    var chart       = new Chart(canvas_chart_sent);
    var data        =  JSON.parse(data);
    var options     = {
      legend: {
        position: 'right',
        labels: {
          boxWidth: 20
        }
      },
    };

    if(data.labels.length) {
      var myPieChart = new Chart(chart, {
          type: 'pie',
          data: data,
          options: options
      });
    } else {
      $('#div-chart-domain').html($('#no-found').data('value'));
    }
  });
}

function countryChart(start, end) {
  var start_datetime = start.format('YYYY-MM-DD 00:00:00');
  var end_datetime = end.format('YYYY-MM-DD 23:59:59');
  $.ajax({
    url: $('#country').data('route'),
    data: {start_datetime: start_datetime, end_datetime: end_datetime},
    beforeSend: function( xhr ) {  
      $('#world-map').html('<i class="fa fa-spinner fa-spin fa-4x" aria-hidden="true"></i>');
      $('#country-range').html('( ' +start.format('YYYY-MM-DD')+ ' - '+end.format('YYYY-MM-DD')+' )');
    }
  })
  .done(function( data ) {
    var data = JSON.parse(data);
    // World map by jvectormap
    $('#world-map').html('');
    $('#world-map').vectorMap({
      map              : 'world_mill_en',
      backgroundColor  : 'transparent',
      regionStyle      : {
        initial: {
          fill            : '#e4e4e4',
          'fill-opacity'  : 1,
          stroke          : 'none',
          'stroke-width'  : 0,
          'stroke-opacity': 1
        },
        hover: {
          stroke: '#3D5A6B',
          "stroke-width": 2,
          cursor: 'pointer'
        }
      },
      series           : {
        regions: [
          {
            values           : data,
            scale            : ['#deeef7', '#096da5'],
            normalizeFunction: 'polynomial'
          }
        ]
      },
      onRegionTipShow: function(e, el, code){
        if (typeof data[code] != 'undefined')
          el.html(el.html() +" ("+ $('#opens').data('value') +": "+data[code]+')');
      }
    });
  });
}

function campaignsChart(start, end) {
  var start_datetime = start.format('YYYY-MM-DD 00:00:00');
  var end_datetime = end.format('YYYY-MM-DD 23:59:59');
  $.ajax({
    url: $('#campaign').data('route'),
    data: {start_datetime: start_datetime, end_datetime: end_datetime},
    beforeSend: function( xhr ) {  
      $('#div-chart-campaigns').html('<i class="fa fa-spinner fa-spin fa-4x" aria-hidden="true"></i>');
      $('#campaigns-range').html('( ' +start.format('YYYY-MM-DD')+ ' - '+end.format('YYYY-MM-DD')+' )');
    }
  })
  .done(function( data ) {
    $('#div-chart-campaigns').html('<canvas id="canvas-chart-campaigns" style="height: 250px;"></canvas>');
    var canvas_chart_sent = $('#canvas-chart-campaigns').get(0).getContext('2d');
    var chart       = new Chart(canvas_chart_sent);
    var data        =  JSON.parse(data);
    var options = {
      responsive: true,
      tooltips: {
        mode: 'index',
        intersect: false,
      },
      hover: {
        mode: 'nearest',
        intersect: true
      },
      legend: {
        labels: {
          boxWidth: 20
        }
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            userCallback: function(label, index, labels) {
               // when the floored value is the same as the value we have a whole number
               if (Math.floor(label) === label) {
                   return label;
               }
           },
          }
        }]
      },
    };

    if(data.labels.length) {
      var mylineChart = new Chart(chart, {
          type: 'line',
          data: data,
          options: options
      });
    } else {
      $('#div-chart-').html($('#campaign').data('value'));
    }
  });
}