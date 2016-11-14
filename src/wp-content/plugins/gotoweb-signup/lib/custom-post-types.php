<?php
class Custom_Post {

	protected $custom_posts = array();
	protected $custom_post_slugs = array();

	function __construct() {
	}

	function add_custom_posts($custom_posts) {
		$this->custom_posts = $custom_posts;
		add_action('init', array( $this, 'add_args' ));
		add_action('register_post_custom_init_hook', array( $this, 'register_post_custom_init' ));
	}

	function add_args() {
		$args = $this->custom_posts;
		do_action('register_post_custom_init_hook', $args);
	}

	function register_post_custom_init($custom_posts) {

		foreach ($custom_posts as $custom_post_name => $custom_post_args) {
			$custom_post_slug = sanitize_title($custom_post_name);
			//Check if we have specified a plural
			if ($custom_post_args['plural']) {
				$custom_post_slug_plural = sanitize_title($custom_post_args['plural']);
				$custom_post_name_plural = $custom_post_args['plural'];
				unset($custom_post_args['plural']);
			} else {
				//If we havent specified and the title ends in Y , handle it
				$custom_post_name_plural = plural($custom_post_name);
			}

			$default_labels = array(
					'name' => _x($custom_post_name_plural, 'post type general name'),
					'singular_name' => _x($custom_post_name, 'post type singular name'),
					'add_new' => _x('Add New', $custom_post_name),
					'add_new_item' => __('Add New ' . $custom_post_name),
					'edit_item' => __('Edit ' . $custom_post_name),
					'new_item' => __('New ' . $custom_post_name),
					'all_items' => __('All ' . $custom_post_name_plural),
					'view_item' => __('View ' . $custom_post_name),
					'search_items' => __('Search ' . $custom_post_name_plural),
					'not_found' => __('No ' . $custom_post_name_plural . ' found'),
					'not_found_in_trash' => __('No ' . $custom_post_name_plural . ' found in Trash'),
					'parent_item_colon' => '',
					'menu_name' => __($custom_post_name_plural, 'your_text_domain')
			);

			$labels = wp_parse_args($custom_post_args['labels'], $default_labels);

			$default_args = array(
					'labels' => $labels,
					'public' => true,
					'publicly_queryable' => true,
					'show_ui' => true,
					'show_in_menu' => true,
					'query_var' => true,
					'rewrite' => array( 'slug' => $custom_post_slug_plural ),
					'capability_type' => 'page',
					'has_archive' => true,
					'hierarchical' => true,
					'menu_position' => null,
					'menu_icon' => null,
					'supports' => array(
							'title',
							'editor',
							'author',
							'thumbnail',
							'excerpt',
							'page-attributes',
					)
			);

			$args = wp_parse_args($custom_post_args, $default_args);

			array_push($this->custom_post_slugs, $custom_post_slug);
			register_post_type($custom_post_slug, $args);
		}
	}
}