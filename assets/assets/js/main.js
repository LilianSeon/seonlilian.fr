
function detectmob() { // Mobil détection
	if( navigator.userAgent.match(/Android/i)
	|| navigator.userAgent.match(/webOS/i)
	|| navigator.userAgent.match(/iPhone/i)
	|| navigator.userAgent.match(/iPad/i)
	|| navigator.userAgent.match(/iPod/i)
	|| navigator.userAgent.match(/BlackBerry/i)
	|| navigator.userAgent.match(/Windows Phone/i)
	){
	   return true;
	 }
	else {
	   return false;
	 }
   }

/* Auto type */

window.addEventListener("scroll", function(){
	if (!detectmob()) {
		 pmin = 78;
		 pmax = 81;
	}else{
		 pmin = 70;
		 pmax = 74;
	}
	
	if(getScrollPercent() < pmax && getScrollPercent() > pmin){

		var contact = document.getElementById('contactTitle');
		var type_contact = "Contactez moi";
		var index = 0;

		window.type_title = function() {
			if(contact.textContent != "Contactez moi"){
				if (index <= type_contact.length) {
					contact.innerHTML = type_contact.substr(0, index++)+"|";
					if(contact.textContent == "Contactez moi|"){
						contact.innerHTML = "Contactez moi";
					}
					setTimeout("type_title()", 450);
				}
			}
		}
		type_title();
	}

		if (getScrollPercent() >= 20) {
			
			this.document.getElementById('toTop').style.opacity = "1";
			
		}else if(getScrollPercent() < 20){
			this.document.getElementById('toTop').style.opacity = "0";
		}
}); // Fin Listener scroll



function getScrollPercent() { // Scroll %
	var h = document.documentElement, 
		b = document.body,
		st = 'scrollTop',
		sh = 'scrollHeight';
	return (h[st]||b[st]) / ((h[sh]||b[sh]) - h.clientHeight) * 100;
}

window.onscroll = function() {scrollIndicator()};

function scrollIndicator() {
  var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
  var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  var scrolled = (winScroll / height) * 100;
  document.getElementById("myBar").style.width = scrolled + "%";
}

(function($) {

	var settings = {

		// Full screen header?
			fullScreenHeader: true,

		// Parallax background effect?
			parallax: true,

		// Parallax factor (lower = more intense, higher = less intense).
			parallaxFactor: 10

	};

	skel.breakpoints({
		wide: '(max-width: 1680px)',
		normal: '(max-width: 1080px)',
		narrow: '(max-width: 840px)',
		mobile: '(max-width: 736px)'
	});

	$(function() {

		var	$window = $(window),
			$body = $('body');

		if (skel.vars.touch) {

			settings.parallax = false;
			$body.addClass('is-scroll');

		}

		// Disable animations/transitions until the page has loaded.
			$body.addClass('is-loading');

			$window.on('load', function() {
				$body.removeClass('is-loading');
			});

		// CSS polyfills (IE<9).
			if (skel.vars.IEVersion < 9)
				$(':last-child').addClass('last-child');

		// Fix: Placeholder polyfill.
			$('form').placeholder();

		// Prioritize "important" elements on mobile.
			skel.on('+mobile -mobile', function() {
				$.prioritize(
					'.important\\28 mobile\\29',
					skel.breakpoint('mobile').active
				);
			});

		// Scrolly links.
			$('.scrolly-middle').scrolly({
				speed: 1000,
				anchor: 'middle'
			});

			$('.scrolly').scrolly({
				speed: 1000,
				offset: function() { return (skel.breakpoint('mobile').active ? 70 : 190); }
			});

		// Full screen header.
			if (settings.fullScreenHeader) {

				var $header = $('#header');

				if ($header.length > 0) {

					var $header_header = $header.find('header');

					$window
						.on('resize.overflow_fsh', function() {

							if (skel.breakpoint('mobile').active)
								$header.css('padding', '');
							else {

								var p = Math.max(192, ($window.height() - $header_header.outerHeight()) / 2);
								$header.css('padding', p + 'px 0 ' + p + 'px 0');

							}

						})
						.trigger('resize.overflow_fsh');

					$window.load(function() {
						$window.trigger('resize.overflow_fsh');
					});

				}

			}

		// Parallax background.

			// Disable parallax on IE (smooth scrolling is jerky), and on mobile platforms (= better performance).
				if (skel.vars.browser == 'ie'
				||	skel.vars.mobile)
					settings.parallax = false;

			if (settings.parallax) {

				var $dummy = $(), $bg;

				$window
					.on('scroll.overflow_parallax', function() {

						// Adjust background position.
							$bg.css('background-position', 'center ' + (-1 * (parseInt($window.scrollTop()) / settings.parallaxFactor)) + 'px');

					})
					.on('resize.overflow_parallax', function() {

						// If we're in a situation where we need to temporarily disable parallax, do so.
							if (!skel.breakpoint('wide').active
							||	skel.breakpoint('narrow').active) {

								$body.css('background-position', '');
								$bg = $dummy;

							}

						// Otherwise, continue as normal.
							else
								$bg = $body;

						// Trigger scroll handler.
							$window.triggerHandler('scroll.overflow_parallax');

					})
					.trigger('resize.overflow_parallax');

			}

		// Poptrox.
			$('.gallery').poptrox({
				useBodyOverflow: false,
				usePopupEasyClose: false,
				overlayColor: '#0a1919',
				overlayOpacity: (skel.vars.IEVersion < 9 ? 0 : 0.75),
				usePopupDefaultStyling: false,
				usePopupCaption: true,
				popupLoaderText: '',
				windowMargin: 10,
				usePopupNav: true
			});

	});

})(jQuery);
