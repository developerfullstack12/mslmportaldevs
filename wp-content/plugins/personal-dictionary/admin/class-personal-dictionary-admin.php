<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ays-pro.com
 * @since      1.0.0
 *
 * @package    Personal_Dictionary
 * @subpackage Personal_Dictionary/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Personal_Dictionary
 * @subpackage Personal_Dictionary/admin
 * @author     Personal Dictionary Team <info@ays-pro.com>
 */
class Personal_Dictionary_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	  public function admin_menu_styles(){
        
        echo "<style>
            
            #adminmenu a.toplevel_page_personal-dictionary div.wp-menu-image img {
                width: 32px;
                padding: 1px 0 0;
                transition: .3s ease-in-out;
            }
        </style>";

    }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook_suffix) {
        
        if (false !== strpos($hook_suffix, "plugins.php")){
            wp_enqueue_style( $this->plugin_name . '-sweetalert-css', PERSONAL_DICTIONARY_PUBLIC_URL . '/css/personal-dictionary-sweetalert2.min.css', array(), $this->version, 'all');
        }

		if (false === strpos($hook_suffix, $this->plugin_name))
            return;
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Personal_Dictionary_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Personal_Dictionary_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name . '-bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/personal-dictionary-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-data-bootstrap', plugin_dir_url(__FILE__) . 'css/dataTables.bootstrap4.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . '-font-awesome', plugin_dir_url(__FILE__) . '/css/personal-dictionary-font-awesome.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . '-fonts', plugin_dir_url(__FILE__) . '/css/personal-dictionary-fonts.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook_suffix) {

		if (false !== strpos($hook_suffix, "plugins.php")){
            wp_enqueue_script( $this->plugin_name . '-sweetalert-js', PERSONAL_DICTIONARY_PUBLIC_URL . '/js/personal-dictionary-sweetalert2.all.min.js', array('jquery'), $this->version, true );
            wp_enqueue_script( $this->plugin_name . '-admin', plugin_dir_url(__FILE__) . 'js/admin.js', array( 'jquery' ), $this->version, true );
            wp_localize_script( $this->plugin_name . '-admin', 'PersonalDictionaryAdmin', array( 
            	'ajaxUrl' => admin_url( 'admin-ajax.php' )
            ) );
        }

		if (false === strpos($hook_suffix, $this->plugin_name))
            return;

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Personal_Dictionary_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Personal_Dictionary_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script('jquery');
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script( $this->plugin_name . '-wp-color-picker-alpha', plugin_dir_url(__FILE__) . 'js/wp-color-picker-alpha.min.js', array('wp-color-picker'), $this->version, true);
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/personal-dictionary-admin.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-datatable-min', PERSONAL_DICTIONARY_PUBLIC_URL . '/js/personal-dictionary-datatable.min.js', array('jquery'), $this->version, true);
		wp_enqueue_script( $this->plugin_name . '-pd-popper', plugin_dir_url(__FILE__) . 'js/popper.min.js', array('jquery'), $this->version, true);
		wp_enqueue_script( $this->plugin_name."-pd-bootstrap", plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-charts-google', plugin_dir_url(__FILE__) . 'js/google-chart.js', array('jquery'), $this->version, true);
		wp_enqueue_script( $this->plugin_name . "-db4.min.js", plugin_dir_url( __FILE__ ) . 'js/dataTables.bootstrap4.min.js', array( 'jquery' ), $this->version, true );

		$color_picker_strings = array(
			'clear'            => __( 'Clear', $this->plugin_name ),
			'clearAriaLabel'   => __( 'Clear color', $this->plugin_name ),
			'defaultString'    => __( 'Default', $this->plugin_name ),
			'defaultAriaLabel' => __( 'Select default color', $this->plugin_name ),
			'pick'             => __( 'Select Color', $this->plugin_name ),
			'defaultLabel'     => __( 'Color value', $this->plugin_name ),
		);
		wp_localize_script( $this->plugin_name . '-wp-color-picker-alpha', 'wpColorPickerL10n', $color_picker_strings );

	}

	public function codemirror_enqueue_scripts($hook) {
        if(strpos($hook, $this->plugin_name) !== false){
            if(function_exists('wp_enqueue_code_editor')){
                $cm_settings['codeEditor'] = wp_enqueue_code_editor(array(
                    'type' => 'text/css',
                    'codemirror' => array(
                        'inputStyle' => 'contenteditable',
                        'theme' => 'cobalt',
                    )
                ));

                wp_enqueue_script('wp-theme-plugin-editor');
                wp_localize_script('wp-theme-plugin-editor', 'cm_settings', $cm_settings);

                wp_enqueue_style('wp-codemirror');
            }
        }
    }


	//==== ADD MENU ====
	// Main Menu
	public function add_plugin_admin_menu(){

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */
        add_menu_page(
            __('Dictionary', $this->plugin_name),
            __('Dictionary', $this->plugin_name),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_pd_main_page'),
            PERSONAL_DICTIONARY_ADMIN_URL . '/images/icons/logo-admin-32x32.png',
            6
        );
    }
	// Main submenu
	public function add_plugin_pd_submenu(){
        add_submenu_page(
            $this->plugin_name,
            __('Home', $this->plugin_name),
            __('Home', $this->plugin_name),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_pd_main_page')
        );
    }
	// Reports submenu
	public function add_plugin_pd_reports_submenu(){
        add_submenu_page(
            $this->plugin_name,
            __('Reports', $this->plugin_name),
            __('Reports', $this->plugin_name),
            'manage_options',
            $this->plugin_name."-dictionary-reports",
            array($this, 'display_plugin_pd_reports_page')
        );
    }
    
	// Leaderboard submenu
	public function add_plugin_pd_leaderboard_submenu(){
		add_submenu_page(
			$this->plugin_name,
			__('Leaderboard', $this->plugin_name),
			__('Leaderboard', $this->plugin_name),
			'manage_options',
			$this->plugin_name."-dictionary-leaderboard",
			array($this, 'display_plugin_pd_leaderboard_page')
		);
	}

	// Settings submenu
	public function add_plugin_pd_settings_submenu(){
        add_submenu_page(
            $this->plugin_name,
            __('Settings', $this->plugin_name),
            __('Settings', $this->plugin_name),
            'manage_options',
            $this->plugin_name."-dictionary-settings",
            array($this, 'display_plugin_pd_settings_page')
        );
    }
	// Our products submenu
	public function add_plugin_pd_our_products_submenu(){
        add_submenu_page(
            $this->plugin_name,
            __('Our products', $this->plugin_name),
            __('Our products', $this->plugin_name),
            'manage_options',
            $this->plugin_name."-our-products",
            array($this, 'display_plugin_pd_our_products_page')
        );
    }

	// PRO features submenu
	public function add_plugin_pd_our_pro_features_submenu(){
        add_submenu_page(
            $this->plugin_name,
            __('PRO features', $this->plugin_name),
            __('PRO features', $this->plugin_name),
            'manage_options',
            $this->plugin_name."-pro-features",
            array($this, 'display_plugin_pd_pro_features_page')
        );
    }

	//==== ADD PAGES ====
	// Main page
	public function display_plugin_pd_main_page(){
		include_once('partials/dictionaries/personal-dictionary-dictionaries-display.php');
    }
	// Reports page
	public function display_plugin_pd_reports_page(){        
		include_once('partials/reports/personal-dictionary-reports-display.php');
    }
	// Leaderboard page
	public function display_plugin_pd_leaderboard_page(){        
		include_once('partials/leaderboards/personal-dictionary-leaderboards-display.php');
    }
	// Settings page
	public function display_plugin_pd_settings_page(){
		include_once('partials/settings/personal-dictionary-settings-display.php');
    }
	// Our products page
	public function display_plugin_pd_our_products_page(){
		include_once('partials/features/personal-dictionary-products-display.php');
    }
	// PRO features page
	public function display_plugin_pd_pro_features_page(){
		include_once('partials/features/personal-dictionary-pro-features-display.php');

    }

	public function deactivate_plugin_option(){
        $request_value = $_REQUEST['upgrade_plugin'];
        $upgrade_option = get_option( 'ays_personal_dictionary_upgrade_plugin', '' );
        if($upgrade_option === ''){
            add_option( 'ays_personal_dictionary_upgrade_plugin', $request_value );
        }else{
            update_option( 'ays_personal_dictionary_upgrade_plugin', $request_value );
        }
        ob_end_clean();
        $ob_get_clean = ob_get_clean();
        echo json_encode( array( 'option' => get_option( 'ays_personal_dictionary_upgrade_plugin', '' ) ) );
        wp_die();
    }

}
