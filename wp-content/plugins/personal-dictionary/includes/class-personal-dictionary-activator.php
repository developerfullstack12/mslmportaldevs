<?php
global $ays_pd_db_version;
$ays_pd_db_version = '1.0.0';

/**
 * Fired during plugin activation
 *
 * @link       https://ays-pro.com
 * @since      1.0.0
 *
 * @package    Personal_Dictionary
 * @subpackage Personal_Dictionary/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Personal_Dictionary
 * @subpackage Personal_Dictionary/includes
 * @author     Personal Dictionary Team <info@ays-pro.com>
 */
class Personal_Dictionary_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
        global $ays_pd_db_version;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $installed_ver          = get_option( "ays_pd_db_version" );
        $words_table            = $wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'words';
        $categories_table       = $wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'categories';
        $reports_table          = $wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'reports';
        $settings_table         = $wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'settings';
        $globsettings_table     = $wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'globsettings';
 
        $charset_collate = $wpdb->get_charset_collate();

        if($installed_ver != $ays_pd_db_version)  {

            $sql = "CREATE TABLE `".$words_table."` (
                `id` INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
				`user_id` INT(11) UNSIGNED NOT NULL,
                `category_id` INT(11) UNSIGNED NOT NULL,
                `word` TEXT NOT NULL DEFAULT '',
                `translation` TEXT NULL DEFAULT '',
                `point` DOUBLE NULL DEFAULT NULL,
                `completed` TINYINT(1) NULL DEFAULT '0',
                `percentage` DOUBLE NULL DEFAULT NULL,
                `corrects_count` INT(11) NULL DEFAULT '0',
                `failed_count` INT(11) NULL DEFAULT '0',
                `attempts_count` INT(11) NULL DEFAULT '0',
				`date_created` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
                `date_modified` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
                PRIMARY KEY (`id`)
            )$charset_collate;";

            $sql_schema = "SELECT * FROM INFORMATION_SCHEMA.TABLES
                           WHERE table_schema = '".DB_NAME."' AND table_name = '".$words_table."' ";
            $results = $wpdb->get_results($sql_schema);

            if(empty($results)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }

            $sql = "CREATE TABLE `".$categories_table."` (
                `id` INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
                `user_id` INT(11) UNSIGNED NOT NULL,
                `name` TEXT NOT NULL DEFAULT '',
                `parent` TINYINT(1) NULL DEFAULT '0',
                `parent_id` INT(11) UNSIGNED NULL DEFAULT '0',
				`date_created` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
                PRIMARY KEY (`id`)
            )$charset_collate;";

            $sql_schema = "SELECT * FROM INFORMATION_SCHEMA.TABLES
                           WHERE table_schema = '".DB_NAME."' AND table_name = '".$categories_table."' ";
            $results = $wpdb->get_results($sql_schema);

            if(empty($results)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }

            $sql = "CREATE TABLE `".$reports_table."` (
                `id` INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
				`user_id` INT(11) UNSIGNED NOT NULL,
                `words_ids` TEXT NULL DEFAULT '',
                `categories_ids` TEXT NULL DEFAULT '',
                `score` VARCHAR(256) NULL DEFAULT '',
                `words_count` INT(11) NULL DEFAULT 0,
                `game_type` VARCHAR(256) NULL DEFAULT '',
                `points` DOUBLE NULL DEFAULT 0, 
				`complete_date` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
                PRIMARY KEY (`id`)
            )$charset_collate;";

            $sql_schema = "SELECT * FROM INFORMATION_SCHEMA.TABLES
                           WHERE table_schema = '".DB_NAME."' AND table_name = '".$reports_table."' ";
            $results = $wpdb->get_results($sql_schema);

            if(empty($results)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }

			$sql="CREATE TABLE `".$settings_table."` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `user_id` INT(11) UNSIGNED NOT NULL,
                `meta_key` TEXT NULL DEFAULT NULL,
                `meta_value` TEXT NULL DEFAULT NULL,
                `note` TEXT NULL DEFAULT NULL,
                `options` TEXT NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            )$charset_collate;";

			$sql_schema = "SELECT * FROM INFORMATION_SCHEMA.TABLES
			WHERE table_schema = '".DB_NAME."' AND table_name = '".$settings_table."' ";
			$results = $wpdb->get_results($sql_schema);

			if(empty($results)){
			$wpdb->query( $sql );
			}else{
			dbDelta( $sql );
			}

			$sql="CREATE TABLE `".$globsettings_table."` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `meta_key` TEXT NULL DEFAULT NULL,
                `meta_value` TEXT NULL DEFAULT NULL,
                `note` TEXT NULL DEFAULT NULL,
                `options` TEXT NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            )$charset_collate;";

			$sql_schema = "SELECT * FROM INFORMATION_SCHEMA.TABLES
			WHERE table_schema = '".DB_NAME."' AND table_name = '".$globsettings_table."' ";
			$results = $wpdb->get_results($sql_schema);

			if(empty($results)){
			$wpdb->query( $sql );
			}else{
			dbDelta( $sql );
			}

            update_option( 'ays_pd_db_version', $ays_pd_db_version );

	    }
    }

	public static function ays_pd_update_db_check() {
        global $ays_pd_db_version;
        if ( get_site_option( 'ays_pd_db_version' ) != $ays_pd_db_version ) {
            self::activate();
        }
    }

}
