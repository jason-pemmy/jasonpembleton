<?php
define( 'THEME_PATH', dirname( __FILE__ ) . '/' );
define( 'THEME_URL', trailingslashit( get_stylesheet_directory_uri() ) );

require_once THEME_PATH . '/helpers/base-factory.php';
require_once THEME_PATH . '/helpers/class.TBK-Theme.php';
require_once THEME_PATH . '/helpers/tbk-render.php';
require_once ('wp_bootstrap_navwalker.php');

class The_Theme extends TBK_Theme {

	static $instance = false;

	function __construct() {
		parent::__construct();

		$this->iterate_mvc( array(
			'helpers',
			'models',
			'controllers',
		) );

		//3rd party libraries
		TBK_Render::load( array(
			'disable-updates',
			'setup-styles',
		) );

		//responsive image sizes
		self::create_image_sizes( 'desktop-lg', 1200, 9999, true );
		self::create_image_sizes( 'desktop-sm', 992, 9999, true );
		self::create_image_sizes( 'tablet', 768, 500, true );
		self::create_image_sizes( 'mobile-lg', 500, 300, true );
		self::create_image_sizes( 'mobile-sm', 380, 300, true );


	}
}

if( function_exists('acf_add_options_page') ) {	
	acf_add_options_page();	
}

The_Theme::get_instance();