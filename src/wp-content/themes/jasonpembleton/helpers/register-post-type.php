<?php

class Register_Post_Type {
	private static $_instances = array();
	private static $post_type = null;

	public function __construct() {

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

	public static function register( $post_type_name, $args = array() ) {
		if ( empty( $args['post_type'] ) ) {
			$args['post_type'] = sanitize_title( $post_type_name );
		}
		$post_type_slug = $args['post_type'];
		$default_labels = array(
			'name' => $post_type_name,
			'singular_name' => $post_type_name,
			'add_new' => __( 'Add New', 'the-theme-admin' ) . ' ' . $post_type_name,
			'add_new_item' => __( 'Add New', 'the-theme-admin' ) . ' ' . $post_type_name,
			'edit_item' => __( 'Edit', 'the-theme-admin' ) . ' ' . $post_type_name,
			'new_item' => __( 'New', 'the-theme-admin' ) . ' ' . $post_type_name,
			'all_items' => __( 'All', 'the-theme-admin' ) . ' ' . plural( $post_type_name ),
			'view_item' => __( 'View', 'the-theme-admin' ) . ' ' . $post_type_name,
			'search_items' => __( 'Search', 'the-theme-admin' ) . ' ' . $post_type_name,
			'not_found' => __( 'No', 'the-theme-admin' ) . ' ' . plural( $post_type_name ) . ' ' . __( 'found', 'the-theme-admin' ),
			'not_found_in_trash' => __( 'No', 'the-theme-admin' ) . ' ' . plural( $post_type_name ) . ' ' . __( ' found in Trash', 'the-theme-admin' ),
			'parent_item_colon' => '',
			'menu_name' => plural( $post_type_name ),
		);
		if(array_key_exists('labels', $args)) {
			$labels = wp_parse_args( $args['labels'], $default_labels );
		} else {
			$labels = $default_labels;
		}

		$default_args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array(
				'slug' => plural( $post_type_slug ),
			),
			'capability_type' => 'page',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => null,
			'menu_icon' => null,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'page-attributes', ),
		);

		$args = wp_parse_args( $args, $default_args );
		register_post_type( $post_type_slug, $args );

	}
}

Register_Post_Type::instantiate();