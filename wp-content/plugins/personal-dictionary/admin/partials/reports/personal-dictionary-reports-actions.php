<?php
    class Personal_Dictionary_Reports_Actions{
        private $plugin_name;

        public function __construct($plugin_name) {
            $this->plugin_name = $plugin_name;
        }

        public function get_games_count_line_chart(){
            global $wpdb;
            $reports_table 	= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'reports');
            $sql = "SELECT DATE(`complete_date`) AS date, COUNT(*) AS value FROM $reports_table GROUP BY date";
            $result = $wpdb->get_results( $sql, 'ARRAY_A' );
    
            foreach ($result as $key => &$value) {
                $value['value'] = intval($value['value']);
                $value = array_values($value);
            }

            return $result;        
        }

        public static function get_games_count_by_days($days){
            global $wpdb;
            $user_id = get_current_user_id();
            $reports_table 	= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'reports');
            $today = current_time( 'mysql' );
            $given_date = date("Y-m-d H:i:s", strtotime("-$days day", strtotime( $today )));
            $difference_date = date("Y-m-d H:i:s", strtotime("-$days day", strtotime( $given_date )));

            $sql = "SELECT COUNT(*) AS `count`
                    FROM $reports_table r ";

            $sql .= " WHERE r.complete_date >= '$given_date' ";
    
    
            $difference_sql = "SELECT COUNT(*) AS `count`
                                FROM $reports_table r ";
            
            $difference_sql .= " WHERE complete_date >= '$difference_date' AND complete_date <= '$given_date'";
            
    
            $given_dates_results = $wpdb->get_var($sql);
            $difference_date_results = $wpdb->get_var($difference_sql);
            $difference_games_count = intval($difference_date_results);
            $games_count = intval($given_dates_results);

            if($difference_games_count == 0){
                $difference = 100;
            }else{
                if($games_count - $difference_games_count == 0){
                    $difference = 0;
                }else{
                    $difference = round((($games_count-$difference_games_count)/$difference_games_count)*100);
    
                }
            }
    
    
            if(is_nan($difference)) $difference = 0;
            $result = array(
                'difference'    => $difference,
                'games_count' => $games_count
            );
            return $result;
        }

        public function get_words_count_line_chart(){
            global $wpdb;
            $words_table 	= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'words');
            $sql = "SELECT DATE(`date_created`) AS date, COUNT(*) AS value FROM $words_table GROUP BY date";
            $result = $wpdb->get_results( $sql, 'ARRAY_A' );
            foreach ($result as $key => &$value) {
                $value['value'] = intval($value['value']);
                $value = array_values($value);
            }
            

            return $result;        
        }

        public function get_users_count_line_chart(){
            global $wpdb;
            $settings_table 	= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'settings');
            $sql = "SELECT DATE(`meta_value`) AS date, COUNT(*) AS value FROM $settings_table GROUP BY date";
            $result = $wpdb->get_results( $sql, 'ARRAY_A' );
            foreach ($result as $key => &$value) {
                $value['value'] = intval($value['value']);
                $value = array_values($value);
            }

            return $result;        
        }

        public static function get_complete_words_count(){
            global $wpdb;
            $user_id = get_current_user_id();
            $words_table 	= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'words');
          

            $sql = "SELECT COUNT(*) AS count FROM $words_table";
            $words = $wpdb->get_var( $sql );


            $sql2 = "SELECT COUNT(*) AS count FROM $words_table WHERE completed = 1 ";
            $learned_words = $wpdb->get_var( $sql2 );

            if($words > 0){
                $percentage = round(($learned_words/$words)*100);
            }else{
                $percentage = 0;
            }
            $result = array(
                'percentage'    => $percentage
            );
            return $result;
        }

        public static function get_inactive_users_count(){
            global $wpdb;
            $user_id = get_current_user_id();
            $settings_table 	= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'settings');
            $reports_table 	= esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'reports');
            $today = current_time( 'mysql' );
            $given_date = date("Y-m-d H:i:s", strtotime("-30 day", strtotime( $today )));
            $count = 0;
         
            $sql = "SELECT user_id FROM $settings_table WHERE meta_key = 'register_date' GROUP BY user_id  " ;
            $all_users = $wpdb->get_results( $sql,'ARRAY_A' );

           
            $sql = "SELECT user_id FROM $reports_table WHERE complete_date >= '$given_date' GROUP BY user_id  " ;
            $users = $wpdb->get_results( $sql,'ARRAY_A' );

            $users_arr = array();
             foreach($users as $key => $value ){
                array_push($users_arr,$value['user_id']);
            }

             foreach ($all_users as $key => $value) {
                if(!in_array($value['user_id'], $users_arr)){
                    $count++;
                }
             }
          
            return $count;
        }

    }