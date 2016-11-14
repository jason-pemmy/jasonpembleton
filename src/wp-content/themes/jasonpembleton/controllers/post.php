<?php
/*
 * If we do not have any posts or the project did not require posts,
 * we need to remove the ability for these to be seen by users, admins and search engines.
 */

class TBK_Post extends Base_Factory {

	static $posts_enabled = false;

	public function __construct() {
		//remove the posts area
		add_action( 'init', array( &$this, 'maybe_unregister_post_type' ), 100 );
		add_action( 'init', array( &$this, 'maybe_unregister_taxonomy' ), 100 );
		add_action( 'admin_menu', array( &$this, 'maybe_remove_default_post_type' ), 100 );
		add_filter( 'option_wpseo_xml', array( &$this, 'maybe_remove_post_terms' ), 100 );
	}

	function maybe_unregister_post_type() {
		if ( true !== self::$posts_enabled ) {
			global $wp_post_types;
			if ( isset( $wp_post_types['post'] ) ) {
				unset( $wp_post_types['post'] );

				return true;
			}
		}

		return false;
	}

	function maybe_remove_default_post_type() {
		if ( true !== self::$posts_enabled ) {
			remove_menu_page( 'edit.php' );
		}
	}


	function maybe_unregister_taxonomy() {
		if ( true !== self::$posts_enabled ) {
			global $wp_taxonomies;
			$taxonomies = array(
				'post_tag',
				'category',
			);
			foreach ( $taxonomies as $taxonomy ) {
				if ( taxonomy_exists( $taxonomy ) ) {
					unset( $wp_taxonomies[ $taxonomy ] );
				}
			}
		}
	}

	function maybe_remove_post_terms( $values ) {
		if ( true !== self::$posts_enabled ) {
			$post_taxonomies = array(
				'taxonomies-post_tag-not_in_sitemap',
				'taxonomies-category-not_in_sitemap',
				'taxonomies-post_format-not_in_sitemap',
			);
			foreach ( $values as $key => $value ) {
				if ( in_array($key, $post_taxonomies) ) {
					$values[$key] = true;
				}
			}
		}

		return $values;
	}
}

TBK_Post::instantiate();
