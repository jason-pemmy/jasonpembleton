<?php

if ( ! class_exists( 'Base_Factory' ) ) {
	abstract class Base_Factory {

		private static $_instances = array();
		private static $post_type = null;

		public function __construct( $post_type = null ) {
			if ( ! empty( $post_type ) ) {
				self::$post_type = $post_type;
			}
		}

		public static function instantiate() {
			self::get_instance();

			return null;
		}

		public static function get_instance() {
			$class = get_called_class();
			if ( ! isset( self::$_instances[ $class ] ) ) {
				self::$_instances[ $class ] = new $class();
			}

			return self::$_instances[ $class ];
		}

		public static function default_query_args() {
			return array(
				'post_type' => self::$post_type,
				'post_status' => 'publish',
				'orderby' => 'menu_order',
				'order' => 'asc',
			);
		}
	}
}