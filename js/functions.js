jQuery(document).ready(function($) {

	$('#searchform').on('submit', function(){
		if ($(this).find('#s').val() === ""){
			alert('You did not enter any keywords.');
			return false;
		}
	});


	var $featured = $('#featured');

	$featured.carouFredSel({
		responsive: true,
		circular: false,
		auto: {
			play: true,
			timeoutDuration : 6000
		},
		scroll: {
			pauseOnHover: true
		},
		items: 1,
		pagination  : "#featured-navi"
	});

	if ($('body').hasClass('home')) {
		var queryUrl = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20WHERE%20symbol%3D'WRB'&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys";
		$.getJSON(queryUrl, function(data) {
			
			if (data.query.results !== null) {
				// console.log(data.query.results.quote);
				// 16 Jul 2013 09:48 PM
				var date = new Date();
					date = new Date(data.query.results.quote.LastTradeDate);
					dataStr = date.toDateString();
					dataStr = dataStr.split(' ');
					
				$('#LastTradeDate').html(dataStr[2] + ' ' + dataStr[1] + ' ' + dataStr[3] + ' ' + data.query.results.quote.LastTradeTime);
				$('#PrevClose').html(data.query.results.quote.LastTradePriceOnly);
				$('#DaysRange').html(data.query.results.quote.Change_PercentChange);
				if (data.query.results.quote.Change_PercentChange.indexOf('+') >= 0) {
					$('#StockRange').addClass('up');
				}
				
			}

		});
	}
	
	$('.mobile-menu').on('click', function () {
		if (!$(this).hasClass('selected')) {
			$(this).addClass('selected');
			$('#menu-main-navigation').slideDown();
		} else {
			$(this).removeClass('selected');
			$('#menu-main-navigation').slideUp();
		}

		return false;
	});

	$uniformed = $(".wpcf7").find("input, textarea, select, button").not('input[type=submit], input[type=reset]');
	$uniformed.uniform();
	
	var $wrap = $('.wrap');
	$(window).on('resize', function() {
		//console.log( $('#menu-main-navi').css('display') );
		if ($wrap.width() == 940  && $('#menu-main-navi').css('display') == 'none') {
			$('#menu-main-navi').css('display','');
			$('.mobile-menu').removeClass('selected');
		}
	});
	
});