<?php
/**
 * Plugin Name:           GamiPress - LearnDash Group Leaderboard
 * Plugin URI:            https://wordpress.org/plugins/gamipress-learndash-group-leaderboard/
 * Description:           Automatically create a GamiPress leaderboard of LearnDash group members.
 * Version:               1.1.2
 * Author:                GamiPress
 * Author URI:            https://gamipress.com/
 * Text Domain:           gamipress-learndash-group-leaderboard
 * Domain Path:           /languages/
 * Requires at least:     4.4
 * Tested up to:          5.8
 * License:               GNU AGPL v3.0 (http://www.gnu.org/licenses/agpl.txt)
 *
 * @package               GamiPress\LearnDash_Group_Leaderboard
 * @author                GamiPress
 * @copyright             Copyright (c) GamiPress
 */

final class GamiPress_LearnDash_Group_Leaderboard {

    /**
     * @var         GamiPress_LearnDash_Group_Leaderboard $instance The one true GamiPress_LearnDash_Group_Leaderboard
     * @since       1.0.0
     */
    private static $instance;

    /**
     * Get active instance
     *
     * @access      public
     * @since       1.0.0
     * @return      object self::$instance The one true GamiPress_LearnDash_Group_Leaderboard
     */
    public static function instance() {
        if( !self::$instance ) {
            self::$instance = new GamiPress_LearnDash_Group_Leaderboard();
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
        define( 'GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_VER', '1.1.2' );

        // Required leaderboards version
        define( 'GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_LEADERBOARDS_MIN_VER', '1.3.0' );

        // Plugin file
        define( 'GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_FILE', __FILE__ );

        // Plugin path
        define( 'GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_DIR', plugin_dir_path( __FILE__ ) );

        // Plugin URL
        define( 'GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_URL', plugin_dir_url( __FILE__ ) );
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

            require_once GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_DIR . 'includes/admin.php';
            require_once GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_DIR . 'includes/blocks.php';
            require_once GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_DIR . 'includes/content-filters.php';
            require_once GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_DIR . 'includes/ajax-functions.php';
            require_once GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_DIR . 'includes/functions.php';
            require_once GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_DIR . 'includes/learndash-groups.php';
            require_once GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_DIR . 'includes/scripts.php';
            require_once GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_DIR . 'includes/shortcodes.php';
            require_once GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_DIR . 'includes/widgets.php';

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

        GamiPress_LearnDash_Group_Leaderboard::instance();

        if( function_exists( 'gamipress_learndash_group_leaderboard_regenerate_leaderboards' ) ) {

            gamipress_learndash_group_leaderboard_regenerate_leaderboards();

        }

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
                        __( 'GamiPress - LearnDash Group Leaderboard requires %s, %s and %s in order to work. Please install and activate them.', 'gamipress-learndash-group-leaderboard' ),
                        '<a href="https://wordpress.org/plugins/gamipress/" target="_blank">GamiPress</a>',
                        '<a href="https://gamipress.com/add-ons/gamipress-leaderboards/" target="_blank">GamiPress - Leaderboards</a>',
                        '<a href="https://www.learndash.com/" target="_blank">LearnDash</a>'

                    ); ?>
                </p>
            </div>

            <?php define( 'GAMIPRESS_ADMIN_NOTICES', true ); ?>

        <?php endif; ?>

        <?php if ( class_exists( 'GamiPress_Leaderboards' ) && defined( 'GAMIPRESS_LEADERBOARDS_VER' )
            && version_compare( GAMIPRESS_LEADERBOARDS_VER, GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_LEADERBOARDS_MIN_VER, '<' ) ) : ?>

            <div id="message" class="notice notice-error is-dismissible">
                <p>
                    <?php printf(
                        __( 'GamiPress - LearnDash Group Leaderboard requires %1$s <strong>%2$s</strong> or higher in order to work. Please update %1$s.', 'gamipress-learndash-group-leaderboard' ),
                        '<a href="https://gamipress.com/add-ons/gamipress-leaderboards/" target="_blank">GamiPress - Leaderboards</a>',
                        GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_LEADERBOARDS_MIN_VER
                    ); ?>
                </p>
            </div>

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

        if ( ! class_exists( 'GamiPress' ) ) {
            return false;
        }

        if ( ! class_exists( 'GamiPress_Leaderboards' ) ) {
            return false;
        }

        if( ! defined( 'GAMIPRESS_LEADERBOARDS_VER' ) ) {
            return false;
        }

        if( version_compare( GAMIPRESS_LEADERBOARDS_VER, GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_LEADERBOARDS_MIN_VER, '<' ) ) {
            return false;
        }

        // Multisite feature requires GamiPress 1.4.8
        if( is_multisite() && gamipress_is_network_wide_active() && is_main_site() ) {

            // On main site, need to check if integrated plugin is installed on any sub site to load all configuration files
            if( gamipress_is_plugin_active_on_network( 'sfwd-lms/sfwd_lms.php' ) ) {
                return true;
            }

        }

        if ( ! class_exists( 'SFWD_LMS' ) ) {
            return false;
        }

        return true;

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
        $lang_dir = GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_DIR . '/languages/';
        $lang_dir = apply_filters( 'gamipress_learndash_group_leaderboard_languages_directory', $lang_dir );

        // Traditional WordPress plugin locale filter
        $locale = apply_filters( 'plugin_locale', get_locale(), 'gamipress-learndash-group-leaderboard' );
        $mofile = sprintf( '%1$s-%2$s.mo', 'gamipress-learndash-group-leaderboard', $locale );

        // Setup paths to current locale file
        $mofile_local   = $lang_dir . $mofile;
        $mofile_global  = WP_LANG_DIR . '/gamipress-learndash-group-leaderboard/' . $mofile;

        if( file_exists( $mofile_global ) ) {
            // Look in global /wp-content/languages/gamipress-learndash-group-leaderboard/ folder
            load_textdomain( 'gamipress-learndash-group-leaderboard', $mofile_global );
        } elseif( file_exists( $mofile_local ) ) {
            // Look in local /wp-content/plugins/gamipress-learndash-group-leaderboard/languages/ folder
            load_textdomain( 'gamipress-learndash-group-leaderboard', $mofile_local );
        } else {
            // Load the default language files
            load_plugin_textdomain( 'gamipress-learndash-group-leaderboard', false, $lang_dir );
        }

    }

}

/**
 * The main function responsible for returning the one true GamiPress_LearnDash_Group_Leaderboard instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \GamiPress_LearnDash_Group_Leaderboard The one true GamiPress_LearnDash_Group_Leaderboard
 */
function GamiPress_LearnDash_Group_Leaderboard() {
    return GamiPress_LearnDash_Group_Leaderboard::instance();
}
add_action( 'plugins_loaded', 'GamiPress_LearnDash_Group_Leaderboard', 11 );

// Setup our activation and deactivation hooks
register_activation_hook( __FILE__, array( 'GamiPress_LearnDash_Group_Leaderboard', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'GamiPress_LearnDash_Group_Leaderboard', 'deactivate' ) );
