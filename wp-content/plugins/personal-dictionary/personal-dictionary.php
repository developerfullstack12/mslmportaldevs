<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ays-pro.com
 * @since             1.0.0
 * @package           Personal_Dictionary
 *
 * @wordpress-plugin
 * Plugin Name:       Personal Dictionary
 * Plugin URI:        https://ays-pro.com/wordpress/personal-dictionary
 * Description:       Allow your students to create personal dictionary, study and memorize the words.
 * Version:           7.0.1
 * Author:            Personal Dictionary Team
 * Author URI:        https://ays-pro.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       personal-dictionary
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PERSONAL_DICTIONARY_VERSION', '7.0.1' );
define( 'PERSONAL_DICTIONARY_NAME_VERSION', '7.0.0' );
define( 'PERSONAL_DICTIONARY_NAME', 'personal-dictionary' );
define( 'PERSONAL_DICTIONARY_DB_PREFIX', 'ayspd_' );

if( ! defined( 'PERSONAL_DICTIONARY_BASENAME' ) )
    define( 'PERSONAL_DICTIONARY_BASENAME', plugin_basename( __FILE__ ) );

if( ! defined( 'PERSONAL_DICTIONARY_DIR' ) )
    define( 'PERSONAL_DICTIONARY_DIR', plugin_dir_path( __FILE__ ) );

if( ! defined( 'PERSONAL_DICTIONARY_BASE_URL' ) )
    define( 'PERSONAL_DICTIONARY_BASE_URL', plugin_dir_url(__FILE__ ) );

if( ! defined( 'PERSONAL_DICTIONARY_ADMIN_PATH' ) )
    define( 'PERSONAL_DICTIONARY_ADMIN_PATH', plugin_dir_path( __FILE__ ) . 'admin' );

if( ! defined( 'PERSONAL_DICTIONARY_ADMIN_URL' ) )
    define( 'PERSONAL_DICTIONARY_ADMIN_URL', plugin_dir_url( __FILE__ ) . 'admin' );

if( ! defined( 'PERSONAL_DICTIONARY_PUBLIC_PATH' ) )
    define( 'PERSONAL_DICTIONARY_PUBLIC_PATH', plugin_dir_path( __FILE__ ) . 'public' );

if( ! defined( 'PERSONAL_DICTIONARY_PUBLIC_URL' ) )
    define( 'PERSONAL_DICTIONARY_PUBLIC_URL', plugin_dir_url( __FILE__ ) . 'public' );
    

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-personal-dictionary-activator.php
 */
function activate_personal_dictionary() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-personal-dictionary-activator.php';
	Personal_Dictionary_Activator::ays_pd_update_db_check();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-personal-dictionary-deactivator.php
 */
function deactivate_personal_dictionary() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-personal-dictionary-deactivator.php';
	Personal_Dictionary_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_personal_dictionary' );
register_deactivation_hook( __FILE__, 'deactivate_personal_dictionary' );

add_action( 'plugins_loaded', 'activate_personal_dictionary' );
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-personal-dictionary.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_personal_dictionary() {
    add_action( 'admin_notices', 'personal_dictionary_general_admin_notice' );
	$plugin = new Personal_Dictionary();
	$plugin->run();

}

function personal_dictionary_general_admin_notice(){
    global $wpdb;
    if ( isset($_GET['page']) && strpos( sanitize_text_field( $_GET['page'] ), PERSONAL_DICTIONARY_NAME) !== false ) {
        ?>
        <div class="ays-notice-banner">
            <div class="navigation-bar">
                <div id="navigation-container">
                    <a class="logo-container" href="http://ays-pro.com/" target="_blank">
                        <img class="logo" src="<?php echo PERSONAL_DICTIONARY_ADMIN_URL . '/images/ays_pro.png'; ?>" alt="AYS Pro logo" title="AYS Pro logo"/>
                    </a>
                    <ul id="menu">
                        <li><a class="ays-btn" href="https://ays-pro.com/wordpress/personal-dictionary/" target="_blank">PRO</a></li>
                        <li><a class="ays-btn" href="https://ays-pro.com/wordpress-personal-dictionary-user-manual" target="_blank">Documentation</a></li>
                        <li><a class="ays-btn" href="https://wordpress.org/support/plugin/personal-dictionary/reviews/" target="_blank">Rate us</a></li>
                        <li><a class="ays-btn" href="https://ays-pro.com/wordpress/personal-dictionary" target="_blank">Demo</a></li>
                        <li><a class="ays-btn" href="https://wordpress.org/support/plugin/personal-dictionary/" target="_blank">Support FORUM</a></li>
                        <li><a class="ays-btn" href="https://wordpress.org/support/plugin/personal-dictionary/" target="_blank">Contact us</a></li>
                    </ul>
                </div>
            </div>
        </div>
     <?php
    }
}

run_personal_dictionary();
