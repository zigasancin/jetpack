<?php

class Jetpack_Object_Cache_Helper extends Jetpack_Options {

	/**
	 * @var Jetpack_Object_Cache_Helper
	 **/
	private static $instance = null;

	/**
	 * @var array
	 */
	private static $whitelisted_options = array();

	static function init() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new Jetpack_Object_Cache_Helper;
		}

		return self::$instance;
	}

	private function __construct() {
		if ( ! wp_using_ext_object_cache() ) {
			return;
		}

		add_action( 'added_option',   'maybe_clear_alloptions_cache' );
		add_action( 'updated_option', 'maybe_clear_alloptions_cache' );
		add_action( 'deleted_option', 'maybe_clear_alloptions_cache' );

		self::$whitelisted_options = array_merge(
			array_values( parent::$grouped_options ),
			array_map( array( $this, 'prefix_option_with_jetpack' ), parent::get_option_names( 'non_compact' ) )
		);
	}

	function is_jetpack_option( $option ) {
		return in_array( $option, self::$whitelisted_options );
	}

	function prefix_option_with_jetpack( $option ) {
		return "jetpack_{$option}";
	}

	function maybe_clear_alloptions_cache( $option ) {
		if ( wp_installing() ) {
			return;
		}

		$alloptions = wp_load_alloptions();
		if ( isset( $alloptions[ $option ] ) && $this->is_jetpack_option( $option ) ) {
			wp_cache_delete( 'alloptions', 'options' );
		}
	}
}

Jetpack_Object_Cache_Helper::init();
