<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Personal_Dictionary
 * @subpackage Personal_Dictionary/includes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Personal_Dictionary
 * @subpackage Personal_Dictionary/includes
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Personal_Dictionary_Data {

    public static function get_pd_validated_data_from_array($pd){
        global $wpdb;
        // Array for survey validated options
        $settings = array();
        $name_prefix = 'pd_';
        $options = array();
        foreach ($pd as $key => $value) {
            $options[$value['meta_key']] = $value['meta_value'];
        }

        // PD options
        if( isset( $pd->options ) && $pd->options != '' ){
            $options = json_decode( $pd->options, true );
        }


        $settings[ $name_prefix . 'learned_points' ] = (isset($options['learned_points']) && $options['learned_points' ] != '') ? abs( floatval( sanitize_text_field( $options['learned_points' ] ) ) ) : 10;

        $settings[ $name_prefix . 'right_points' ] = (isset($options['right_points' ]) && $options['right_points' ] != '') ? abs( floatval( sanitize_text_field( $options['right_points' ] ) ) ) : 1; 
 
        $settings[ $name_prefix . 'wrong_points' ] = (isset($options['wrong_points' ]) && $options['wrong_points' ] != '') ? abs( floatval( sanitize_text_field( $options['wrong_points' ] ) ) ) : 0.25;

        // $settings[ $name_prefix . 'show_correct_answer' ] = (isset($options['show_correct_answer' ]) && $options['show_correct_answer' ] == 'on') ? stripslashes ( sanitize_text_field( $options['show_correct_answer' ] ) ) : 'off';

        // $settings[ $name_prefix . 'word_sorting' ] = (isset($options['word_sorting' ]) && $options['word_sorting' ] != '') ? stripslashes ( sanitize_text_field( $options['word_sorting' ] ) ) : 'word';

        $settings[ $name_prefix . 'bg_color' ] = (isset($options['bg_color' ]) && $options['bg_color' ] != '') ?  sanitize_text_field( $options[ 'bg_color' ] )  : '#ffffff';

        $settings[ $name_prefix . 'main_color' ] = (isset($options['main_color' ]) && $options['main_color' ] != '') ?  sanitize_text_field( $options[ 'main_color' ] )  : '#3f72af';
        
        $settings[ $name_prefix . 'text_color' ] = (isset($options['text_color' ]) && $options['text_color' ] != '') ?  sanitize_text_field( $options[ 'text_color' ] ) : '#000';

        // Custom CSS
        $settings[ $name_prefix . 'custom_css' ] = (isset($options['custom_css' ]) && $options['custom_css' ] != '') ? stripslashes( sanitize_textarea_field( $options['custom_css'] ) ) : '';
        
        return $settings;
    }

     public static function get_pd_globsettings(){
        global $wpdb;
        $globsettings_table = $wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'globsettings';
        $sql = "SELECT *
                FROM {$globsettings_table}";
        $pd = $wpdb->get_results( $sql ,'ARRAY_A');
        return $pd;
    }

    public static function hex2rgba($color, $opacity = false){

        $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if (empty($color))
            return $default;

        //Sanitize $color if "#" is provided
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }else{
            return $color;
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb = array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if ($opacity) {
            if (abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
        } else {
            $output = 'rgb(' . implode(",", $rgb) . ')';
        }

        //Return rgb(a) color string
        return $output;
    }


    
}
