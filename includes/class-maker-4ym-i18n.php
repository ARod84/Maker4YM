<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://4youmaker.com
 * @since      1.0.0
 *
 * @package    Maker_4ym
 * @subpackage Maker_4ym/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Maker_4ym
 * @subpackage Maker_4ym/includes
 * @author     Araima Rodríguez <rodriguezaraima@gmail.com>
 */
class Maker_4ym_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'maker-4ym',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
