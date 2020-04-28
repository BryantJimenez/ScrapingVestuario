 (function($) {

 	"use strict";

 	$('[data-toggle="tooltip"]').tooltip();

 	var isMobile = {
 		Android: function() {
 			return navigator.userAgent.match(/Android/i);
 		},
 		BlackBerry: function() {
 			return navigator.userAgent.match(/BlackBerry/i);
 		},
 		iOS: function() {
 			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
 		},
 		Opera: function() {
 			return navigator.userAgent.match(/Opera Mini/i);
 		},
 		Windows: function() {
 			return navigator.userAgent.match(/IEMobile/i);
 		},
 		any: function() {
 			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
 		}
 	};

	// loader
	var loader = function() {
		setTimeout(function() { 
			if($('#ftco-loader').length > 0) {
				$('#ftco-loader').removeClass('show');
			}
		}, 1);
	};
	loader();

	$('nav .dropdown').hover(function(){
		var $this = $(this);
		// 	 timer;
		// clearTimeout(timer);
		$this.addClass('show');
		$this.find('> a').attr('aria-expanded', true);
		// $this.find('.dropdown-menu').addClass('animated-fast fadeInUp show');
		$this.find('.dropdown-menu').addClass('show');
	}, function(){
		var $this = $(this);
			// timer;
		// timer = setTimeout(function(){
			$this.removeClass('show');
			$this.find('> a').attr('aria-expanded', false);
			// $this.find('.dropdown-menu').removeClass('animated-fast fadeInUp show');
			$this.find('.dropdown-menu').removeClass('show');
		// }, 100);
	});


	$('#dropdown04').on('show.bs.dropdown', function () {
		console.log('show');
	});

	// scroll
	var scrollWindow = function() {
		$(window).scroll(function(){
			var $w = $(this),
			st = $w.scrollTop(),
			navbar = $('.ftco_navbar'),
			sd = $('.js-scroll-wrap');

			if (st > 150) {
				if ( !navbar.hasClass('scrolled') ) {
					navbar.addClass('scrolled');	
				}
			} 
			if (st < 150) {
				if ( navbar.hasClass('scrolled') ) {
					navbar.removeClass('scrolled sleep');
				}
			} 
			if ( st > 350 ) {
				if ( !navbar.hasClass('awake') ) {
					navbar.addClass('awake');	
				}
				
				if(sd.length > 0) {
					sd.addClass('sleep');
				}
			}
			if ( st < 350 ) {
				if ( navbar.hasClass('awake') ) {
					navbar.removeClass('awake');
					navbar.addClass('sleep');
				}
				if(sd.length > 0) {
					sd.removeClass('sleep');
				}
			}
		});
	};
	scrollWindow();

	
	var counter = function() {
		
		$('#section-counter').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {

				var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',')
				$('.number').each(function(){
					var $this = $(this),
					num = $this.data('number');
					console.log(num);
					$this.animateNumber(
					{
						number: num,
						numberStep: comma_separator_number_step
					}, 7000
					);
				});
				
			}

		} , { offset: '95%' } );

	}
	counter();

	var contentWayPoint = function() {
		var i = 0;
		$('.ftco-animate').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {
				
				i++;

				$(this.element).addClass('item-animate');
				setTimeout(function(){

					$('body .ftco-animate.item-animate').each(function(k){
						var el = $(this);
						setTimeout( function () {
							var effect = el.data('animate-effect');
							if ( effect === 'fadeIn') {
								el.addClass('fadeIn ftco-animated');
							} else if ( effect === 'fadeInLeft') {
								el.addClass('fadeInLeft ftco-animated');
							} else if ( effect === 'fadeInRight') {
								el.addClass('fadeInRight ftco-animated');
							} else {
								el.addClass('fadeInUp ftco-animated');
							}
							el.removeClass('item-animate');
						},  k * 50, 'easeInOutExpo' );
					});
					
				}, 100);
				
			}

		} , { offset: '95%' } );
	};
	contentWayPoint();


	// navigation
	var OnePageNav = function() {
		$(".smoothscroll[href^='#'], #ftco-nav ul li a[href^='#']").on('click', function(e) {
			e.preventDefault();

			var hash = this.hash,
			navToggler = $('.navbar-toggler');
			$('html, body').animate({
				scrollTop: $(hash).offset().top
			}, 700, 'easeInOutExpo', function(){
				window.location.hash = hash;
			});


			if ( navToggler.is(':visible') ) {
				navToggler.click();
			}
		});
		$('body').on('activate.bs.scrollspy', function () {
			console.log('nice');
		})
	};
	OnePageNav();

	var goHere = function() {

		$('.mouse-icon').on('click', function(event){
			
			event.preventDefault();

			$('html,body').animate({
				scrollTop: $('.goto-here').offset().top
			}, 500, 'easeInOutExpo');
			
			return false;
		});
	};
	goHere();

})(jQuery);

$(document).ready(function() {
	//multiselect
	if ($('.multiselect').length) {
		$('.multiselect').select2({
			theme: "bootstrap",
			language: "es"
		});
	}
});

$('select[name="category"]').change(function(event) {
	selected=$('select[name="category"] option:selected');

	$('select[name="filter"] option, select[name="subcategory"] option, #alert').addClass('d-none');
	$('select[name="filter"] option[value=""], select[name="subcategory"] option[value=""]').removeClass('d-none');
	$('select[name="filter"], select[name="subcategory"]').val('');
	$('select[name="filter"], select[name="subcategory"], #btn-extract').attr('disabled', true);

	if (selected.val()!="") {
		var category=selected.attr('category'), withFilters=selected.attr('withFilters'), withSubcategories=selected.attr('withSubcategories');
		if (withFilters) {
			$('select[name="filter"] option[category="'+category+'"]').removeClass('d-none');
			$('select[name="filter"]').attr('disabled', false);
		} else {
			if (withSubcategories) {
				$('#message-info').text('Esta categoría no posee filtros, selecciona la subcategoría de la cual quieres extraer los datos.');
				$('#alert').removeClass('d-none');
				$('select[name="subcategory"] option[category="'+category+'"]').removeClass('d-none');
				$('select[name="subcategory"]').attr('disabled', false);
			} else {
				$('#message-info').text('Esta categoría no posee filtros ni subcategorías, puedes extraer los datos directamente de la categoría');
				$('#alert').removeClass('d-none');
				$('#btn-extract').attr('disabled', false);
			}
		}
	}
});

$('select[name="filter"]').change(function(event) {
	selected=$('select[name="filter"] option:selected');

	$('select[name="subcategory"] option, #alert').addClass('d-none');
	$('select[name="subcategory"] option[value=""]').removeClass('d-none');
	$('select[name="subcategory"]').val('');
	$('select[name="subcategory"], #btn-extract').attr('disabled', true);

	if (selected.val()!="") {
		var category=selected.attr('category'), filter=selected.val();
		$('select[name="subcategory"] option[category="'+category+'"]').each(function(index, el) {
			if ($(this).attr('filter')==filter) {
				$(this).removeClass('d-none');
			}
		});
		$('select[name="subcategory"]').attr('disabled', false);
	}
});

$('select[name="subcategory"]').change(function(event) {
	selected=$('select[name="subcategory"] option:selected');
	$('#alert').addClass('d-none');
	$('#btn-extract').attr('disabled', true);

	if (selected.val()!="") {
		$('#btn-extract').attr('disabled', false);
	}
});