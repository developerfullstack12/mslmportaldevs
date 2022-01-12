<?php
/**
 * Plugin Name:     GamiPress - Conditional Notifications
 * Plugin URI:      https://gamipress.com/add-ons/gamipress-conditional-notifications
 * Description:     Automatically display notifications based on pre-defined conditions.
 * Version:         1.0.9
 * Author:          GamiPress
 * Author URI:      https://gamipress.com/
 * Text Domain:     gamipress-conditional-notifications
 * License:         GNU AGPL v3.0 (http://www.gnu.org/licenses/agpl.txt)
 *
 * @package         GamiPress\Conditional_Notifications
 * @author          GamiPress
 * @copyright       Copyright (c) GamiPress
 */

final class GamiPress_Conditional_Notifications {

    /**
     * @var         GamiPress_Conditional_Notifications $instance The one true GamiPress_Conditional_Notifications
     * @since       1.0.0
     */
    private static $instance;

    /**
     * Get active instance
     *
     * @access      public
     * @since       1.0.0
     * @return      GamiPress_Conditional_Notifications self::$instance The one true GamiPress_Conditional_Notifications
     */
    public static function instance() {

        if( ! self::$instance ) {

            self::$instance = new GamiPress_Conditional_Notifications();
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
        define( 'GAMIPRESS_CONDITIONAL_NOTIFICATIONS_VER', '1.0.9' );

        // GamiPress minimum required version
        define( 'GAMIPRESS_CONDITIONAL_NOTIFICATIONS_GAMIPRESS_MIN_VER', '1.9.0' );

        // Plugin file
        define( 'GAMIPRESS_CONDITIONAL_NOTIFICATIONS_FILE', __FILE__ );

        // Plugin path
        define( 'GAMIPRESS_CONDITIONAL_NOTIFICATIONS_DIR', plugin_dir_path( __FILE__ ) );

        // Plugin URL
        define( 'GAMIPRESS_CONDITIONAL_NOTIFICATIONS_URL', plugin_dir_url( __FILE__ ) );

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

            require_once GAMIPRESS_CONDITIONAL_NOTIFICATIONS_DIR . 'includes/admin.php';
            require_once GAMIPRESS_CONDITIONAL_NOTIFICATIONS_DIR . 'includes/custom-tables.php';
            require_once GAMIPRESS_CONDITIONAL_NOTIFICATIONS_DIR . 'includes/conditional-notifications.php';
            require_once GAMIPRESS_CONDITIONAL_NOTIFICATIONS_DIR . 'includes/functions.php';
            require_once GAMIPRESS_CONDITIONAL_NOTIFICATIONS_DIR . 'includes/listeners.php';
            require_once GAMIPRESS_CONDITIONAL_NOTIFICATIONS_DIR . 'includes/scripts.php';
            require_once GAMIPRESS_CONDITIONAL_NOTIFICATIONS_DIR . 'includes/template-functions.php';

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

    }

    /**
     * Deactivation hook for the plugin.
     *
     * @since  1.0.0
     */
    public static function deactivate() {

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
                        __( 'GamiPress - Conditional Notifications requires %s (%s or higher) and %s in order to work. Please install and activate it.', 'gamipress-conditional-notifications' ),
                        '<a href="https://wordpress.org/plugins/gamipress/" target="_blank">GamiPress</a>',
                        GAMIPRESS_CONDITIONAL_NOTIFICATIONS_GAMIPRESS_MIN_VER,
                        '<a href="https://gamipress.com/add-ons/gamipress-notifications/" target="_blank">GamiPress - Notifications</a>'
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

        if ( class_exists( 'GamiPress' ) && version_compare( GAMIPRESS_VER, GAMIPRESS_CONDITIONAL_NOTIFICATIONS_GAMIPRESS_MIN_VER, '>=' )
            && class_exists( 'GamiPress_Notifications' ) ) {
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
        $lang_dir = GAMIPRESS_CONDITIONAL_NOTIFICATIONS_DIR . '/languages/';
        $lang_dir = apply_filters( 'gamipress_conditional_notifications_languages_directory', $lang_dir );

        // Traditional WordPress plugin locale filter
        $locale = apply_filters( 'plugin_locale', get_locale(), 'gamipress-conditional-notifications' );
        $mofile = sprintf( '%1$s-%2$s.mo', 'gamipress-conditional-notifications', $locale );

        // Setup paths to current locale file
        $mofile_local   = $lang_dir . $mofile;
        $mofile_global  = WP_LANG_DIR . '/gamipress-conditional-notifications/' . $mofile;

        if( file_exists( $mofile_global ) ) {
            // Look in global /wp-content/languages/gamipress/ folder
            load_textdomain( 'gamipress-conditional-notifications', $mofile_global );
        } elseif( file_exists( $mofile_local ) ) {
            // Look in local /wp-content/plugins/gamipress/languages/ folder
            load_textdomain( 'gamipress-conditional-notifications', $mofile_local );
        } else {
            // Load the default language files
            load_plugin_textdomain( 'gamipress-conditional-notifications', false, $lang_dir );
        }

    }

}

/**
 * The main function responsible for returning the one true GamiPress_Conditional_Notifications instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \GamiPress_Conditional_Notifications The one true GamiPress_Conditional_Notifications
 */
function gamipress_conditional_notifications() {
    return GamiPress_Conditional_Notifications::instance();
}
add_action( 'plugins_loaded', 'gamipress_conditional_notifications' );

// Setup our activation and deactivation hooks
register_activation_hook( __FILE__, array( 'GamiPress_Conditional_Notifications', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'GamiPress_Conditional_Notifications', 'deactivate' ) );