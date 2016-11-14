<?php

/*
 * This navigation will allow for Visual Composer's Templatera to be
 * used as a navigation layout manager.
 */

class VC_Nav_Walker extends TBK_Nav_Walker {

	function __construct() {
		add_filter( 'walker_nav_menu_start_el', array( &$this, 'vc_template_el' ), 100, 4 );
		add_filter( 'nav_menu_link_attributes', array( &$this, 'vc_link_atts' ), 100, 4 );
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		if ( $item->object == 'templatera' && $item->type == 'post_type' ) {
			$item->classes[] = 'dropdown-inner';
		}
		if ( intval( $item->menu_item_parent ) == 0 && in_array( 'menu-item-has-children', $item->classes ) ) {
			$item->classes[] = 'dropdown';
		}
		$item->classes[] = 'menu-' . sanitize_title( $item->title );
		parent::start_el( $output, $item, $depth, $args, $id );
	}

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n" . $indent . '<ul class="dropdown-menu" role="menu">' . "\n";
	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
	}

	public function vc_template_el( $item_output, $item = '', $depth = 0, $args = array() ) {
		if ( $item->object == 'templatera' && $item->type == 'post_type' ) {
			$template = get_post( $item->object_id );
			if ( ! empty( $template ) ) {
				$item_output = do_shortcode( $template->post_content );
			} else {
				$item_output = 'Error: Template not found.';
			}
		}

		return $item_output;
	}

	public function vc_link_atts( $atts, $item, $args, $depth ) {
		if ( 0 == intval( $item->menu_item_parent ) && in_array( 'menu-item-has-children', $item->classes ) && 'templatera' == $item->object ) {
			$atts['href'] = '#';
			$atts['class'] = 'dropdown-toggle';
			$atts['data-toggle'] = 'dropdown';
			$atts['role'] = 'button';
			$atts['aria-haspopup'] = 'true';
			$atts['aria-expanded'] = 'true';
		}

		return $atts;
	}

}