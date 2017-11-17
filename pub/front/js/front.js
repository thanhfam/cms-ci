$(document).ready(function() {

	$('#carousel-top').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		adaptiveHeight: true,
		autoplay: true,
		autoplaySpeed: 8000,
		fade: true,
		cssEase: 'linear'
	});

	$('#carousel-hospital').slick({
		infinite: true,
		slidesToShow: 4,
		slidesToScroll: 4,
		adaptiveHeight: true,
		responsive: [{
			breakpoint: 768,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 2
			}
		}, {
			breakpoint: 576,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}]
	});

	$('#carousel-partner').slick({
		infinite: true,
		slidesToShow: 6,
		slidesToScroll: 1,
		adaptiveHeight: true,
		autoplay: true,
		autoplaySpeed: 2000,
		arrows: false,
		responsive: [{
			breakpoint: 992,
			settings: {
				slidesToShow: 4
			}
		}, {
			breakpoint: 576,
			settings: {
				slidesToShow: 2
			}
		}]
	});
});
