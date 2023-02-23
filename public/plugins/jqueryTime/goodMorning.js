$.fn.goodMorning = function(input){
	var settings = $.extend({
		morning: 7,
		noon: 12,
		evening:18,
		night:22,
		icon: true,
		monday: true,
		tgif: true
	}, input);


	var sun = {};
	
	//retrieve time and day. Format for display.
	sun.time = function(){
		var date = new Date();
		sun.hh = date.getHours()
		sun.min = date.getMinutes();
		sun.week = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
		sun.day = sun.week[date.getDay()];
		var ampm = (sun.hh >= 12) ? "pm" : "am";
		sun.h = ((sun.hh + 11) % 12 + 1);
		sun.min = sun.min < 10 ? "0" + sun.min : sun.min;
		var time = sun.h + ":" + sun.min + " " + ampm;
		sun.good();
	}
	setInterval(sun.time
		, 1000);

	//use day and time info to display messages and icons.
	sun.good = function(input){
		if (sun.hh >= settings.morning && sun.hh < settings.noon) {
			var goodMorning = $('<p>').text('Good Morning');	
			$('.greeting-info').html(goodMorning)
		} else if(sun.hh >= settings.noon && sun.hh < settings.evening){
			var goodAfternoon = $('<p>').text('Good Afternoon');
			$('.greeting-info').html(goodAfternoon);
		} else if(sun.hh >= settings.evening && sun.hh < settings.night){
			var goodEvening = $('<p>').text('Good Evening');
			$('.greeting-info').html(goodEvening);
		} else if(sun.hh >= settings.night && sun.hh <= 23 || sun.hh < settings.morning){
			var goodNight = $('<p>').text('Good Night');
			$('.greeting-info').html(goodNight);
		}
	}

}