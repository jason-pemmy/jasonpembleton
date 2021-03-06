<?php

class Theme_Enqueues extends Base_Factory {

	public function __construct() {
		add_action( 'wp_default_styles', array( &$this, 'default_style_version' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_styles' ) );
	}

	public function default_style_version( $styles ) {
		$styles->default_version = '0.0.1';
	}

	private function iterate_enqueue( $stylesheets, $blessed = false ) {
		if ( empty($stylesheets ) ) {
			return false;
		}

		$theme_base = self::get_stylesheet_dir();
		$stylesheet_directory = ( $blessed ) ? $theme_base . '/css/blessed/' : $theme_base . '/css/unminified/';
		$stylesheet_prefix = WP_DEFAULT_THEME.'-';//
		$stylesheet_version = '1.0.0';

		foreach ( $stylesheets as $stylesheet ) {
			wp_enqueue_style( $stylesheet_prefix . $stylesheet, $stylesheet_directory . $stylesheet . '.css', array(), $stylesheet_version );
		}
	}

	public function enqueue_styles() {
		if ( ! is_admin() ) {
			$theme_base = self::get_stylesheet_dir();

			if ( 'dev' == TBK_ENVIRONMENT || 1 == 1 ) { // todo: remove 1 == 1 when approaching QA
				$css_directory = $theme_base . '/css/unminified/';

				// vendors - all 3rd party styles come first
				Theme_Enqueues::iterate_enqueue( array(
					'bootstrap',
					'js_composer',					
				) );

				// base
				Theme_Enqueues::iterate_enqueue( array(
					'base',
					'frontend-tool',
					'fonts',
					'typography',
					'lists',
					'tables',
					'helpers',
					'animations',
					'z-index',
					'icomoon',
				) );

				// layout
				Theme_Enqueues::iterate_enqueue( array(
					'header',
					'footer',
					'mobile-menu',
					'forms',
					'faq-block',
				) );

				// components
				Theme_Enqueues::iterate_enqueue( array(
					'navbar-toggle',
					'hero-banner',
                    'secondary-hero-banner',
                    'portfolio-container',
                    'portfolio-item',
					'about-section',
					'contact-section',
				) );

				// pages
				Theme_Enqueues::iterate_enqueue( array(
				) );

				// themes
				Theme_Enqueues::iterate_enqueue( array(
				) );

				// shame file
				Theme_Enqueues::iterate_enqueue( array(
					'shame',
				) );

			} else { // on prod/stage
				Theme_Enqueues::iterate_enqueue( array(
					'styles.2',
                    'styles.1',
					'styles',
				), true );
			}

			wp_dequeue_style( 'gforms_extra' );
			global $wp_styles;
			unset( $wp_styles->registered['js_composer_front'] );
		}
	}

	function get_stylesheet_dir( $key = 'url' ) {
		return esc_url( get_stylesheet_directory_uri() );
	}

	public function enqueue_scripts() {
		$js_directory = self::get_stylesheet_dir() . '/js/';

		if ( ! is_admin() ) {
			// all pages - 3rd party
			// wp_enqueue_script( 'typekit', 'https://use.typekit.net/insertURLhere.js', false, false, false );
			wp_enqueue_script( 'jquery' );			
			wp_enqueue_script( 'modernizr' , $js_directory . 'vendor/modernizr.js');
			wp_enqueue_script( 'waypoints' , $js_directory . 'vendor/jquery.waypoints.min.js');
			wp_enqueue_script( 'tweenmax' , $js_directory . 'vendor/TweenMax.min.js');	 		
			
			// all pages - our stuff
			wp_enqueue_script( 'main-scripts', $js_directory . 'scripts.js', array( 'jquery'), false, true );
			//wp_enqueue_script( 'navigation', $js_directory . 'navigation.js', array( 'jquery' ), false, true );
		}
	}

}

Theme_Enqueues::instantiate();
