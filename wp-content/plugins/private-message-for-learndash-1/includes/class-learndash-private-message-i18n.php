<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       immerseus.com
 * @since      1.0.0
 *
 * @package    Learndash_Private_Message
 * @subpackage Learndash_Private_Message/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Learndash_Private_Message
 * @subpackage Learndash_Private_Message/includes
 * @author     Dnyanesh Mahajan <dnyaneshmahajan12@gmail.com>
 */
class Learndash_Private_Message_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'learndash-private-message',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
