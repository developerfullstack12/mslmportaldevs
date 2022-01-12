<?php
/**
 * Plugin Name:     GamiPress - Birthdays
 * Plugin URI:      https://gamipress.com/add-ons/gamipress-birthdays
 * Description:     Award your users for their birthday.
 * Version:         1.0.1
 * Author:          GamiPress
 * Author URI:      https://gamipress.com/
 * Text Domain:     gamipress-birthdays
 * License:         GNU AGPL v3.0 (http://www.gnu.org/licenses/agpl.txt)
 *
 * @package         GamiPress\Birthdays
 * @author          GamiPress
 * @copyright       Copyright (c) GamiPress
 */

final class GamiPress_Birthdays {

    /**
     * @var         GamiPress_Birthdays $instance The one true GamiPress_Birthdays
     * @since       1.0.0
     */
    private static $instance;

    /**
     * Get active instance
     *
     * @access      public
     * @since       1.0.0
     * @return      GamiPress_Birthdays self::$instance The one true GamiPress_Birthdays
     */
    public static function instance() {
        if( !self::$instance ) {
            self::$instance = new GamiPress_Birthdays();
            self::$instance->constants();
            self::$instance->includes();
            self::$instance->hooks();
            self::$instance->load_textdomain();
        }

        return self::$instance;
    }

    /**
     * Setup plugin constants
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function constants() {
        // Plugin version
        define( 'GAMIPRESS_BIRTHDAYS_VER', '1.0.1' );

        // GamiPress minimum required version
        define( 'GAMIPRESS_BIRTHDAYS_GAMIPRESS_MIN_VER', '1.8.0' );

        // Plugin file
        define( 'GAMIPRESS_BIRTHDAYS_FILE', __FILE__ );

        // Plugin path
        define( 'GAMIPRESS_BIRTHDAYS_DIR', plugin_dir_path( __FILE__ ) );

        // Plugin URL
        define( 'GAMIPRESS_BIRTHDAYS_URL', plugin_dir_url( __FILE__ ) );
    }

    /**
     * Include plugin files
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function includes() {

        if( $this->meets_requirements() ) {

            require_once GAMIPRESS_BIRTHDAYS_DIR . 'includes/admin.php';
            require_once GAMIPRESS_BIRTHDAYS_DIR . 'includes/functions.php';
            require_once GAMIPRESS_BIRTHDAYS_DIR . 'includes/requirements.php';
            require_once GAMIPRESS_BIRTHDAYS_DIR . 'includes/rules-engine.php';
            require_once GAMIPRESS_BIRTHDAYS_DIR . 'includes/listeners.php';
            require_once GAMIPRESS_BIRTHDAYS_DIR . 'includes/scripts.php';
            require_once GAMIPRESS_BIRTHDAYS_DIR . 'includes/triggers.php';

        }
    }

    /**
     * Setup plugin hooks
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function hooks() {
        add_action( 'admin_notices', array( $this, 'admin_notices' ) );
    }

    /**
     * Activation hook for the plugin.
     *
     * @since  1.0.0
     */
    public static function activate() {

        GamiPress_Birthdays::instance();

        // Setup the daily cron event to process events daily (used to determine which email digest should be sent)
        if ( ! wp_next_scheduled( 'gamipress_birthdays_cron' ) ) {
            wp_schedule_event( time(), 'daily', 'gamipress_birthdays_cron' );
        }

    }

    /**
     * Deactivation hook for the plugin.
     *
     * @since  1.0.0
     */
    public static function deactivate() {

        // Un-schedule cron jobs
        wp_clear_scheduled_hook( 'gamipress_birthdays_cron' );

    }

    /**
     * Plugin admin notices.
     *
     * @since  1.0.0
     */
    public function admin_notices() {

        if ( ! $this->meets_requirements() && ! defined( 'GAMIPRESS_ADMIN_NOTICES' ) ) : ?>

            <div id="message" class="notice notice-error is-dismissible">
                <p>
                    <?php printf(
                        __( 'GamiPress - Birthdays requires %s (%s or higher) in order to work. Please install and activate them.', 'gamipress-birthdays' ),
                        '<a href="https://wordpress.org/plugins/gamipress/" target="_blank">GamiPress</a>',
                        GAMIPRESS_BIRTHDAYS_GAMIPRESS_MIN_VER
                    ); ?>
                </p>
            </div>

            <?php define( 'GAMIPRESS_ADMIN_NOTICES', true ); ?>

        <?php endif;

    }

    /**
     * Check if there are all plugin requirements
     *
     * @since  1.0.0
     *
     * @return bool True if installation meets all requirements
     */
    private function meets_requirements() {

        if ( class_exists( 'GamiPress' ) && version_compare( GAMIPRESS_VER, GAMIPRESS_BIRTHDAYS_GAMIPRESS_MIN_VER, '>=' ) ) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Internationalization
     *
     * @access      public
     * @since       1.0.0
     * @return      void
     */
    public function load_textdomain() {

        // Set filter for language directory
        $lang_dir = GAMIPRESS_BIRTHDAYS_DIR . '/languages/';
        $lang_dir = apply_filters( 'gamipress_birthdays_languages_directory', $lang_dir );

        // Traditional WordPress plugin locale filter
        $locale = apply_filters( 'plugin_locale', get_locale(), 'gamipress-birthdays' );
        $mofile = sprintf( '%1$s-%2$s.mo', 'gamipress-birthdays', $locale );

        // Setup paths to current locale file
        $mofile_local   = $lang_dir . $mofile;
        $mofile_global  = WP_LANG_DIR . '/gamipress-birthdays/' . $mofile;

        if( file_exists( $mofile_global ) ) {
            // Look in global /wp-content/languages/gamipress/ folder
            load_textdomain( 'gamipress-birthdays', $mofile_global );
        } elseif( file_exists( $mofile_local ) ) {
            // Look in local /wp-content/plugins/gamipress/languages/ folder
            load_textdomain( 'gamipress-birthdays', $mofile_local );
        } else {
            // Load the default language files
            load_plugin_textdomain( 'gamipress-birthdays', false, $lang_dir );
        }

    }

}

/**
 * The main function responsible for returning the one true GamiPress_Birthdays instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \GamiPress_Birthdays The one true GamiPress_Birthdays
 */
function GamiPress_Birthdays() {
    return GamiPress_Birthdays::instance();
}
add_action( 'plugins_loaded', 'GamiPress_Birthdays' );

// Setup our activation and deactivation hooks
register_activation_hook( __FILE__, array( 'GamiPress_Birthdays', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'GamiPress_Birthdays', 'deactivate' ) );
