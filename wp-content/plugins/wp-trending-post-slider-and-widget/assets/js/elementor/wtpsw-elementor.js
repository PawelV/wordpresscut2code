( function($) {

	'use strict';

	jQuery(window).on('elementor/frontend/init', function() {

		/* Shortcode Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/shortcode.default', function() {
			wtpsw_trending_slider_init();
			wtpsw_trending_carousel_init();
		});

		/* Text Editor Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/text-editor.default', function() {
			wtpsw_trending_slider_init();
			wtpsw_trending_carousel_init();
		});

		/* Tabs Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/tabs.default', function($scope) {

			/* Tweak for slick slider */
			$scope.find('.wtpsw-post-slider-init').each(function( index ) {

				var slider_id = $(this).attr('id');
				$('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

				wtpsw_trending_slider_init();
				wtpsw_trending_carousel_init();

				setTimeout(function() {

					/* Tweak for slick slider */
					if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
						$('#'+slider_id).slick( 'setPosition' );
						$('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
					}
				}, 300);
			});
		});

		/* Accordion Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/accordion.default', function($scope) {

			/* Tweak for slick slider */
			$scope.find('.wtpsw-post-slider-init').each(function( index ) {

				var slider_id = $(this).attr('id');
				$('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

				wtpsw_trending_slider_init();
				wtpsw_trending_carousel_init();

				setTimeout(function() {

					/* Tweak for slick slider */
					if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
						$('#'+slider_id).slick( 'setPosition' );
						$('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
					}
				}, 300);
			});
		});

		/* Toggle Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/toggle.default', function($scope) {

			/* Tweak for slick slider */
			$scope.find('.wtpsw-post-slider-init').each(function( index ) {

				var slider_id = $(this).attr('id');
				$('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

				wtpsw_trending_slider_init();
				wtpsw_trending_carousel_init();

				setTimeout(function() {

					/* Tweak for slick slider */
					if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
						$('#'+slider_id).slick( 'setPosition' );
						$('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
					}
				}, 300);
			});
		});
	});
})(jQuery);