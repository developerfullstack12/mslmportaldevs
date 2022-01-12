<?php
/**
 * Shortcode: Frontend Gradebook
 *
 * @since 2.0.0
 *
 * @package LearnDash_Gradebook
 * @subpackage LearnDash_Gradebook/includes/shortcodes
 */

defined( 'ABSPATH' ) || die();

/**
 * Class LD_GB_SC_FrontendGradebook
 *
 * Contains the grade for a given user.
 *
 * @since 2.0.0
 *
 * @package LearnDash_Gradebook
 * @subpackage LearnDash_Gradebook/includes/shortcodes
 */
class LD_GB_SC_FrontendGradebook extends LD_GB_Shortcode {

	/**
	 * Whether or not this shortcode was used.
	 *
	 * @since 2.0.0
	 *
	 * @var bool
	 */
	private $used = false;

	/**
	 * LD_GB_SC_FrontendGradebook constructor.
	 *
	 * @since 2.0.0
	 */
	function __construct() {

		parent::__construct( 'ld_gradebook', array(
            'gradebook' => false,
            'grade_format' => get_option( 'ld_gb_grade_display_mode', 'letter' ),
        ) );

        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        
        // Template actions

        add_action( 'ld_gb_frontend_gradebook_gradebook_dropdown', array( __CLASS__, 'gradebook_dropdown' ), 10, 2 );

        add_action( 'ld_gb_frontend_gradebook_group_dropdown', array( __CLASS__, 'group_dropdown' ), 10, 2 );

        add_action( 'ld_gb_frontend_gradebook_results', array( __CLASS__, 'gradebook_results' ), 10, 3 );

        add_action( 'ld_gb_frontend_gradebook_table_list', array( __CLASS__, 'gradebook_table_list' ), 10, 3 );

        add_action( 'ld_gb_frontend_gradebook_table_head', array( __CLASS__, 'gradebook_table_head' ), 10, 4 );

        add_action( 'ld_gb_frontend_gradebook_table_row', array( __CLASS__, 'gradebook_table_row' ), 10, 7 );

        add_action( 'ld_gb_frontend_gradebook_edit_panel', array( __CLASS__, 'edit_panel' ), 10, 4 );

        add_action( 'ld_gb_frontend_gradebook_edit_panel_back_to_gradebook', array( __CLASS__, 'back_to_gradebook' ), 10, 2 );

        add_action( 'lb_gb_frontend_gradebook_edit_panel_user_grade', array( __CLASS__, 'edit_panel_user_grade' ), 10, 4 );

        add_action( 'ld_gb_frontend_gradebook_edit_panel_components', array( __CLASS__, 'edit_panel_components' ), 10, 4 );

        add_action( 'ld_gb_frontend_gradebook_edit_panel_component', array( __CLASS__, 'edit_panel_component' ), 10, 5 );

        add_action( 'ld_gb_frontend_gradebook_edit_panel_component_grade', array( __CLASS__, 'edit_panel_component_grade' ), 10, 4 );

        add_action( 'ld_gb_frontend_gradebook_edit_panel_grade_row', array( __CLASS__, 'edit_panel_grade_row' ), 10, 6 );

        add_action( 'ld_gb_frontend_gradebook_edit_panel_no_grades', array( __CLASS__, 'edit_panel_no_grades' ), 10, 4 );

        add_action( 'ld_gb_frontend_gradebook_edit_panel_grade_add', array( __CLASS__, 'edit_panel_grade_add' ), 10, 5 );

        add_action( 'ld_gb_frontend_gradebook_edit_panel_grade_edit', array( __CLASS__, 'edit_panel_grade_edit' ), 10, 4 );

        add_action( 'ld_gb_frontend_gradebook_edit_panel_component_override', array( __CLASS__, 'edit_panel_component_override' ), 10, 4 );

        add_action( 'ld_gb_frontend_gradebook_export_buttons', array( __CLASS__, 'export_buttons' ), 10, 2 );

        add_action( 'ld_gb_frontend_gradebook_notice', array( __CLASS__, 'notice' ), 10, 2 );

	}

	/**
	 * Outputs the shortcode.
	 *
	 * @since 2.0.0
	 *
	 * @param array $atts
	 * @param string $content
	 *
	 * @return mixed
	 */
	function shortcode( $atts = array(), $content = '' ) {

        $this->default_atts( $atts );

        ob_start();

        // Allow the theme to load the template instead of the plugin
        ld_gb_locate_template( 'frontend-gradebook/frontend-gradebook.php', array(
            'gradebook_id' => $this->atts['gradebook'],
            'grade_format' => $this->atts['grade_format'],
        ) );

		return ob_get_clean();
    }

    /**
	 * Loads report card assets.
	 *
     * @access  public
	 * @since   2.0.0
     * @return  void
	 */
	public function enqueue_assets() {

        global $post;

        if ( ! is_object( $post ) ) {
            return;
        }

        // This should not be necessary to filter in 99.999% of cases
        // If you have a Shortcode that is being used as a wrapper for [ld_gradebook] then Filter this to add your Shortcode
        $shortcodes = apply_filters( 'ld_gb_frontend_gradebook_load_assets_check', array( 'ld_gradebook' ) );

        $found = false;

        foreach ( $shortcodes as $shortcode ) {
    
            if ( has_shortcode( $post->post_content, $shortcode ) ) {
                $found = true;
                break;
            }

        }

        if ( ! $found ) return;

        // If you need to make your script run _before_ Gradebook's, filter the Script/Style dependencies
        wp_enqueue_style( 'ld-gb-frontend-gradebook' );
        wp_enqueue_script( 'ld-gb-frontend-gradebook' );

        // If you need to make your script run _after_ Gradebook's, use this hook and set LD GB's Frontend Script/Style as your dependency
        do_action( 'ld_gb_frontend_gradebook_assets_enqueued' );
        
	}

    /**
     * Outputs the Gradebook Dropdown
     *
     * @param   array    $gradebook_ids  Array of Gradebook IDs
     * @param   integer  $gradebook_id   Gradebook to select by default
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function gradebook_dropdown( $gradebook_ids, $gradebook_id ) {

        ld_gb_locate_template( 'frontend-gradebook/gradebook-dropdown.php', array(
            'gradebook_ids' => $gradebook_ids,
            'gradebook_id' => $gradebook_id,
        ) );

    }
    
    /**
     * Outputs the Group Dropdown
     *
     * @param   array    $group_ids  Array of Group IDs
     * @param   integer  $group_id   Group to select by default
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function group_dropdown( $group_ids, $group_id ) {

        if ( empty( $group_ids ) ) {

            ld_gb_locate_template( 'frontend-gradebook/errors/no-groups.php', array(
            ) );

        }
        else {

            ld_gb_locate_template( 'frontend-gradebook/group-dropdown.php', array(
                'group_ids' => $group_ids,
                'group_id' => $group_id,
            ) );

        }

    }

    /**
     * Loads the Gradebook Results
     * This is used for both the default loaded Gradebook/Group Combo as well as when refreshed via the API
     *
     * @param   integer  $gradebook_id  Gradebook ID
     * @param   integer  $group_id      Group ID
     * @param   string   $grade_format  Grade Display Format
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function gradebook_results( $gradebook_id, $group_id, $grade_format ) {

        ld_gb_locate_template( 'frontend-gradebook/gradebook-results.php', array(
            'gradebook_id' => $gradebook_id,
            'group_id' => $group_id,
            'grade_format' => $grade_format,
        ) );

    }

    /**
     * Outputs the Gradebook Table
     *
     * @param   integer  $gradebook_id  Gradebook ID
     * @param   integer  $group_id      Group ID
     * @param   integer  $grade_format  Grade Display Format
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function gradebook_table_list( $gradebook_id, $group_id, $grade_format ) {

        ld_gb_locate_template( 'frontend-gradebook/table/table-list.php', array(
            'gradebook_id' => $gradebook_id,
            'group_id' => $group_id,
            'grade_format' => $grade_format,
        ) );

    }

    /**
     * Outputs the Table Headers
     *
     * @param   array    $user_columns  User-defined Columns
     * @param   array    $components    Array of Component Keys and Names
     * @param   integer  $gradebook_id  Gradebook ID
     * @param   integer  $group_id      Group ID
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function gradebook_table_head( $user_columns, $components, $gradebook_id, $group_id ) {

        ld_gb_locate_template( 'frontend-gradebook/table/table-head.php', array(
            'user_columns' => $user_columns,
            'components' => $components,
            'gradebook_id' => $gradebook_id,
            'group_id' => $group_id,
        ) );

    }

    /**
     * Outputs a Table Row
     *
     * @param   integer  $user_id       WP_User ID
     * @param   array    $user_columns  User-defined Columns
     * @param   array    $user_grade    User Grade
     * @param   string   $grade_format  Grade Display Format
     * @param   array    $components    Array of Component Keys and Names
     * @param   integer  $gradebook_id  Gradebook ID
     * @param   integer  $group_id      Group ID
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function gradebook_table_row( $user_id, $user_columns, $user_grade, $grade_format, $components, $gradebook_id, $group_id ) {

        ld_gb_locate_template( 'frontend-gradebook/table/table-row.php', array(
            'user_id' => $user_id,
            'user_columns' => $user_columns,
            'user_grade' => $user_grade,
            'grade_format' => $grade_format,
            'components' => $components,
            'gradebook_id' => $gradebook_id,
            'group_id' => $group_id,
        ) );
        
    }

    /**
     * Outputs the Edit Panel
     *
     * @param   integer  $user_id       User ID
     * @param   integer  $gradebook_id  Gradebook ID
     * @param   integer  $group_id      Group ID
     * @param   string   $grade_format  Grade Display Format
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function edit_panel( $user_id, $gradebook_id, $group_id, $grade_format ) {

        ld_gb_locate_template( 'frontend-gradebook/edit-panel/edit-panel.php', array(
            'user_id' => $user_id,
            'gradebook_id' => $gradebook_id,
            'group_id' => $group_id,
            'grade_format' => $grade_format,
        ) );

    }

    /**
     * Outputs the Back to Gradebook button
     *
     * @param   integer  $user_id       User ID
     * @param   integer  $gradebook_id  Gradebook ID
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function back_to_gradebook( $user_id, $gradebook_id ) {

        ld_gb_locate_template( 'frontend-gradebook/edit-panel/edit-panel-back-to-gradebook.php', array(
            'user_id' => $user_id,
            'gradebook_id' => $gradebook_id,
        ) );

    }

    /**
     * Outputs the Edit Panel User Grade
     *
     * @param   integer  $user_id       User ID
     * @param   integer  $gradebook_id  Gradebook ID
     * @param   object   $user_grade    LD_GB_UserGrade Object
     * @param   string   $grade_format  Grade Display Format
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function edit_panel_user_grade( $user_id, $gradebook_id, $user_grade, $grade_format ) {

        ld_gb_locate_template( 'frontend-gradebook/edit-panel/edit-panel-user-grade.php', array(
            'user_id' => $user_id,
            'gradebook_id' => $gradebook_id,
            'user_grade' => $user_grade,
            'grade_format' => $grade_format,
        ) );

    }

    /**
     * Outputs the Edit Panel Components List
     *
     * @param   integer  $user_id       User ID
     * @param   integer  $gradebook_id  Gradebook ID
     * @param   object   $user_grade    LD_GB_UserGrade Object
     * @param   string   $grade_format  Grade Display Format
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function edit_panel_components( $user_id, $gradebook_id, $user_grade, $grade_format ) {

        ld_gb_locate_template( 'frontend-gradebook/edit-panel/components/edit-panel-components.php', array(
            'user_id' => $user_id,
            'gradebook_id' => $gradebook_id,
            'user_grade' => $user_grade,
            'grade_format' => $grade_format,
        ) );

    }

    /**
     * Outputs the Edit Panel Component
     *
     * @param   integer  $user_id       User ID
     * @param   integer  $gradebook_id  Gradebook ID
     * @param   object   $user_grade    LD_GB_UserGrade Object
     * @param   array    $component     Component Array
     * @param   string   $grade_format  Grade Display Format
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function edit_panel_component( $user_id, $gradebook_id, $user_grade, $component, $grade_format ) {

        ld_gb_locate_template( 'frontend-gradebook/edit-panel/components/edit-panel-component.php', array(
            'user_id' => $user_id,
            'gradebook_id' => $gradebook_id,
            'user_grade' => $user_grade,
            'component' => $component,
            'grade_format' => $grade_format,
        ) );

    }

    /**
     * Outputs the Edit Panel Component Grade
     *
     * @param   array    $component     Component Array
     * @param   string   $grade_format  Grade Display Format
     * @param   integer  $user_id       User ID
     * @param   integer  $gradebook_id  Gradebook ID
     * 
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function edit_panel_component_grade( $component, $grade_format, $user_id, $gradebook_id ) {

        ld_gb_locate_template( 'frontend-gradebook/edit-panel/components/edit-panel-component-grade.php', array(
            'component' => $component,
            'grade_format' => $grade_format,
            'user_id' => $user_id,
            'gradebook_id' => $gradebook_id,
        ) );

    }

    /**
     * Outputs the Edit Panel Grade Row
     *
     * @param   array    $grade         Grade Array
     * @param   object   $user_grade    LD_GB_UserGrade Object
     * @param   array    $component     Component Array
     * @param   integer  $user_id       User ID
     * @param   integer  $gradebook_id  Gradebook ID
     * @param   string   $grade_format  Grade Display Format
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function edit_panel_grade_row( $grade, $user_grade, $component, $user_id, $gradebook_id, $grade_format ) {

        ld_gb_locate_template( 'frontend-gradebook/edit-panel/components/edit-panel-grade-row.php', array(
            'grade' => $grade,
            'user_grade' => $user_grade,
            'component' => $component,
            'user_id' => $user_id,
            'gradebook_id' => $gradebook_id,
            'grade_format' => $grade_format,
        ) );

    }

    /**
     * Outputs the Edit Panel "No Grades" Row
     *
     * @param   object   $user_grade    LD_GB_UserGrade Object
     * @param   array    $component     Component Array
     * @param   integer  $user_id       User ID
     * @param   integer  $gradebook_id  Grade Display Format
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function edit_panel_no_grades( $user_grade, $component, $user_id, $gradebook_id ) {

        ld_gb_locate_template( 'frontend-gradebook/edit-panel/components/edit-panel-no-grades.php', array(
            'user_grade' => $user_grade,
            'component' => $component,
            'user_id' => $user_id,
            'gradebook_id' => $gradebook_id,
        ) );

    }

    /**
     * Outputs the Edit Panel Grade Add Form
     *
     * @param   integer  $user_id       User ID
     * @param   integer  $gradebook_id  Gradebook ID
     * @param   integer  $component     Component Array
     * @param   integer  $user_grade    LD_GB_UserGrade Object
     * @param   integer  $grade_format  Grade Display Format
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function edit_panel_grade_add( $user_id, $gradebook_id, $component, $user_grade, $grade_format ) {

        ld_gb_locate_template( 'frontend-gradebook/edit-panel/components/edit-panel-grade-add.php', array(
            'user_id' => $user_id,
            'gradebook_id' => $gradebook_id,
            'component' => $component,
            'user_grade' => $user_grade,
            'grade_format' => $grade_format,
        ) );

    }

    /**
     * Outputs the Edit Panel Grade Edit Form
     *
     * @param   integer  $user_id       User ID
     * @param   integer  $gradebook_id  Gradebook ID
     * @param   integer  $component     Component Array
     * @param   integer  $grade_format  Grade Display Format
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function edit_panel_grade_edit( $user_id, $gradebook_id, $component, $grade_format ) {

        ld_gb_locate_template( 'frontend-gradebook/edit-panel/components/edit-panel-grade-edit.php', array(
            'user_id' => $user_id,
            'gradebook_id' => $gradebook_id,
            'component' => $component,
            'grade_format' => $grade_format,
        ) );

    }

    /**
     * Outputs the Edit Panel Component Override Form
     *
     * @param   integer  $component     Component Array
     * @param   integer  $grade_format  Grade Display Format
     * @param   integer  $user_id       User ID
     * @param   integer  $gradebook_id  Gradebook ID
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function edit_panel_component_override( $component, $grade_format, $user_id, $gradebook_id ) {

        ld_gb_locate_template( 'frontend-gradebook/edit-panel/components/edit-panel-component-override.php', array(
            'component' => $component,
            'grade_format' => $grade_format,
            'user_id' => $user_id,
            'gradebook_id' => $gradebook_id,
        ) );

    }

    /**
     * Outpus the Gradebook Export Buttons
     *
     * @param   integer  $gradebook_id  Gradebook ID
     * @param   integer  $group_id      Group ID
     *
     * @access  public
     * @since   2.0.0
     * @return  void
     */
    public static function export_buttons( $gradebook_id, $group_id ) {

        ld_gb_locate_template( 'frontend-gradebook/export-buttons.php', array(
            'gradebook_id' => $gradebook_id,
            'group_id' => $group_id,
        ) );

    }

    /**
     * Ouputs the Error Notice. Can be used for Success Messages too by changing the Type to "success"
     *
     * @param   string $message  Message Text
     * @param   string $type     Notice Type
     *
     * @access  public 
     * @since   2.0.0
     * @return  string           HTML
     */
    public static function notice( $message, $type = 'alert' ) {

        ld_gb_locate_template( 'frontend-gradebook/errors/dialog.php', array(
            'message' => $message,
            'type' => $type,
        ) );

    }
    
}