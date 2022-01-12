<?php 
    class Personal_Dictionary_Dictionaries{
        private $plugin_name;

        public function __construct($plugin_name) {
            $this->plugin_name = $plugin_name;
        }

        // Get words count
        public function ays_pd_get_words(){
            global $wpdb;
            $dictionary_words = $wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . "words";
            $sql = "SELECT COUNT(id) AS count FROM ".$dictionary_words;
            $result = $wpdb->get_var($sql);
            if(isset($result) && $result != ''){
                return intval($result);
            }
            return false;
        }

        // Get group count
        public function ays_pd_get_categories(){
            global $wpdb;
            $dictionary_categories = $wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . "categories";
            $sql = "SELECT COUNT(id) AS count FROM ".$dictionary_categories;
            $result = $wpdb->get_var($sql);
            if(isset($result) && $result != ''){
                return intval($result);
            }
            return false;
        }

        // Get users count
        public function ays_pd_get_users(){
            global $wpdb;
            $dictionary_categories = $wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . "categories";
            $sql = "SELECT user_id FROM ".$dictionary_categories." GROUP BY user_id";
            $result = $wpdb->get_results($sql , "ARRAY_A");
            if(isset($result) && $result != ''){
                return count($result);
            }
            return false;
        }

        // Get games count
        public function ays_pd_get_reports(){
            global $wpdb;
            $dictionary_reports = $wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . "reports";
            $sql = "SELECT COUNT(id) AS count FROM ".$dictionary_reports;
            $result = $wpdb->get_var($sql);
            if(isset($result) && $result != ''){
                return $result;
            }
            return false;
        }
    }
?>