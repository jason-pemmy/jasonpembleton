<?php

class TBK_Nav_Walker extends Walker_Nav_Menu {
	function __construct() {
		add_filter( 'nav_menu_link_attributes', array( &$this, 'dropdown_toggle_atts' ), 100, 4 );
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$item->classes[] = 'menu-'.sanitize_title($item->title);
		if(intval($item->menu_item_parent) == 0 && in_array('menu-item-has-children', $item->classes)) {
			$item->classes[] = 'dropdown';
		}
		parent::start_el($output, $item, $depth, $args, $id);
	}

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n".$indent.'<ul class="dropdown-menu" role="menu">'."\n";
	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	public function dropdown_toggle_atts( $atts, $item, $args, $depth) {
		if(intval($item->menu_item_parent) == 0 && in_array('menu-item-has-children', $item->classes)) {
			//$atts['href'] = '#';
			$atts['class'] = 'dropdown-toggle';
			$atts['data-toggle'] = 'dropdown';
			$atts['role'] = 'button';
			$atts['aria-haspopup'] = 'true';
			$atts['aria-expanded'] = 'true';
		}
		return $atts;
	}
}