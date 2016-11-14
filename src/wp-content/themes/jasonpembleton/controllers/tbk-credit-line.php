<?php

$credit_line = new Tbk_Credit_Line();

class Tbk_Credit_Line {

	private $source = 'http://tbkcreative.com/credit.php';

	function __construct() {
		add_action( 'schedule_tbk_credit_line', array( &$this, 'schedule_tbk_credit_line' ) );
		add_action( 'populate_options_record', array( &$this, 'save_to_options_table' ) );
		add_action( 'add_credit_line_to_footer', array( &$this, 'add_credit_line' ) );
	}

	function schedule_tbk_credit_line() {
		if ( ! wp_next_scheduled( 'populate_options_record' ) ) {
			wp_schedule_event( time(), 'daily', 'populate_options_record' );
		}
	}

	function save_to_options_table() {
		$credit_line_data = file_get_contents( $this->source );
		update_option( 'credit_line', $credit_line_data );
	}

	public function add_credit_line() {
		$credit_line = get_option( 'credit_line' );

		if ( ! $credit_line ) {
			$credit_line = '<a href="http://www.tbkcreative.com" target="_blank">tbk Creative | Web Design &amp; Digital Marketing</a>';
		}

		echo apply_filters( 'filter_credit_line', $credit_line );
	}

}
