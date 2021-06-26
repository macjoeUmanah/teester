$(function(){

  // Cache some selectors

  var clock = $('#clock'),
    alarm = clock.find('.alarm'),
    ampm = clock.find('.ampm');

  // Map digits to their names (this will be an array)
  var digit_to_name = 'zero one two three four five six seven eight nine'.split(' ');

  // This object will hold the digit elements
  var digits = {};

  // Positions for the hours, minutes, and seconds
  var positions = [
    'h1', 'h2', ':', 'm1', 'm2', ':', 's1', 's2'
  ];

  // Generate the digits with the needed markup,
  // and add them to the clock

  var digit_holder = clock.find('.digits');

  $.each(positions, function(){

    if(this == ':'){
      digit_holder.append('<div class="dots">');
    }
    else{

      var pos = $('<div>');

      for(var i=1; i<8; i++){
        pos.append('<span class="d' + i + '">');
      }

      // Set the digits as key:value pairs in the digits object
      digits[this] = pos;

      // Add the digit elements to the page
      digit_holder.append(pos);
    }

  });

  // Add the weekday names
  var weekday_names = 'MON TUE WED THU FRI SAT SUN'.split(' '),
    weekday_holder = clock.find('.weekdays');

  $.each(weekday_names, function(){
    weekday_holder.append('<span>' + this + '</span>');
  });

  var weekdays = clock.find('.weekdays span');

  // Run a timer every second and update the clock
  (function updateTime(){

    var time_zone = $('#time_zone').html();
    var now = moment(now).tz(time_zone).format("ddd MMM DD, YYYY hh:mm:ss A");

    digits.h1.attr('class', digit_to_name[now[0]]);
    digits.h2.attr('class', digit_to_name[now[1]]);
    digits.m1.attr('class', digit_to_name[now[2]]);
    digits.m2.attr('class', digit_to_name[now[3]]);
    digits.s1.attr('class', digit_to_name[now[4]]);
    digits.s2.attr('class', digit_to_name[now[5]]);

    // The library returns Sunday as the first day of the week.
    // Lets shift all the days one position down, and make Sunday last

    var dow = now[6];
    $("#clock").html(now);
    dow--;
    
    // Sunday!
    if(dow < 0){
      // Make it last
      dow = 6;
    }

    // Mark the active day of the week
    weekdays.removeClass('active').eq(dow).addClass('active');

    // Set the am/pm text:
    ampm.text(now[7]+now[8]);

    // Schedule this function to be run again in 1 sec
    setTimeout(updateTime, 1000);

  })();
}); 