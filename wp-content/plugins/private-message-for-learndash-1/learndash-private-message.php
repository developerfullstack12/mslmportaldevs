<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://honorswp.com/
 * @since             1.0.0
 * @package           Learndash_Private_Message
 *
 * @wordpress-plugin
 * Plugin Name:       Private Message for LearnDash
 * Plugin URI:        https://honorswp.com/
 * Description:       Live chat plugin for LearnDash.
 * Version:           4.4.0
 * Author:            HonorsWP
 * Author URI:        https://honorswp.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       learndash-private-message
 * Domain Path:       /languages
 */

// namespace EA_PRIVATE_MSG_LD;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once __DIR__ . '/vendor/autoload.php';

use EA\Licensing\License;

/** Current plugin version */
define( 'LEARNDASH_PRIVATE_MESSAGE_VERSION', '4.4.0' );

/**
 * Licensing.
 */
new License(
	__( 'Private Message for LearnDash', 'learndash-private-message' ),
	6615,
	'private-message-for-learndash',
	__FILE__,
	LEARNDASH_PRIVATE_MESSAGE_VERSION
);

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-learndash-private-message-activator.php
 */
function activate_learndash_private_message() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-learndash-private-message-activator.php';

	Learndash_Private_Message_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-learndash-private-message-deactivator.php
 */
function deactivate_learndash_private_message() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-learndash-private-message-deactivator.php';

	Learndash_Private_Message_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_learndash_private_message' );
register_deactivation_hook( __FILE__, 'deactivate_learndash_private_message' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/classes/class-learndash-private-message-sent-email-archive.php';

require plugin_dir_path( __FILE__ ) . 'includes/classes/class-learndash-private-message-private-groups.php';

require plugin_dir_path( __FILE__ ) . 'includes/classes/class-learndash-private-message-user-settings.php';

require plugin_dir_path( __FILE__ ) . 'includes/class-learndash-private-message.php';

require plugin_dir_path( __FILE__ ) . 'includes/class-learndash-private-message-migrator.php';

require_once plugin_dir_path( __FILE__ ) . 'vendor/woocommerce/action-scheduler/action-scheduler.php';

require_once plugin_dir_path( __FILE__ ) . 'functions.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
$min_php = '7.2.0';

if ( version_compare( PHP_VERSION, $min_php, '>=' ) ) {
	$ldpm_plugin = new Learndash_Private_Message();
	$ldpm_plugin->run();
}

// require_once plugin_dir_path( __FILE__ ) . 'vendor/immerseus/immerseus-upgrader/src/index.php';
