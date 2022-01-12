<?php
/**
 * Bootstrapper for the plugin.
 *
 * Makes sure everything is good to go for loading the plugin, and then loads it.
 *
 * @since 1.2.0
 */

defined( 'ABSPATH' ) || die;

/**
 * Class LearnDash_Gradebook_Bootstrapper
 *
 * Bootstrapper for the plugin.
 *
 * Makes sure everything is good to go for loading the plugin, and then loads it.
 *
 * @since 1.2.0
 */
class LearnDash_Gradebook_Bootstrapper {

	/**
	 * Notices to show if cannot load.
	 *
	 * @since 1.2.0
	 * @access private
	 *
	 * @var array
	 */
	private $notices = array();

	/**
	 * LearnDash_Gradebook_Bootstrapper constructor.
	 *
	 * @since 1.2.0
	 */
	function __construct() {

		add_action( 'plugins_loaded', array( $this, 'maybe_load' ), 1 );
	}

	/**
	 * Maybe loads the plugin.
	 *
	 * @since 1.2.0
	 * @access private
	 */
	function maybe_load() {

		$php_version = phpversion();
		$wp_version  = get_bloginfo( 'version' );

		// Minimum PHP version
		if ( version_compare( $php_version, '5.3.0' ) === - 1 ) {

			$this->notices[] = sprintf(
				__( 'Minimum PHP version of 5.3.0 required. Current version is %s. Please contact your system administrator to upgrade PHP to its latest version.', 'learndash-gradebook' ),
				$php_version
			);
		}

		// Minimum WordPress version
		if ( version_compare( $wp_version, '4.8.0' ) === - 1 ) {

			$this->notices[] = sprintf(
				__( 'Minimum WordPress version of 4.8.0 required. Current version is %s. Please contact your system administrator to upgrade WordPress to its latest version.', 'learndash-gradebook' ),
				$wp_version
			);
		}

		// LearnDash Activated
		if ( ! defined( 'LEARNDASH_VERSION' ) ) {

			$this->notices[] = __( 'LearnDash LMS must be installed and activated.', 'learndash-gradebook' );
		}
		
		// LearndDash at version
		if ( defined( 'LEARNDASH_VERSION' ) ) {
			
			// Pad in a Patch version if necessary
			$ld_version = ( substr_count( LEARNDASH_VERSION, '.' ) == 1 ) ? LEARNDASH_VERSION . '.0' : LEARNDASH_VERSION;
			
			if ( version_compare( $ld_version, '3.4.0' ) === -1 ) {

				$this->notices[] = sprintf(
					__( 'LearnDash LMS must be at least version 3.4.0. Current version is %s.', 'learndash-gradebook' ),
					$ld_version
				);
				
			}
			
		}

		// Don't load and show errors if incompatible environment.
		if ( ! empty( $this->notices ) ) {

			add_action( 'admin_notices', array( $this, 'notices' ) );

			return;
		}

		$this->load();
	}

	/**
	 * Loads the plugin.
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function load() {

		add_filter( 'default_option_ld_gb_gradebook_non_group_leaders_show_only_group_users', array( $this, 'force_enable_non_group_leaders_show_only_group_users' ), 10, 2 );
		add_filter( 'option_ld_gb_gradebook_non_group_leaders_show_only_group_users', array( $this, 'force_enable_non_group_leaders_show_only_group_users' ), 10, 2 );

		add_filter( 'default_option_ld_gb_gradebook_disable_sorting_by_grades_backend', array( $this, 'force_disable_sorting_by_grades_backend' ), 10, 2 );
		add_filter( 'option_ld_gb_gradebook_disable_sorting_by_grades_backend', array( $this, 'force_disable_sorting_by_grades_backend' ), 10, 2 );

		LearnDash_Gradebook();

	}

	/**
	 * If the Constant is enabled to have non-Group Leaders only show their own Group Users within the Gradebook, force any reads to that option to show that it is enabled
	 *
	 * @param   string  $value   Value of the Option
	 * @param   string  $option  Name of the Option
	 *
	 * @access	public
	 * @since	{{VERSION}}
	 * @return  string           Value of the Option
	 */
	public function force_enable_non_group_leaders_show_only_group_users( $value, $option ) {

		if ( ! defined( 'LD_GB_NON_GROUP_LEADERS_ONLY_OWN_GROUP_USERS' ) || ! LD_GB_NON_GROUP_LEADERS_ONLY_OWN_GROUP_USERS ) return $value;

		return 'yes';

	}

	/**
	 * If the Constant is enabled to disable sorting by grades in the backend, force any reads to that option to show that it is enabled
	 *
	 * @param   string  $value   Value of the Option
	 * @param   string  $option  Name of the Option
	 *
	 * @access	public
	 * @since	{{VERSION}}
	 * @return  string           Value of the Option
	 */
	public function force_disable_sorting_by_grades_backend( $value, $option ) {

		// Fallback for before migration runs. This way we ensure that the dashboard definitely loads if they have this setting enabled
		// This fallback will be removed on the next major update
		if ( get_option( 'ld_gb_gradebook_safe_mode' ) ) return 'yes';

		if ( ! defined( 'LD_GB_DISABLE_SORTING_BY_GRADES_BACKEND' ) || ! LD_GB_DISABLE_SORTING_BY_GRADES_BACKEND ) return $value;

		return 'yes';

	}

	/**
	 * Shows notices on failure to load.
	 *
	 * @since 1.2.0
	 * @access private
	 */
	function notices() {
		?>
        <div class="notice error">
            <p>
				<?php
				printf(
					__( '%sLearnDash - Gradebook%s could not load because of the following errors:', 'learndash-gradebook' ),
					'<strong>',
					'</strong>'
				);
				?>
            </p>

            <ul>
				<?php foreach ( $this->notices as $notice ) : ?>
                    <li>
						&bull;&nbsp;<?php echo $notice; ?>
                    </li>
				<?php endforeach; ?>
            </ul>
        </div>
		<?php
	}
}