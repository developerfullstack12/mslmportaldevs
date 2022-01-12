<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ays-pro.com
 * @since      1.0.0
 *
 * @package    Personal_Dictionary
 * @subpackage Personal_Dictionary/public
 */
use PhpOffice\PhpSpreadsheet\IOFactory;
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Personal_Dictionary
 * @subpackage Personal_Dictionary/public
 * @author     Personal Dictionary Team <info@ays-pro.com>
 */
class Personal_Dictionary_Public {

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

	private $html_class_prefix = 'ays-pd-';
	private $html_name_prefix = 'ays-pd-';
	private $name_prefix = 'pd_';
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_shortcode('ayspd_userpage', array($this, 'ays_generate_pd_method'));
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/personal-dictionary-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-select2', plugin_dir_url(__FILE__) . 'css/select2.min.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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
		wp_enqueue_script("jquery");
		wp_enqueue_script("jquery-effects-core");
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/personal-dictionary-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-plugin', plugin_dir_url( __FILE__ ) . 'js/personal-dictionary-public-plugin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-select2', plugin_dir_url(__FILE__) . 'js/select2.min.js', array('jquery'), $this->version, true);
        wp_localize_script( $this->plugin_name, 'aysPersonalDictionaryAjaxPublic', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
			'icons' => array(
				'close_icon' 	=> '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>',
				'edit_icon' 	=> '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>',
				'delete_icon' 	=> '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>',
				'back_icon' 	=> '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>',
				'more_icon' 	=> '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>',
			),
        ) );

		wp_localize_script( $this->plugin_name, 'aysPdLangObj', array(
            'save'      			=> __( 'Save', $this->plugin_name ),
            'saveAndClose'          => __( 'Save and close', $this->plugin_name ),
            'settingsMessage'       => __( 'Game words must be over than 4', $this->plugin_name ),
            'all'       			=> __( 'All', $this->plugin_name ),
            'result'       			=> __( 'Result', $this->plugin_name ),
            'groups'       			=> __( 'Groups', $this->plugin_name ),
            'games'     			=> __( 'Games', $this->plugin_name ),
            'reset'           		=> __( 'Reset', $this->plugin_name ),
            'delete'       			=> __( 'Delete', $this->plugin_name ),
            'word'       			=> __( 'Word', $this->plugin_name ),
            'translation'       	=> __( 'Translation', $this->plugin_name ),
            'createFirstGroup'      => __( 'Create your first Group', $this->plugin_name ),
            'createFirstWord'       => __( 'Add your words', $this->plugin_name ),
        ) );
	}

	public function ays_pd_ajax(){
		global $wpdb;

		$response = array(
			"status" => false
		);
		$function = isset($_REQUEST['function']) ? sanitize_text_field( $_REQUEST['function'] ) : null;

		if($function !== null){

			$response = array();
			if( is_callable( array( $this, $function ) ) ){
				$results = $this->$function();
				$response = array(
					"status" => true,
					"results" => $results,
				);
	            ob_end_clean();
	            $ob_get_clean = ob_get_clean();
				echo json_encode( $response );
				wp_die();
			}
			/*
			switch ($function ) {
				case 'ays_groups_pd':
					$results = $this->ays_groups_pd();
				break;
				case 'ays_groups_add_ajax':
					$results = $this->ays_groups_add_ajax();
				break;
				case 'ays_show_words_ajax':
					$results = $this->ays_show_words_ajax();
				break;
				case 'ays_words_add_ajax':
					$results = $this->ays_words_add_ajax();
				break;
				case 'ays_groups_delete_ajax':
					$results = $this->ays_groups_delete_ajax();
				break;
				case 'ays_group_reset_ajax':
					$results = $this->ays_group_reset_ajax();
				break;
				case 'ays_words_delete_ajax':
					$results = $this->ays_words_delete_ajax();
				break;
				case 'ays_word_reset_ajax':
					$results = $this->ays_word_reset_ajax();
				break;
				case 'ays_games_pd':
					$results = $this->ays_games_pd();
				break;
				case 'ays_pd_game_find_word':
					$results = $this->ays_pd_game_find_word();
				break;
				case 'ays_pd_game_find_translation':
					$results = $this->ays_pd_game_find_translation();
				break;
				case 'ays_pd_add_game_results':
					$results = $this->ays_pd_add_game_results();
				break;
				case 'ays_pd_update_word':
					$results = $this->ays_pd_update_word();
				break;
				default:
					$results = $this->ays_groups_pd();
				break;
			}*/
		}


        ob_end_clean();
        $ob_get_clean = ob_get_clean();
		echo json_encode( $response );
		wp_die();
	}

	public function ays_groups_add_ajax(){
		global $wpdb;
		$categories_table 	= esc_sql( $wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'categories' );
		$settings_table 	= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'settings');
		$user_id			= get_current_user_id();
		$group_name 		= (isset($_REQUEST['value']) && $_REQUEST['value'] != '') ? sanitize_text_field( $_REQUEST['value'] ) : null;
		$command			= (isset($_REQUEST['command']) && $_REQUEST['command'] != '') ? sanitize_text_field( $_REQUEST['command'] ) : null;
		$catId				= (isset($_REQUEST['catId']) && $_REQUEST['catId'] != '') ? absint( sanitize_text_field( $_REQUEST['catId'] ) ) : null;

		if($user_id > 0 && $group_name != null){
			if($command == null && $catId == null){
				$insert_results = $wpdb->insert(
					$categories_table,
					array(
						'user_id' => $user_id,
						'name' => $group_name,
						'date_created' => current_time( 'mysql' ),
					),
					array(
						'%d', // user_id
						'%s', // name
						'%s', // date
					)
				);

				$sql  = "SELECT id FROM ".$settings_table ." WHERE user_id = " . $user_id ." ";
				$users = $wpdb->get_row($sql,'ARRAY_A');
				
				if( empty($users) ){

					$insert_results = $wpdb->insert(
						$settings_table,
					array(
						'user_id' 		=> $user_id,
						'meta_key' 		=> 'register_date',
						'meta_value' 	=> current_time( 'mysql' ),
						'note'       	=> "",
						'options'    	=> ""
					),
					array(
						'%d',
						'%s',
						'%s',
						'%s', 	
						'%s', 	

						)
					);
				}
				
			}else{
				$insert_results = $wpdb->update(
                    $categories_table,
                    array(
						'name' => $group_name,

                    ),
                    array( 'id' => $catId ),
                    array(
                        '%s', // name
                    ),
                    array( '%d' )
                );
			}


			$response = array(
				"status" => true,
				"added_group" => $insert_results,
			);
            ob_end_clean();
            $ob_get_clean = ob_get_clean();
			echo json_encode( $response );
			wp_die();
		}
	}

	public function ays_words_add_ajax(){
		global $wpdb;
		$words_table 		= esc_sql( $wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'words' );
		$user_id			= get_current_user_id();
		$category_id		= (isset($_REQUEST['category_id']) && $_REQUEST['category_id'] != '') ? absint( sanitize_text_field( $_REQUEST['category_id'] ) ) : null;
		$word				= (isset($_REQUEST['word']) && $_REQUEST['word'] != '') ? sanitize_text_field( $_REQUEST['word'] ) : null;
		$translation		= (isset($_REQUEST['translation']) && $_REQUEST['translation'] != '') ? sanitize_text_field( $_REQUEST['translation'] ) : '';
		$command			= (isset($_REQUEST['command']) && $_REQUEST['command'] != '') ? absint( sanitize_text_field( $_REQUEST['command'] ) ) : null;
		$wordId				= (isset($_REQUEST['wordId']) && $_REQUEST['wordId'] != '') ? absint( sanitize_text_field( $_REQUEST['wordId'] ) ) : null;

		if($user_id > 0 && $word !== null && $category_id !== null){
			if($command == null && $wordId == null){
				$insert_results = $wpdb->insert(
					$words_table,
					array(
						'user_id'		 	=> $user_id,
						'category_id'	 	=> $category_id,
						'word'			 	=> $word,
						'translation'    	=> $translation,
						'date_created'		=> current_time( 'mysql' ),
						'date_modified'		=> current_time( 'mysql' ),
					),
					array(
						'%d', // user_id
						'%d', // category_id
						'%s', // word
						'%s', // translation
						'%s', // date_created
						'%s', // date_modified
					)
				);
			}else{
				$insert_results = $wpdb->update(
                    $words_table,
                    array(
						'word'			 	=> $word,
						'translation'    	=> $translation,
                        'date_modified'     => current_time( 'mysql' ),

                    ),
                    array( 'id' => $wordId ),
                    array(
                        '%s', // word
                        '%s', // translation
                        '%s', // date_modified
                    ),
                    array( '%d' )
                );
			}
				
			$response = array(
				"status" => true,
				"added_words" => $insert_results,
			);
            ob_end_clean();
            $ob_get_clean = ob_get_clean();
			echo json_encode( $response );
			wp_die();
		}
	}

	public function ays_groups_delete_ajax(){
		global $wpdb;
		$categories_table 	= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'categories');
		$words_table 		= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'words');
		$user_id			= get_current_user_id();
		$catId				= (isset($_REQUEST['catId']) && $_REQUEST['catId'] != '') ? absint( sanitize_text_field( $_REQUEST['catId'] ) ) : null;

		if($user_id > 0 && $catId !== null){
			
			$deleted_group = $wpdb->delete(
				$categories_table,
				array( 'id' => $catId ),
				array( '%d' )
			);

			$deleted_words = $wpdb->delete(
				$words_table,
				array( 'category_id' => $catId ),
				array( '%d' )
			);
				
			$response = array(
				"status" => true,
				"deleted_group" => $deleted_group,
				"deleted_words" => $deleted_words,
			);
            ob_end_clean();
            $ob_get_clean = ob_get_clean();
			echo json_encode( $response );
			wp_die();
		}
	}

	public function ays_group_reset_ajax(){
		global $wpdb;

		$words_table 		= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'words');
		$user_id			= get_current_user_id();
		$catId				= (isset($_REQUEST['catId']) && $_REQUEST['catId'] != '') ? absint( sanitize_text_field( $_REQUEST['catId'] ) ) : null;

		if($user_id > 0 && $catId !== null){
			
			$update_result = $wpdb->update(
				$words_table,
				array(
					'point'				=> 0,
					'completed'    		=> 0,
					'percentage'    	=> 0,
					'corrects_count'    => 0,
					'failed_count'    	=> 0,
					'attempts_count'    => 0,
					'date_modified'     => current_time( 'mysql' ),
				),
				array( 'category_id' => $catId ),
				array(
					'%f', // point
					'%d', // completed
					'%f', // percentage
					'%d', // corrects_count
					'%d', // failed_count
					'%d', // attempts_count
					'%s', // date_modified
				),
				array( '%d' )
			);
				
			$response = array(
				"status" => true,
				"update_word" => $update_result,
			);

            ob_end_clean();
            $ob_get_clean = ob_get_clean();
			echo json_encode( $response );
			wp_die();
		}
	}

	public function ays_words_delete_ajax(){
		global $wpdb;
		$words_table 	= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'words');
		$user_id		= get_current_user_id();
		$wordId			= (isset($_REQUEST['wordId']) && $_REQUEST['wordId'] != '') ? absint( sanitize_text_field( $_REQUEST['wordId'] ) ) : null;

		if($user_id > 0 && $wordId !== null){
			
			$delete_result = $wpdb->delete(
				$words_table,
				array( 'id' => intval($wordId) ),
				array( '%d' )
			);
				
			$response = array(
				"status" => true,
				"deleted_words" => $delete_result,
			);

            ob_end_clean();
            $ob_get_clean = ob_get_clean();
			echo json_encode( $response );
			wp_die();
		}
	}

	public function ays_word_reset_ajax(){
		global $wpdb;
		$words_table 	= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'words');
		$user_id		= get_current_user_id();
		$wordId			= (isset($_REQUEST['wordId']) && $_REQUEST['wordId'] != '') ? absint( sanitize_text_field( $_REQUEST['wordId'] ) ) : null;

		if($user_id > 0 && $wordId !== null){
			
			$update_result = $wpdb->update(
				$words_table,
				array(
					'point'				=> 0,
					'completed'    		=> 0,
					'percentage'    	=> 0,
					'corrects_count'    => 0,
					'failed_count'    	=> 0,
					'attempts_count'    => 0,
					'date_modified'     => current_time( 'mysql' ),
				),
				array( 'id' => $wordId ),
				array(
					'%f', // point
					'%d', // completed
					'%f', // percentage
					'%d', // corrects_count
					'%d', // failed_count
					'%d', // attempts_count
					'%s', // date_modified
				),
				array( '%d' )
			);
				
			$response = array(
				"status" => true,
				"update_word" => $update_result,
			);

            ob_end_clean();
            $ob_get_clean = ob_get_clean();
			echo json_encode( $response );
			wp_die();
		}
	}

	public function ays_show_words_ajax(){
		global $wpdb;
		$user_id = get_current_user_id();
		$cat_id = (isset($_REQUEST['catId']) && $_REQUEST['catId'] != '') ? absint( sanitize_text_field( $_REQUEST['catId'] ) ) : null;
		$results = array();
		if( $cat_id !== null ){
			$categories_table = esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'categories');
			$words_table = esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'words');
			$sql  = "SELECT * FROM ".$words_table . " WHERE category_id = " . $cat_id ."  AND user_id = ". $user_id . " ORDER BY id DESC " ;
			$words = $wpdb->get_results($sql, 'ARRAY_A');

			$sql2 = "SELECT `name` FROM ".$categories_table . " WHERE id = " . $cat_id ." ";
			$group_name = $wpdb->get_var($sql2);
			
			$pd = Personal_Dictionary_Data::get_pd_globsettings();
			$this->options = Personal_Dictionary_Data::get_pd_validated_data_from_array( $pd );
			$learnt_point = $this->options[ $this->name_prefix . 'learned_points' ];

			foreach ($words as $key => $value) {
				$percentage = 0;
				if( floatval( $value['point'] ) > 0){
					$percentage = round( ( floatval( $value['point'] ) / $learnt_point ) * 100, 1 );
				}else{
					$percentage = 0;
				}

				$words[$key]['percentage'] = $percentage;
			}

			$results[] = $words;
			$results[] = $group_name;
		}

		return $results;
	}

	public function ays_groups_pd(){
		global $wpdb;
		$user_id = get_current_user_id();
		$words_table = esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'words');
		$categories_table = esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'categories');
		$sql = "SELECT * FROM ".$categories_table ." WHERE user_id = " . $user_id ."  ORDER BY id DESC";
		$groups = $wpdb->get_results($sql, 'ARRAY_A');

		$pd = Personal_Dictionary_Data::get_pd_globsettings();
		$this->options = Personal_Dictionary_Data::get_pd_validated_data_from_array( $pd );

		$learnt_point = $this->options[ $this->name_prefix . 'learned_points' ];
		foreach ($groups as $key => $value) {
			$percentage = 0;
			$w_count = 0;
			$sql2  = "SELECT SUM( point ) as sum, COUNT(id) as count FROM ".$words_table . " WHERE category_id = " . $value['id'] ."  AND user_id = ". $user_id . "  ";
			$completed_words = $wpdb->get_row($sql2,'ARRAY_A');
			if($completed_words['count'] > 0){
				$percentage = ( floatval( $completed_words['sum'] ) / ( $learnt_point * absint( $completed_words['count'] ) ) ) * 100;
			}else{
				$percentage = 0;
			}

			$w_count = isset($completed_words['count']) ? absint( $completed_words['count'] ) : 0;
			$groups[$key]['percentage'] = $percentage;
			$groups[$key]['w_count'] = $w_count;
		}

		return $groups;
	}

	public function ays_games_pd(){
		global $wpdb;
		$user_id = get_current_user_id();
		$categories_table = esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'categories');
		$words_table 	= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'words');
		$sql  = "SELECT * FROM ".$categories_table ." WHERE user_id = " . $user_id ."  ORDER BY id DESC";
		$groups = $wpdb->get_results($sql, 'ARRAY_A');

		foreach ($groups as $key => $value) {
			$sql2  = "SELECT COUNT(id) as count FROM ".$words_table . " WHERE category_id = " . $value['id'] ."  AND user_id = ". $user_id . " AND completed = 0 AND translation != '' ";
			$group_words_count = $wpdb->get_row($sql2,'ARRAY_A');
			$groups[$key]['words_count'] = $group_words_count['count'];
		}

		return $groups;
	}

	public function ays_import_pd( $import_file ){

		global $wpdb;
		$name_arr = explode('.', $import_file['name']);
		$type     = end($name_arr);
		
		if($type == 'xlsx' || $type == 'XLSX') {

		
			$categories_table 	= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'categories');
			$words_table 		= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'words');
			$settings_table 	= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'settings');
			$questions_lines 	= fopen($import_file['tmp_name'], 'r');
			
			$user_id = get_current_user_id();
			$file_name = $import_file['name'];
			
			$file_name = explode('.'.$type,$file_name);

			$category_id = (isset($_POST['ays-pd-import-select']) && $_POST['ays-pd-import-select'] != '') ?  sanitize_text_field($_POST['ays-pd-import-select']) : 'new_group';

			$for_import = array();
			
				
			$ver = (float) phpversion();
			if ($ver >= 5.6) {
				require_once(PERSONAL_DICTIONARY_DIR . 'includes/PHPExcel/vendor/autoload.php');
				$spreadsheet = IOFactory::load($import_file['tmp_name']);
				$sheet_data  = $spreadsheet->getActiveSheet()->toArray("", true, true, true);
				
		
				$firstLine = array_values($sheet_data[1]);

				
				if( $firstLine[0] == 'word' &&  $firstLine[1] == 'translation' ){
					$headers = $sheet_data[1];
					unset($sheet_data[1]);
				}
				$headers = array ('0' => 'word','1'=>'translation');
				

					//walk and array_combine with array_values
					foreach ( $sheet_data as &$row ) {
						
						$values = array_values($row);
						$row = array_combine($headers, $values);			
					}
					$res_data = array_values($sheet_data);
					foreach ( $res_data as $key => &$value ) {
						if($value['word'] == ''){
							continue;
						}
						$word = htmlspecialchars_decode(isset($value['word']) && $value['word'] != '' ? $value['word'] : '', ENT_HTML5);
						$translation = htmlspecialchars_decode(isset($value['translation']) && $value['translation'] != '' ? $value['translation'] : '', ENT_HTML5);
						
						$for_import[] = array(
							'word'               => $word,
							'translation'        => $translation,
							
						);
					}

			}

			if($category_id == 'new_group'){

				$insert_cat = $wpdb->insert(
					$categories_table,
				array(
					'user_id' => $user_id,
					'name' => $file_name[0],
					'date_created' => current_time( 'mysql' ),
				),
				array(
					'%d', // user_id
					'%s', // name
					'%s', // date
					
					)
				);
				$category_id = $wpdb->insert_id;


				$sql  = "SELECT id FROM ".$settings_table ." WHERE user_id = " . $user_id ." ";
				$users = $wpdb->get_row($sql,'ARRAY_A');
				
				if( empty($users) ){

					$insert_results = $wpdb->insert(
						$settings_table,
					array(
						'user_id' 		=> $user_id,
						'meta_key' 		=> 'register_date',
						'meta_value' 	=> current_time( 'mysql' ),
						'note'       	=> "",
						'options'    	=> ""
					),
					array(
						'%d',
						'%s',
						'%s',
						'%s', 	
						'%s', 	

						)
					);
				}
			}
			
			foreach($for_import as $key => $value){
				$words_res = $wpdb->insert(
					$words_table,						
					array(
						'user_id'		 	=> $user_id,
						'category_id'	 	=> $category_id,
						'word'			 	=> $value['word'],
						'translation'    	=> $value['translation'],
						'date_created'		=> current_time( 'mysql' ),
						'date_modified'		=> current_time( 'mysql' ),
					),
					array(
						'%d', // user_id
						'%d', // category_id
						'%s', // word
						'%s', // translation
						'%s', // date_created
						'%s', // date_modified
						
						)
				);
			
			}
		}
	}


	public function ays_pd_add_game_results(){
		global $wpdb;
		$reports_table 			= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'reports');
		$user_id				= get_current_user_id();
		$ays_pd_words 			= (isset($_REQUEST['ays-pd-word']) && !empty($_REQUEST['ays-pd-word'])) ? array_map( 'sanitize_text_field', $_REQUEST['ays-pd-word'] ) : array();
		$ays_pd_translations	= (isset($_REQUEST['ays-pd-translation']) && !empty($_REQUEST['ays-pd-translation'])) ? array_map( 'sanitize_text_field', $_REQUEST['ays-pd-translation'] ) : array();
		$game_type				= (isset($_REQUEST['gameType']) && $_REQUEST['gameType'] != '') ? absint( sanitize_text_field( $_REQUEST['gameType'] ) ) : null;
		$groups_ids				= (isset($_REQUEST['groupsIds']) && !empty($_REQUEST['groupsIds'])) ? array_map( 'sanitize_text_field', $_REQUEST['groupsIds'] ) : null;
		$groups_ids				= implode(',',$groups_ids);
		$words_str 				= implode(',',$ays_pd_words);
		$translation_str 		= implode(',',$ays_pd_translations);

		$pd = Personal_Dictionary_Data::get_pd_globsettings();
		$this->options = Personal_Dictionary_Data::get_pd_validated_data_from_array( $pd );

		$right_points = (isset($this->options[ $this->name_prefix . 'right_points' ]) && $this->options[ $this->name_prefix . 'right_points' ] != '') ? abs( floatval( $this->options[ $this->name_prefix . 'right_points' ] ) ) : 1;

		switch ($game_type) {
			case 'find_word':
				$score_count = 0;
				$words_count = count($ays_pd_words);
				foreach ($ays_pd_translations as $key => $value) {
					if($key == $value){
						$score_count = $score_count + 1;
					}
				}
				if($words_count == 0 || empty($ays_pd_words)){
					$score = 0;
				}else{
					$score = round( ( $score_count / $words_count ) * 100, 1 );
				}
				$points = $score_count * $right_points;
	
				$insert_results = $wpdb->insert(
					$reports_table,
					array(
						'user_id'		 	=> $user_id,
						'words_ids' 		=> $words_str,
						'categories_ids' 	=> $groups_ids,
						'score' 			=> $score,
						'words_count' 		=> $words_count,
						'game_type' 		=> $game_type,
						'points' 			=> $points,
						'complete_date' 	=> current_time( 'mysql' ),
					),
					array(
						'%d', // user_id
						'%s', // words_ids
						'%s', // categories_ids
						'%s', // score
						'%d', // words_count
						'%s', // game_type
						'%f', // points
						'%s', // complete_date
					)
				);
				break;
			case 'find_translation':
				$score_count = 0;
				$words_count = count($ays_pd_translations);
				foreach ($ays_pd_words as $key => $value) {
					if($key == $value){
						$score_count = $score_count + 1;
					}
				}
				$points = $score_count * $right_points;

				if($words_count == 0 || empty($ays_pd_translations)){
					$score = 0;
				}else{
					$score = round( ( $score_count / $words_count ) * 100, 1 );
				}
	
				$insert_results = $wpdb->insert(
					$reports_table,
					array(
						'user_id'		 	=> $user_id,
						'words_ids' 		=> $translation_str,
						'categories_ids' 	=> $groups_ids,
						'score' 			=> $score,
						'words_count' 		=> $words_count,
						'game_type' 		=> $game_type,
						'points' 			=> $points,
						'complete_date' 	=> current_time( 'mysql' ),
					),
					array(
						'%d', // user_id
						'%s', // words_ids
						'%s', // categories_ids
						'%s', // score
						'%d', // words_count
						'%s', // game_type
						'%f', // points
						'%s', // complete_date
					)
				);
				break;
			default:
				$score_count = 0;
				$words_count = count($ays_pd_words);
				foreach ($ays_pd_translations as $key => $value) {
					if($key == $value){
						$score_count = $score_count + 1;
					}
				}
				$points = $score_count * $right_points;

				if($words_count == 0 || empty($ays_pd_words)){
					$score = 0;
				}else{
					$score = round( ( $score_count / $words_count ) * 100, 1 );
				}
	
				$insert_results = $wpdb->insert(
					$reports_table,
					array(
						'user_id'		 	=> $user_id,
						'words_ids' 		=> $words_str,
						'categories_ids' 	=> $groups_ids,
						'score' 			=> $score,
						'words_count' 		=> $words_count,
						'game_type' 		=> $game_type,
						'points' 			=> $points,
						'complete_date' 	=> current_time( 'mysql' ),
					),
					array(
						'%d', // user_id
						'%s', // words_ids
						'%s', // categories_ids
						'%s', // score
						'%d', // words_count
						'%s', // game_type
						'%f', // points
						'%s', // complete_date
					)
				);
			break;
		}

		$response = array(
			"status" => true,
			"added_report" => $insert_results,
		);
		ob_end_clean();
		$ob_get_clean = ob_get_clean();
		echo json_encode( $response );
		wp_die();
	}

	public function ays_pd_update_word(){
		global $wpdb;
		$user_id				= get_current_user_id();
		$word_id				= (isset($_REQUEST['wordId']) && $_REQUEST['wordId'] != '') ? absint( sanitize_text_field( $_REQUEST['wordId'] ) ) : null;
		$voted					= (isset($_REQUEST['voted']) && $_REQUEST['voted'] != '') ? absint( sanitize_text_field( $_REQUEST['voted'] ) ) : null;
		$words_table 			= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'words');
		$sql  					= "SELECT * FROM ".$words_table . " WHERE id = " . $word_id ."  AND user_id = ". $user_id . " " ;
		$words 					= $wpdb->get_row($sql,'ARRAY_A');
		$point 					= (isset($words['point']) && $words['point'] != '') ? floatval( sanitize_text_field( $words['point'] ) ) : 0;
		$completed 				= (isset($words['completed']) && $words['completed'] != '') ? absint( sanitize_text_field( $words['completed'] ) ) : 0;
		$percentage 			= (isset($words['percentage']) && $words['percentage'] != '') ? floatval( sanitize_text_field( $words['percentage'] ) ) : 0;
        $corrects_count 		= (isset($words['corrects_count']) && $words['corrects_count'] != '') ? absint( sanitize_text_field( $words['corrects_count'] ) ) : 0;
		$failed_count 			= (isset($words['failed_count']) && $words['failed_count'] != '') ? absint( sanitize_text_field( $words['failed_count'] ) ) : 0;
		$attempts_count 		= (isset($words['attempts_count']) && $words['attempts_count'] != '') ? absint( sanitize_text_field( $words['attempts_count'] ) ) : 0;
		$response 				= array();

		$pd = Personal_Dictionary_Data::get_pd_globsettings();
		$this->options = Personal_Dictionary_Data::get_pd_validated_data_from_array( $pd );

		$learnt_point = $this->options[ $this->name_prefix . 'learned_points' ];
		$right_points = $this->options[ $this->name_prefix . 'right_points' ];
		$wrong_points = $this->options[ $this->name_prefix . 'wrong_points' ];
		// $show_correct_answer = (isset($this->options[ $this->name_prefix . 'show_correct_answer' ]) && $this->options[ $this->name_prefix . 'show_correct_answer' ] == 'on') ?  esc_attr($this->options[ $this->name_prefix . 'show_correct_answer' ]) : 'off';
		// $word_sorting = (isset($this->options[ $this->name_prefix . 'word_sorting' ]) && $this->options[ $this->name_prefix . 'word_sorting' ] != '') ?  esc_attr($this->options[ $this->name_prefix . 'word_sorting' ]) : 'word';
		
		if($voted !== null && $word_id !== null){
			$attempts_count = $attempts_count + 1;
			if($voted == $word_id){
				$corrects_count = $corrects_count + 1;
				$point 	= $point + $right_points;
			}else{
				$failed_count = $failed_count + 1;
				if( $point > 0 ){
					$point = $point - $wrong_points;
				}
			}
			
			if( $point < 0){
				$point = 0;
			}
			if( $point >= $learnt_point ){
				$completed = 1;
				$point = $learnt_point;
			}

			if($learnt_point == 0){
				$percentage = 0;
			}else{
				$percentage = ($point / $learnt_point) * 100;
			}

			if($percentage > 100){
				$percentage = 100;
			}

			$update_result = $wpdb->update(
				$words_table,
				array(
					'point'				=> $point,
					'completed'    		=> $completed,
					'percentage'    	=> $percentage,
					'corrects_count'    => $corrects_count,
					'failed_count'    	=> $failed_count,
					'attempts_count'    => $attempts_count,
					'date_modified'     => current_time( 'mysql' ),
				),
				array( 'id' => $word_id ),
				array(
					'%f', // point
					'%d', // completed
					'%f', // percentage
					'%d', // corrects_count
					'%d', // failed_count
					'%d', // attempts_count
					'%s', // date_modified
				),
				array( '%d' )
			);
			$response = array(
				"status" => true,
				"update_words" => $update_result,
			);
            ob_end_clean();
            $ob_get_clean = ob_get_clean();
			echo json_encode( $response );
			wp_die();
		}

		return $response;
	}

	public function ays_pd_game_find_word(){
		global $wpdb;
		$words_table 		= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'words');
		$user_id			= get_current_user_id();
		$groups_ids			= (isset($_REQUEST['groupsIds']) && !empty($_REQUEST['groupsIds'])) ? array_map( 'sanitize_text_field', $_REQUEST['groupsIds'] ) : null;
		$ids				= (isset($_REQUEST['ids']) && !empty($_REQUEST['ids'])) ? array_map( 'sanitize_text_field', $_REQUEST['ids'] ) : array();
		$words_count		= (isset($_REQUEST['wordsCount']) && $_REQUEST['wordsCount'] != '' ) ? sanitize_text_field( $_REQUEST['wordsCount'] ) : 10;
		$limit_number		= (isset($_REQUEST['number']) && $_REQUEST['number'] != '') ? sanitize_text_field( $_REQUEST['number'] ) : 0;
		
		$limit_number_min 	= $limit_number;
		$words 				= array();
		$result_arr			= array();
		
		$sql = "SELECT COUNT(id) FROM ".$words_table . " WHERE category_id IN (" . implode(',', $groups_ids) . ")  AND user_id = ". $user_id . " AND completed = 0 AND translation <> '' " ;
		$completed_count = absint( $wpdb->get_var( $sql ) );
		$hidden_count = (isset($_REQUEST['hiddenCount']) && $_REQUEST['hiddenCount'] != null ) ? absint( sanitize_text_field( $_REQUEST['hiddenCount'] ) ) : $completed_count;
		
		$sql  = "SELECT id FROM ".$words_table . " WHERE category_id IN (" . implode(',', $groups_ids) . ")  AND user_id = ". $user_id . " AND completed = 1 AND translation != '' " ;
		$completed_res = $wpdb->get_results($sql,'ARRAY_A');

		foreach ($completed_res as $key => $value) {	
			array_push($ids,$value['id']);
		}
	
		$not_in = '';
		if(!empty($ids)){
			$not_in = " AND id NOT IN (" . implode(',', $ids) . ")";
		}else{
			$not_in = '';
		}
		
		if($groups_ids !== null && ($limit_number_min != $words_count || $limit_number_min == 'all')){
			
			$sql  = "SELECT * FROM ".$words_table . " WHERE category_id IN (" . implode(',', $groups_ids) . ")  AND user_id = ". $user_id . " AND translation != ''  " ;
			$words = $wpdb->get_results($sql, 'ARRAY_A');
			$sql2 = "SELECT * FROM ".$words_table . " WHERE category_id IN (" . implode(',', $groups_ids) . ")  AND user_id = ". $user_id . $not_in . " AND translation != '' ORDER BY RAND() LIMIT 10" ;
			$ten_words = $wpdb->get_results($sql2, 'ARRAY_A');
			$limit_number_min = $limit_number + 10;
			
			if($completed_count >= 4){

				$translations_arr = array();
				foreach ($ten_words as $key => $value) {
					$limit_number = $limit_number + 1;
					
					$result_arr[$value['id']]['id'] = $value['id'];
					$result_arr[$value['id']]['word'] = $value['word'];

					$result_arr[$value['id']]['translations'][] = array(
						intval( $value['id'] ),
						$value['translation']
					);

					$result_arr[$value['id']]['correct_answer'] = intval($value['id']);
					$result_arr[$value['id']]['count'] = intval($hidden_count);
					$result_arr[$value['id']]['limitNumber'] = $limit_number_min;
					$result_arr[$value['id']]['dataId'] = $limit_number;
					
				}
				
				foreach($words as $k => $v){
					$translations_arr[$v['id']] = $v['translation'];
				}
				
				foreach ($result_arr as $key => $value) {
					$translations_arr2 = $translations_arr;
					unset($translations_arr2[$key]);
					$rand_keys = array_rand($translations_arr2,3);
			
					foreach ($rand_keys as $key2 => $value2) {
						$result_arr[$key]['translations'][] = array( $value2, $translations_arr2[$value2] );
						shuffle($result_arr[$key]['translations']);					
					}
				}
			}
		
		}
		shuffle($result_arr);
		return $result_arr;
	}

	public function ays_pd_game_find_translation(){
		global $wpdb;
		$words_table 		= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'words');
		$user_id			= get_current_user_id();
		$groups_ids			= (isset($_REQUEST['groupsIds']) && !empty($_REQUEST['groupsIds'])) ? array_map( 'sanitize_text_field', $_REQUEST['groupsIds'] ) : null;
		$ids				= (isset($_REQUEST['ids']) && !empty($_REQUEST['ids'])) ? array_map( 'sanitize_text_field', $_REQUEST['ids'] ) : array();
		$words_count		= (isset($_REQUEST['wordsCount']) && $_REQUEST['wordsCount'] != '' ) ? sanitize_text_field( $_REQUEST['wordsCount'] ) : 10;
		$limit_number		= (isset($_REQUEST['number']) && $_REQUEST['number'] != '') ? sanitize_text_field( $_REQUEST['number'] ) : 0;
		
		$limit_number_min 	= $limit_number;
		$words 				= array();
		$result_arr			= array();
		
		$sql  = "SELECT COUNT(id) FROM ".$words_table . " WHERE category_id IN (" . implode(',', $groups_ids) . ")  AND user_id = ". $user_id . " AND completed = 0  AND translation != '' " ;
		$completed_count = absint( $wpdb->get_var( $sql ) );
		$hidden_count = (isset($_REQUEST['hiddenCount']) && $_REQUEST['hiddenCount'] != null ) ? absint( sanitize_text_field( $_REQUEST['hiddenCount'] ) ) : $completed_count;
		
		$sql  = "SELECT id FROM ".$words_table . " WHERE category_id IN (" . implode(',', $groups_ids) . ")  AND user_id = ". $user_id . " AND completed = 1 AND translation != '' " ;
		$completed_res = $wpdb->get_results($sql,'ARRAY_A');

		foreach ($completed_res as $key => $value) {	
			array_push($ids,$value['id']);
		}
	
		$not_in = '';
		if(!empty($ids)){
			$not_in = " AND id NOT IN (" . implode(',', $ids) . ")";
		}else{
			$not_in = '';
		}
	
		if($groups_ids !== null && ($limit_number_min != $words_count || $limit_number_min == 'all')){
			
			$sql  = "SELECT * FROM ".$words_table . " WHERE category_id IN (" . implode(',', $groups_ids) . ")  AND user_id = ". $user_id . " AND translation != ''  " ;
			$words = $wpdb->get_results($sql, 'ARRAY_A');
			$sql2 = "SELECT * FROM ".$words_table . " WHERE category_id IN (" . implode(',', $groups_ids) . ")  AND user_id = ". $user_id . $not_in . " AND translation != '' ORDER BY RAND() LIMIT 10" ;
			$ten_translations = $wpdb->get_results($sql2, 'ARRAY_A');
			$limit_number_min = $limit_number + 10;
			
			if($completed_count >= 4){

				$words_arr = array();
				foreach ($ten_translations as $key => $value) {
					$limit_number = $limit_number + 1;
					
					$result_arr[$value['id']]['id'] =  $value['id'];
					$result_arr[$value['id']]['translation'] = $value['translation'];
					
					$result_arr[$value['id']]['words'][] = array(
						intval( $value['id'] ),
						$value['word']
					);
					
					$result_arr[$value['id']]['correct_answer'] = intval($value['id']);
					$result_arr[$value['id']]['count'] = intval($hidden_count);
					$result_arr[$value['id']]['limitNumber'] = $limit_number_min;
					$result_arr[$value['id']]['dataId'] = $limit_number;
					
				}
				
				foreach($words as $k => $v){
					$words_arr[$v['id']] =  $v['word'];
				}
				
				foreach ($result_arr as $key => $value) {
					$words_arr2 = $words_arr;
					unset($words_arr2[$key]);
					$rand_keys = array_rand($words_arr2,3);
			
					foreach ($rand_keys as $key2 => $value2) {
						$result_arr[$key]['words'][] = array($value2,$words_arr2[$value2]);
						shuffle($result_arr[$key]['words']);					
					}
				}
			}
		
		}

		shuffle($result_arr);
		return $result_arr;
	}

	public function ays_generate_pd_method(){
		ob_start();
        $this->enqueue_styles();
        $this->enqueue_scripts();
		$limit = false;
		$pd = Personal_Dictionary_Data::get_pd_globsettings();

		$this->options = Personal_Dictionary_Data::get_pd_validated_data_from_array( $pd );

		if( is_user_logged_in() ){
			$limit = true;
		}else{
			echo "<p style='text-align: center;font-style:italic;'>" . __( "You must log in to see content.", $this->plugin_name ) . "</p>";
			return str_replace( array( "\r\n", "\n", "\r" ), '', ob_get_clean() );    
		}
		
		$content = array();

		$ayspd_tab = ( isset( $_GET['ays-pd-tab'] ) && $_GET['ays-pd-tab'] != '' ) ? sanitize_text_field( $_GET['ays-pd-tab'] ) : 'groups';
		$add_group_btn = $ayspd_tab == 'groups' ? '' : 'ays_display_none';

		$texts = array(
			'groups' => __( "Groups", $this->plugin_name ),
			'games' => __( "Games", $this->plugin_name ),
		);

		// if( (isset($_GET['ays-pd-tab'])) && $_GET['ays-pd-tab'] != ''){
		$menu_name = isset( $texts[ $ayspd_tab ] ) ? $texts[ $ayspd_tab ] : $texts[ 'groups' ];
		$menu_name = '<h3>'. $menu_name .'</h3>';
		// }else{
		// 	$menu_name = '<h3>'. __( "Groups", $this->plugin_name ) .'</h3>';
		// }

        $content[] = '<h2 class="">'. __( "Dictionary", $this->plugin_name ) .'</h2>';
		$content[] = '<div id="' . $this->html_class_prefix . 'box_id' . '" class="' . $this->html_class_prefix . 'box' . '">';
			$content[] = '<div class="' . $this->html_class_prefix . 'header-wrap">';

				$content[] = '<div class="' . $this->html_class_prefix . 'header-before">';
				$content[] = '</div>';

				$content[] = '<div id="' . $this->html_class_prefix . 'header_id' . '" class="' . $this->html_class_prefix . 'header ' . '">';
					$content[] = '<div class="' . $this->html_class_prefix . 'header_title' . '" >';
						$content[] = $menu_name;
					$content[] = '</div>';
					$content[] = '<span class="' . $this->html_class_prefix . 'add_group_btn '. $add_group_btn .' ">+</span>';
				$content[] = '</div>';

			$content[] = '</div>';
    	$content[] = '<div id="' . $this->html_class_prefix . 'container_id' . '" class="' . $this->html_class_prefix . 'container' . '">';

        
        

		$content[] = $this->show_pd();
              
		$content[] = '</div>';

		$content[] = $this->get_styles();
		$content[] = $this->get_custom_css();
		$content[] = $this->get_encoded_options( $limit );
		$content[] = '</div>';

		$content = implode( '', $content );
		echo $content;
		return str_replace( array( "\r\n", "\n", "\r" ), '', ob_get_clean() );    
	}

	public function show_pd(){

		$texts = array(
			'groups' => __( "Groups", $this->plugin_name ),
			'games' => __( "Games", $this->plugin_name ),
			'import' => __( "Import", $this->plugin_name ),
		);

		$group_tab_url = esc_url_raw( add_query_arg( array("ays-pd-tab"  => "groups")));
		$games_tab_url = esc_url_raw( add_query_arg( array("ays-pd-tab"  => "games")));
		$import_tab_url 	= esc_url_raw( add_query_arg( array("ays-pd-tab"  => "import")));
		$content = array();

		$current_menu = (isset($_GET['ays-pd-tab']) && $_GET['ays-pd-tab'] != '' ) ? sanitize_text_field($_GET['ays-pd-tab']) : 'groups';

		$active_tab_group = ($current_menu == 'groups') ? 'ays-pd-nav-tab-active' : '';
		$active_tab_games = ($current_menu == 'games') ? 'ays-pd-nav-tab-active' : '';
		$active_tab_import = ($current_menu == 'import') ? 'ays-pd-nav-tab-active' : '';

		$content[] = '<div class="' . $this->html_class_prefix . 'nav-menu ' . '">';
			$content[] = '<a href="' . $group_tab_url . '"  class="' . $this->html_class_prefix . 'nav-tab ' . $active_tab_group . '">'. $texts[ 'groups' ] .'</a>';
			$content[] = '<a href="' . $games_tab_url . '"  class="' . $this->html_class_prefix . 'nav-tab ' . $active_tab_games . '">'. $texts[ 'games' ] .'</a>';
			$content[] = '<a href="' . $import_tab_url . '"  class="' . $this->html_class_prefix . 'nav-tab ' . $active_tab_import . '">'. $texts[ 'import' ] .'</a>';
		$content[] = '</div>';

		$content[] = '<div class="' . $this->html_class_prefix . 'content' . ' ' . $this->html_class_prefix . 'content-' . $current_menu . '">';
		$content[] = '<div class="' . $this->html_class_prefix . 'content-div' . '">';
		switch ($current_menu) {
			case 'groups':
				$content[] = $this->groups_tab();
				break;
			case 'games':
				$content[] = $this->games_tab();
				break;
			case 'import':
				$content[] = $this->import_tab();
				break;
			default:
				$content[] = $this->groups_tab();
				break;
		}
		$content[] = '</div>';
		$content[] = '</div>';
		$content = implode( '', $content );
		return $content;
	}

	public function groups_tab(){
		$content = array();
		$content[] = '<div class="' . $this->html_class_prefix . 'save-groups-block '.  $this->html_class_prefix . 'group-tab-add-layer '. '"  data-function="">';
		$content[] = '</div>';
		$content[] = '<div class="' . $this->html_class_prefix . 'group-tab-words '. $this->html_class_prefix . 'group-tab-add-layer '. '"  data-function="ays_groups_pd">';
		$content[] = '</div>';
		$content[] = '<div class="' . $this->html_class_prefix . 'group-tab '. $this->html_class_prefix . 'tab-content'. '"  data-function="ays_groups_pd"></div>';
		$content[] =  '<div class="ays-pd-preloader">
                <img class="loader" src="'. PERSONAL_DICTIONARY_PUBLIC_URL .'/images/loaders/3-1.svg">
            </div>';
		
		$content = implode( '',$content );
		return $content;
	}

	public function games_tab(){
		$content = array();
		// $content[] = '<h2>Games</h2>';
		$content[] = '<div class="' . $this->html_class_prefix . 'games-tab '. $this->html_class_prefix . 'tab-content'.'" data-function="ays_games_pd">';
			$content[] = '<div class="' . $this->html_class_prefix . 'games-choosing-type '.'" >';

				$content[] = '<label>';
					$content[] = '<input class="' . $this->html_class_prefix . 'game-type-rad'.'" id="' . $this->html_class_prefix . 'games-type-find-word'. '" type="radio" name="ays-pd[game_type]" value="find_word">';
					$content[] = '<div class="' . $this->html_class_prefix . 'game-type-item'.'" >';
						$content[] = '<div class="' . $this->html_class_prefix . 'game-type-item-title '.'" >'. __("Find the word", $this->plugin_name ) . '</div>';
					$content[] = '</div>';
				$content[] = '</label>';

				$content[] = '<label>';
					$content[] = '<input class="' . $this->html_class_prefix . 'game-type-rad'.'" id="' . $this->html_class_prefix . 'games-type-find-translation'. '" type="radio" name="ays-pd[game_type]" value="find_translation">';
					$content[] = '<div class="' . $this->html_class_prefix . 'game-type-item'.'" >';
						$content[] = '<div class="' . $this->html_class_prefix . 'game-type-item-title '.'" >'. __("Find the translation", $this->plugin_name ) . '</div>';
					$content[] = '</div>';
				$content[] = '</label>';

			$content[] = '</div>';

			$content[] = '<div class="' . $this->html_class_prefix . 'games-type-content '.'" >';
				$content[] = '<div class="' . $this->html_class_prefix . 'games-type-content-settings '.'" ></div>';
				$content[] = '<form method="POST" class="' . $this->html_class_prefix . 'games-type-content-game '.'" ></form>';
			$content[] = '</div>';

		$content[] = '</div>';

		$content[] = '<div class="ays-pd-preloader">
			<img class="loader" src="'. PERSONAL_DICTIONARY_PUBLIC_URL .' /images/loaders/3-1.svg">
		</div>';

		$content = implode( '', $content );
		return $content;
	}

	public function import_tab(){
		global $wpdb;
		$content = array();
		if(isset( $_POST['ays-pd-import-save-btn'])){
			if( isset( $_FILES['ays-pd-import-file'] ) ){
				$stats = $this->ays_import_pd($_FILES['ays-pd-import-file']);

				$url = esc_url_raw( remove_query_arg('ays-pd-tab') );
				wp_redirect( $url );
			}
		}
		$user_id = get_current_user_id();
		$categories_table = esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'categories');
		$sql  = "SELECT * FROM ".$categories_table ." WHERE user_id = " . $user_id ."  ORDER BY id DESC";
		$groups = $wpdb->get_results($sql, 'ARRAY_A');


		$content[] = '<div class="' . $this->html_class_prefix . 'import-tab '. $this->html_class_prefix . 'tab-content'. '"  data-function="ays_import_pd">';

		$content[] = '<form method="post" enctype="multipart/form-data">';

		$content[] = '<div class="' . $this->html_class_prefix . 'import-tab-item ' . $this->html_class_prefix . 'import-select-file '. '" >';
		$content[] = '<input type="file" name="' . $this->html_class_prefix . 'import-file'. '" id="' . $this->html_class_prefix . 'import_file'. '"/>';
		$content[] = '</div>';	

		$content[] = '<div class="' . $this->html_class_prefix . 'import-tab-item ' . $this->html_class_prefix . 'import-select-group-block '. '" >';
		$content[] = '<select class="' . $this->html_class_prefix . 'import-select'. '" name="' . $this->html_class_prefix . 'import-select'. '" >';
		$content[] = '<option value="new_group">' .  __('New Group', $this->plugin_name) . '</option>';
		$content[] = '<option disabled>___________</option>';
		foreach ($groups as $key => $value) {
			$content[] = '<option value="'.$value['id'].'">' .  __( $value['name'] , $this->plugin_name) . '</option>';

		}
		$content[] = '</select>';
		$content[] = '</div>';

		$content[] = '<div class="' . $this->html_class_prefix . 'import-tab-item ' . $this->html_class_prefix . 'import-save-button '. '" >';
		$content[] = '<input type="submit" name="' . $this->html_class_prefix . 'import-save-btn'. '" value="Import now" id="' . $this->html_class_prefix . 'import-save-btn'. '" disabled />';
		$content[] = '</div>';	

		$content[] = '</form>';	

		$content[] = '</div>';
		$content[] =  '<div class="ays-pd-preloader">
				<img class="loader" src="'. PERSONAL_DICTIONARY_PUBLIC_URL .' /images/loaders/3-1.svg">
			</div>';
			$content = implode( '',$content );
		return $content;
	}

	public function get_custom_css(){
		
        $content = array();
        if( $this->options[ $this->name_prefix . 'custom_css' ] != '' ){

            $content[] = '<style type="text/css">';
            
	        	$content[] = $this->options[ $this->name_prefix . 'custom_css' ];
            
            $content[] = '</style>';
            
        }

        $content = implode( '', $content );

    	return $content;
    }

	public function get_encoded_options( $limit ){
        
        $content = array();

        if( $limit ){
                
            $content[] = '<script type="text/javascript">';

            // $this->options['is_user_logged_in'] = is_user_logged_in();
        
            $content[] = "
                    if(typeof aysPdOptions === 'undefined'){
                        var aysPdOptions = [];
                    }
                    aysPdOptions  = '" . base64_encode( json_encode( $this->options ) ) . "';";
            
            $content[] = '</script>';
            
        }

        $content = implode( '', $content );

    	return $content;
    }

	public function get_styles(){
		
		$content = array();

		$filtered_main_color = Personal_Dictionary_Data::hex2rgba( $this->options[ $this->name_prefix . 'main_color' ] , 0.65 );
		

        $content[] = '<style type="text/css">';
		

       
        $content[] = ' 

       		 div#' . $this->html_class_prefix . 'box_id.' . $this->html_class_prefix . 'box {
                background-color: ' . $this->options[ $this->name_prefix . 'bg_color' ] . ';
            }
            
			div#' . $this->html_class_prefix . 'box_id > div[id=ays-pd-container_id] {
                background-color: ' . $this->options[ $this->name_prefix . 'bg_color' ] . ';
            }

			div#' . $this->html_class_prefix . 'box_id input[type="button"] , input[type="submit"] {
                background-color: ' . $this->options[ $this->name_prefix . 'main_color' ] . ';
            }

			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'header_id  {
                background-color: ' . $this->options[ $this->name_prefix . 'main_color' ] . ';
            }

			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id div.' . $this->html_class_prefix . 'nav-menu a.' . $this->html_class_prefix . 'nav-tab {
				background-color: ' . $this->options[ $this->name_prefix . 'main_color' ] . ';
            }

			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id div.' . $this->html_class_prefix . 'content .' . $this->html_class_prefix . 'group-tab div.' . $this->html_class_prefix . 'each_group_item {
				background-color: ' . Personal_Dictionary_Data::hex2rgba( $this->options[ $this->name_prefix . 'main_color' ] , 0.2 ) . ';
			}
			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id div.' . $this->html_class_prefix . 'content .' . $this->html_class_prefix . 'group-tab div.' . $this->html_class_prefix . 'words-each-item-block {
				background-color: ' . Personal_Dictionary_Data::hex2rgba( $this->options[ $this->name_prefix . 'main_color' ] , 0.2 ) . ';
			}

			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id div.' . $this->html_class_prefix . 'content div.' . $this->html_class_prefix . 'save-groups-block {
				background-color: ' . Personal_Dictionary_Data::hex2rgba( $this->options[ $this->name_prefix . 'main_color' ] , 0.2 ) . ';
			}


			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id div.' . $this->html_class_prefix . 'content div.' . $this->html_class_prefix . 'game-type-item {
				background-color: ' . $this->options[ $this->name_prefix . 'main_color' ] . ';
				color: ' . $this->options[ $this->name_prefix . 'text_color' ] .';
			}

			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id div.' . $this->html_class_prefix . 'content div.' . $this->html_class_prefix . 'group-tab-words {
				background-color: ' . Personal_Dictionary_Data::hex2rgba( $this->options[ $this->name_prefix . 'main_color' ] , 0.2 ) . ';
				color: ' . $this->options[ $this->name_prefix . 'text_color' ] .';
			}

			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id div.' . $this->html_class_prefix . 'content div.' . $this->html_class_prefix . 'games-type-content div.' . $this->html_class_prefix . 'games-type-content-game-box  div.' . $this->html_class_prefix . 'game-fields label {
				
				color: ' . $this->options[ $this->name_prefix . 'text_color' ] .';
			}

			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id div.' . $this->html_class_prefix . 'content div.' . $this->html_class_prefix . 'games-type-content div.' . $this->html_class_prefix . 'games-type-content-game-box  div.' . $this->html_class_prefix . 'game-fields label {
				background-color: ' . Personal_Dictionary_Data::hex2rgba( $this->options[ $this->name_prefix . 'main_color' ] , 0.2 ) . ';
				color: ' . $this->options[ $this->name_prefix . 'text_color' ] .';
			}

			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id div.' . $this->html_class_prefix . 'content div.' . $this->html_class_prefix . 'games-type-content div.' . $this->html_class_prefix . 'games-type-content-game-box  div.' . $this->html_class_prefix . 'game-fields label:hover {
				background-color: ' . Personal_Dictionary_Data::hex2rgba( $this->options[ $this->name_prefix . 'main_color' ] , 0.8 ) . ';
				color: ' . $this->options[ $this->name_prefix . 'text_color' ] .';
			}

			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id div.' . $this->html_class_prefix . 'content div.' . $this->html_class_prefix . 'games-type-content div.' . $this->html_class_prefix . 'games-type-content-game-box  div.' . $this->html_class_prefix . 'game-fields	 .checked_answer {
				background-color: ' .  Personal_Dictionary_Data::hex2rgba( $this->options[ $this->name_prefix . 'main_color' ] , 0.8 ) . ';
				color: ' . $this->options[ $this->name_prefix . 'text_color' ] .';
				font-weight: bold;
			}

			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id div.' . $this->html_class_prefix . 'content .no_selected {
					background-color: ' . Personal_Dictionary_Data::hex2rgba( $this->options[ $this->name_prefix . 'main_color' ] , 0.2 ) . ';
				color: ' . $this->options[ $this->name_prefix . 'text_color' ] .';
			}

			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id div.' . $this->html_class_prefix . 'content .' . $this->html_class_prefix . 'group-tab div.' . $this->html_class_prefix . 'each_group_item .ays-pd_each_group_name {
				color: ' . $this->options[ $this->name_prefix . 'text_color' ] .';
			}

			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id div.' . $this->html_class_prefix . 'content .' . $this->html_class_prefix . 'group-tab div.' . $this->html_class_prefix . 'each_group_item .ays-pd_each_group_title_words_count {
				color: ' . $this->options[ $this->name_prefix . 'text_color' ] .';
			}

			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id div.' . $this->html_class_prefix . 'content .' . $this->html_class_prefix . 'group-tab div.' . $this->html_class_prefix . 'words-each-item-block span.' . $this->html_class_prefix . 'each_word_span,
			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id div.' . $this->html_class_prefix . 'content .' . $this->html_class_prefix . 'group-tab div.' . $this->html_class_prefix . 'words-each-item-block span.' . $this->html_class_prefix . 'each_translation {
				color: ' . $this->options[ $this->name_prefix . 'text_color' ] .';
			}

			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id div.' . $this->html_class_prefix . 'content .' . $this->html_class_prefix . 'group-tab div.' . $this->html_class_prefix . 'each_group_item div.' . $this->html_class_prefix . 'dropdown-buttons button:hover {
				background-color: ' .  Personal_Dictionary_Data::hex2rgba( $this->options[ $this->name_prefix . 'main_color' ], 0.2 ) . ';
			}

			div#' . $this->html_class_prefix . 'box_id div#' . $this->html_class_prefix . 'container_id input[type="submit"]:hover {
				background-color: ' . $this->options[ $this->name_prefix . 'main_color' ] . ';
				color: ' . $this->options[ $this->name_prefix . 'text_color' ] .';
			}

            ';
    	
    	$content[] = '</style>';

    	$content = implode( '', $content );

    	return $content;
    }
}
