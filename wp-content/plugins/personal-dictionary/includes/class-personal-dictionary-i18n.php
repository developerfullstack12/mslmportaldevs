<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://ays-pro.com
 * @since      1.0.0
 *
 * @package    Personal_Dictionary
 * @subpackage Personal_Dictionary/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Personal_Dictionary
 * @subpackage Personal_Dictionary/includes
 * @author     Personal Dictionary Team <info@ays-pro.com>
 */
class Personal_Dictionary_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'personal-dictionary',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
