<?php
    class Personal_Dictionary_Settings_Actions{
        private $plugin_name;

        public function __construct($plugin_name) {
            $this->plugin_name = $plugin_name;
        }

        // Store Global settings
        public function ays_pd_store_global_settings(){
            global $wpdb;

            // Default options
            $meta_options = array(
                // "check_true_count"       => "4",
                "learned_points"         => 10,
                "right_points"           => 1,
                "wrong_points"           => -0.25,
                // "show_correct_answer"    => "off",
                // "word_sorting"           => "word",
                "bg_color"               => "#ffffff",
                "main_color"             => "#3f72af",
                "text_color"             => "#ffffff",
                "custom_css"             => "",
            );

            if( isset( $_POST["ays_pd_submit_top"] ) ){
                // Update options after save
                // $check_true_count     = isset($_POST['ays_pd_true_check_count']) && $_POST['ays_pd_true_check_count'] != '' ? sanitize_text_field($_POST['ays_pd_true_check_count']) : "4";
                $learned_points = isset($_POST['ays_pd_learned_points']) && $_POST['ays_pd_learned_points'] != '' ? floatval( sanitize_text_field( $_POST['ays_pd_learned_points'] ) ) : 10;
                $right_points = isset($_POST['ays_pd_right_points']) && $_POST['ays_pd_right_points'] != '' ? floatval( sanitize_text_field( $_POST['ays_pd_right_points'] ) ) : 1;
                $wrong_points = isset($_POST['ays_pd_wrong_points']) && $_POST['ays_pd_wrong_points'] != '' ? floatval( sanitize_text_field( $_POST['ays_pd_wrong_points'] ) ) : -0.25;
                // $show_correct_answer  = isset($_POST['ays_pd_show_correct_points']) && $_POST['ays_pd_show_correct_points'] == 'on' ? "on" : "off";
                // $word_sorting         = isset($_POST['ays_pd_default_sorting_points']) && $_POST['ays_pd_default_sorting_points'] != '' ? sanitize_text_field($_POST['ays_pd_default_sorting_points']) : "word";
                $bg_color   = isset($_POST['ays_pd_bg_color']) && $_POST['ays_pd_bg_color'] != '' ? sanitize_text_field( $_POST['ays_pd_bg_color'] ) : "#ffffff";
                $main_color = isset($_POST['ays_pd_main_color']) && $_POST['ays_pd_main_color'] != '' ? sanitize_text_field( $_POST['ays_pd_main_color'] ) : "#3f72af";
                $text_color = isset($_POST['ays_pd_text_color']) && $_POST['ays_pd_text_color'] != '' ? sanitize_text_field( $_POST['ays_pd_text_color'] ) : "#000";

                if( isset($_POST['ays_pd_custom_css']) && $_POST['ays_pd_custom_css'] != '' ){
                    if( function_exists( 'sanitize_textarea_field' ) ){
                        $custom_css = sanitize_textarea_field( $_POST['ays_pd_custom_css'] );
                    }else{
                        $custom_css = sanitize_text_field( $_POST['ays_pd_custom_css'] );
                    }
                }else{
                    $custom_css = "";
                }

                // Set options
                // $meta_options['check_true_count']    = $check_true_count;
                $meta_options['learned_points'] = $learned_points;
                $meta_options['right_points'] = $right_points;
                $meta_options['wrong_points'] = $wrong_points;
                // $meta_options['show_correct_answer'] = $show_correct_answer;
                // $meta_options['word_sorting']        = $word_sorting;
                $meta_options['bg_color']   = $bg_color;
                $meta_options['main_color'] = $main_color;
                $meta_options['text_color'] = $text_color;
                $meta_options['custom_css'] = $custom_css;
                $global_settings = $this->ays_pd_get_setting();
                if(!$global_settings){
                    $global_settings = array();
                }
                $added_values = array_diff_key($meta_options , $global_settings);
                if(!$global_settings){
                    $result = $this->ays_pd_add_setting($meta_options,"", "");
                }
                else if(!empty($added_values)){
                    $result = $this->ays_pd_add_setting($added_values,"", "");
                }
                else{
                    $result = $this->ays_pd_update_setting($meta_options ,"", "");
                }
            }
        }

        // Add global settings
        public static function ays_pd_add_setting($metas , $note = "", $options = ""){
            global $wpdb;
            $dictionary_global_settings = esc_sql( $wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . "globsettings" );
            if(isset($metas) && !empty($metas)){
                foreach($metas as $m_key => $m_value){
                    $result = $wpdb->insert(
                        $dictionary_global_settings,
                        array(
                            'meta_key'   => $m_key,
                            'meta_value' => $m_value,
                            'note'       => "",
                            'options'    => ""
                        ),
                        array( '%s', '%s', '%s', '%s' )
                    );

                }
                if($result >= 0){
                    return true;
                }
            }
            return false;
        }

        // Update global settings
        public static function ays_pd_update_setting($metas, $notes = "", $options = ""){
            global $wpdb;
            $dictionary_global_settings = esc_sql( $wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . "globsettings" );
            if(isset($metas) && !empty($metas)){
                foreach($metas as $m_key => $m_value){
                    $result = $wpdb->update(
                        $dictionary_global_settings,
                        array(
                            'meta_value' => $m_value,
                            'note'       => $notes,
                            'options'    => $options
                        ),
                        array(
                            'meta_key' => $m_key
                        ),
                        array(
                            '%s', '%s', '%s'
                        ),
                        array(
                            '%s'
                        )
                    );

                }
                if($result >= 0){
                    return true;
                }
            }
            return false;
        }

        // Get global settings
        public static function ays_pd_get_setting(){
            global $wpdb;
            $settings_table = $wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . "globsettings";
            $sql = "SELECT * FROM ".$settings_table;
            $result = $wpdb->get_results($sql ,"ARRAY_A");
            $values = array();
            if(isset($result) && !empty($result)){
                foreach($result as $key => $value){
                    $values[$value['meta_key']] = $value["meta_value"];
                }
                return $values;
            }
            return false;
        }
}
?>