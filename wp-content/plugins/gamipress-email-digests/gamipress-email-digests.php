<?php
/**
 * Plugin Name:     GamiPress - Email Digests
 * Plugin URI:      https://gamipress.com/add-ons/gamipress-email-digests
 * Description:     Send email digests periodically to keep in touch with your users.
 * Version:         1.0.4
 * Author:          GamiPress
 * Author URI:      https://gamipress.com/
 * Text Domain:     gamipress-email-digests
 * License:         GNU AGPL v3.0 (http://www.gnu.org/licenses/agpl.txt)
 *
 * @package         GamiPress\Email_Digests
 * @author          GamiPress
 * @copyright       Copyright (c) GamiPress
 */

final class GamiPress_Email_Digests {

    /**
     * @var         GamiPress_Email_Digests $instance The one true GamiPress_Email_Digests
     * @since       1.0.0
     */
    private static $instance;

    /**
     * Get active instance
     *
     * @access      public
     * @since       1.0.0
     * @return      GamiPress_Email_Digests self::$instance The one true GamiPress_Email_Digests
     */
    public static function instance() {

        if( ! self::$instance ) {

            self::$instance = new GamiPress_Email_Digests();
            self::$instance->constants();
            self::$instance->libraries();
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
        define( 'GAMIPRESS_EMAIL_DIGESTS_VER', '1.0.4' );

        // GamiPress minimum required version
        define( 'GAMIPRESS_EMAIL_DIGESTS_GAMIPRESS_MIN_VER', '1.8.0' );

        // Plugin file
        define( 'GAMIPRESS_EMAIL_DIGESTS_FILE', __FILE__ );

        // Plugin path
        define( 'GAMIPRESS_EMAIL_DIGESTS_DIR', plugin_dir_path( __FILE__ ) );

        // Plugin URL
        define( 'GAMIPRESS_EMAIL_DIGESTS_URL', plugin_dir_url( __FILE__ ) );

    }

    /**
     * Include plugin libraries
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function libraries() {

        if( $this->meets_requirements() ) {

            require_once GAMIPRESS_EMAIL_DIGESTS_DIR . 'libraries/day-month-field-type.php';

        }
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

            require_once GAMIPRESS_EMAIL_DIGESTS_DIR . 'includes/admin.php';
            require_once GAMIPRESS_EMAIL_DIGESTS_DIR . 'includes/custom-tables.php';
            require_once GAMIPRESS_EMAIL_DIGESTS_DIR . 'includes/email-digests.php';
            require_once GAMIPRESS_EMAIL_DIGESTS_DIR . 'includes/functions.php';
            require_once GAMIPRESS_EMAIL_DIGESTS_DIR . 'includes/scripts.php';
            require_once GAMIPRESS_EMAIL_DIGESTS_DIR . 'includes/template-functions.php';

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

        GamiPress_Email_Digests::instance();

        // Setup the five minutes cron event to process events every 5 minutes (used on email sending)
        if ( ! wp_next_scheduled( 'gamipress_email_digests_five_minutes_cron' ) )
            wp_schedule_event( time(), 'five_minutes', 'gamipress_email_digests_five_minutes_cron' );

        // Setup the hourly cron event to process events hourly (used on email sending)
        if ( ! wp_next_scheduled( 'gamipress_email_digests_hourly_cron' ) )
            wp_schedule_event( time(), 'hourly', 'gamipress_email_digests_hourly_cron' );

        // Setup the daily cron event to process events daily (used to determine which email digest should be sent)
        if ( ! wp_next_scheduled( 'gamipress_email_digests_daily_cron' ) )
            wp_schedule_event( time(), 'daily', 'gamipress_email_digests_daily_cron' );

    }

    /**
     * Deactivation hook for the plugin.
     *
     * @since  1.0.0
     */
    public static function deactivate() {

        // Un-schedule cron jobs
        wp_clear_scheduled_hook( 'gamipress_email_digests_five_minutes_cron' );
        wp_clear_scheduled_hook( 'gamipress_email_digests_hourly_cron' );
        wp_clear_scheduled_hook( 'gamipress_email_digests_daily_cron' );

    }

    /**
     * Plugin admin notices.
     *
     * @since  1.0.0
     */
    public function admin_notices() {

        $current_screen = get_current_screen();

        $screens_to_notice = array(
            'gamipress_page_gamipress_email_digests',
            'admin_page_edit_gamipress_email_digests',

        );

        if ( ! $this->meets_requirements() && ! defined( 'GAMIPRESS_ADMIN_NOTICES' ) ) : ?>

            <div id="message" class="notice notice-error is-dismissible">
                <p>
                    <?php printf(
                        __( 'GamiPress - Email Digests requires %s (%s or higher) in order to work. Please install and activate it.', 'gamipress-email-digests' ),
                        '<a href="https://wordpress.org/plugins/gamipress/" target="_blank">GamiPress</a>',
                        GAMIPRESS_EMAIL_DIGESTS_GAMIPRESS_MIN_VER
                    ); ?>
                </p>
            </div>

            <?php define( 'GAMIPRESS_ADMIN_NOTICES', true ); ?>

        <?php elseif ( $current_screen !== null && in_array( $current_screen->id, $screens_to_notice ) && $this->meets_requirements() ) :
            // Get the emails digest to send
            $email_digests_to_send = get_option( 'gamipress_email_digests_to_send', array() );

            if( ! empty( $email_digests_to_send ) ) : ?>

                <div id="message" class="notice notice-info is-dismissible">
                    <p>
                        <?php printf(
                            __( 'GamiPress - Email Digests has %s email digests on the sending queue.', 'gamipress-email-digests' ),
                            count( $email_digests_to_send )
                        ); ?>
                    </p>

                    <?php
                    // Get the current email digest that is being sending
                    $email_digest_sending = get_option( 'gamipress_email_digest_sending', array() );

                    if( ! empty( $email_digest_sending ) ) :

                        ct_setup_table( 'gamipress_email_digests' );
                        $email_digest = ct_get_object( $email_digest_sending['email_digest_id'] );

                        if( $email_digest ) : ?>

                            <p>
                                <?php
                                printf(
                                    __( 'Actually sending the email digest %s.', 'gamipress-email-digests' ),
                                    '<a href="' . ct_get_edit_link( 'gamipress_email_digests', $email_digest->email_digest_id ) . '">' . $email_digest->title . '</a>'
                                );

                                if( $email_digest_sending['users_sent_count'] > 0 ) :
                                    printf(
                                        ' ' . __( 'Email was already sent to %s users.', 'gamipress-email-digests' ),
                                        $email_digest_sending['users_sent_count']
                                    );

                                    if( $email_digest_sending['users_count'] > 0 ) :
                                        printf(
                                            ' ' . __( 'Remaining %s users.', 'gamipress-email-digests' ),
                                            $email_digest_sending['users_count'] - $email_digest_sending['users_sent_count']
                                        );
                                    endif;

                                endif;



                                ?>


                            </p>

                        <?php endif; ?>

                    <?php ct_reset_setup_table(); ?>

                    <?php endif; ?>

                </div>


            <?php endif; ?>

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

        if ( class_exists( 'GamiPress' ) && version_compare( GAMIPRESS_VER, GAMIPRESS_EMAIL_DIGESTS_GAMIPRESS_MIN_VER, '>=' ) ) {
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
        $lang_dir = GAMIPRESS_EMAIL_DIGESTS_DIR . '/languages/';
        $lang_dir = apply_filters( 'gamipress_email_digests_languages_directory', $lang_dir );

        // Traditional WordPress plugin locale filter
        $locale = apply_filters( 'plugin_locale', get_locale(), 'gamipress-email-digests' );
        $mofile = sprintf( '%1$s-%2$s.mo', 'gamipress-email-digests', $locale );

        // Setup paths to current locale file
        $mofile_local   = $lang_dir . $mofile;
        $mofile_global  = WP_LANG_DIR . '/gamipress-email-digests/' . $mofile;

        if( file_exists( $mofile_global ) ) {
            // Look in global /wp-content/languages/gamipress/ folder
            load_textdomain( 'gamipress-email-digests', $mofile_global );
        } elseif( file_exists( $mofile_local ) ) {
            // Look in local /wp-content/plugins/gamipress/languages/ folder
            load_textdomain( 'gamipress-email-digests', $mofile_local );
        } else {
            // Load the default language files
            load_plugin_textdomain( 'gamipress-email-digests', false, $lang_dir );
        }

    }

}

/**
 * The main function responsible for returning the one true GamiPress_Email_Digests instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \GamiPress_Email_Digests The one true GamiPress_Email_Digests
 */
function GamiPress_Email_Digests() {
    return GamiPress_Email_Digests::instance();
}
add_action( 'plugins_loaded', 'GamiPress_Email_Digests' );

// Setup our activation and deactivation hooks
register_activation_hook( __FILE__, array( 'GamiPress_Email_Digests', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'GamiPress_Email_Digests', 'deactivate' ) );