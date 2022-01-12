<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://ays-pro.com
 * @since      1.0.0
 *
 * @package    Personal_Dictionary
 * @subpackage Personal_Dictionary/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Personal_Dictionary
 * @subpackage Personal_Dictionary/includes
 * @author     Personal Dictionary Team <info@ays-pro.com>
 */
class Personal_Dictionary {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Personal_Dictionary_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PERSONAL_DICTIONARY_VERSION' ) ) {
			$this->version = PERSONAL_DICTIONARY_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'personal-dictionary';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Personal_Dictionary_Loader. Orchestrates the hooks of the plugin.
	 * - Personal_Dictionary_i18n. Defines internationalization functionality.
	 * - Personal_Dictionary_Admin. Defines all hooks for the admin area.
	 * - Personal_Dictionary_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-personal-dictionary-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-personal-dictionary-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-personal-dictionary-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-personal-dictionary-public.php';

		// Dictionary action page
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/dictionaries/actions/personal-dictionary-dictionaries-action-options.php';
		// Setting actions page
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/settings/personal-dictionary-settings-actions.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/reports/personal-dictionary-reports-actions.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/reports/personal-dictionary-reports-actions.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-personal-dictionary-data.php';

		$this->loader = new Personal_Dictionary_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Personal_Dictionary_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Personal_Dictionary_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Personal_Dictionary_Admin( $this->get_plugin_name(), $this->get_version() );
		
		$this->loader->add_action( 'admin_head', $plugin_admin, 'admin_menu_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Add menu item
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_pd_submenu' , 90 );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_pd_reports_submenu' , 95 );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_pd_leaderboard_submenu' , 100 );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_pd_settings_submenu' , 105 );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_pd_our_products_submenu' , 110 );
//        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_pd_our_pro_features_submenu' , 115 );

        //Code Mirror
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'codemirror_enqueue_scripts');

		// Deactivate plugin AJAX action
        $this->loader->add_action( 'wp_ajax_deactivate_plugin_option_sm', $plugin_admin, 'deactivate_plugin_option' );
        $this->loader->add_action( 'wp_ajax_nopriv_deactivate_plugin_option_sm', $plugin_admin, 'deactivate_plugin_option' );


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Personal_Dictionary_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Public Ajax
		$this->loader->add_action( 'wp_ajax_ays_pd_ajax', $plugin_public, 'ays_pd_ajax' );
		$this->loader->add_action( 'wp_ajax_nopriv_ays_pd_ajax', $plugin_public, 'ays_pd_ajax' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Personal_Dictionary_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
