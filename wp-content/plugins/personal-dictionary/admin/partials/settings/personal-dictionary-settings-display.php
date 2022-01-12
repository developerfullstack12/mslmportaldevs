<?php
    $global_actions = new Personal_Dictionary_Settings_Actions($this->plugin_name);        
    $global_actions->ays_pd_store_global_settings();
    $options = $global_actions->ays_pd_get_setting();

    // Defaults
    // $check_true_count    = "4";
    $learned_points      = 10;
    $right_points        = 1;
    $wrong_points        = -0.25;
    // $show_correct_answer = "";
    // $word_sorting        = "word";
    $bg_color            = "#ffffff";
    $main_color          = "#3f72af";
    $text_color          = "#000";
    $custom_css          = "";

    // Check options
    if(isset($options) && !empty($options)){
        // $check_true_count    = isset($options['check_true_count']) && $options['check_true_count'] != '' ? esc_attr($options['check_true_count']) : $check_true_count;
        $learned_points      = isset($options['learned_points']) && $options['learned_points'] != '' ? esc_attr(floatval($options['learned_points'])) : 10;
        $right_points        = isset($options['right_points']) && $options['right_points'] != '' ? esc_attr(floatval($options['right_points'])) : 1;
        $wrong_points        = isset($options['wrong_points']) && $options['wrong_points'] != '' ? esc_attr(floatval($options['wrong_points'])) : -0.25;
        // $show_correct_answer = isset($options['show_correct_answer']) && $options['show_correct_answer'] == 'on' ? "checked" : '';
        // $word_sorting        = isset($options['word_sorting']) && $options['word_sorting'] != '' ? esc_attr($options['word_sorting']) : $word_sorting;
        $bg_color            = isset($options['bg_color']) && $options['bg_color'] != '' ? esc_attr($options['bg_color']) : $bg_color;
        $main_color          = isset($options['main_color']) && $options['main_color'] != '' ? esc_attr($options['main_color']) : $main_color;
        $text_color          = isset($options['text_color']) && $options['text_color'] != '' ? esc_attr($options['text_color']) : $text_color;
        $custom_css          = isset($options['custom_css']) && $options['custom_css'] != '' ? esc_attr($options['custom_css']) : $custom_css ;
    }

    // // Sortig select options
    // $word_sorting_options = array(
    //     "date"         => __("Date" , $this->plugin_name),
    //     "alpha"        => __("Word" , $this->plugin_name),
    //     "alpha_trans"  => __("Translation" , $this->plugin_name),
    //     "learnt_level" => __("Learnt level" , $this->plugin_name),
    // );
    // $selected_sorting = "";
    // $selected_option  = "";
    // foreach($word_sorting_options as $s_key => $s_value){
    //     $selected_sorting = $word_sorting == $s_key ? "selected" : "";
    //     $selected_option .= "<option value=".$s_key." ".$selected_sorting.">".$s_value."</option>";
    // }

?>

<div class="wrap">
    <form method="post" id="ays-export-form">
        <div class="container-fluid">
            <h1 class="wp-heading-inline">
                <?php
                echo __(esc_html(get_admin_page_title()),$this->plugin_name);
                ?>
            </h1>

            <div id="tab1" class="ays-pd-tab-content ays-pd-tab-content-active">                
                <p class="ays-pd-subtitle"><?php echo __("General settings" , $this->plugin_name)?></p>
                <!-- <hr>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <?php echo __('Attempts count', $this->plugin_name); ?>
                        <label for="ays_pd_true_check_count">
                            <a class="ays_help" data-toggle="tooltip" data-placement="top" title="<?php echo __("Specify after how many attempts the word will be considered already learned.", $this->plugin_name); ?>">
                                <i class="ays_fa_pd ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6 ays_divider_left">
                        <input type="number" id="ays_pd_true_check_count" name="ays_pd_true_check_count" value="<?php ?>">
                    </div>
                </div> -->
                <hr>
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="ays_pd_learned_points">
                            <?php echo __('Learnt points', $this->plugin_name); ?>
                            <a class="ays_help" data-toggle="tooltip" data-placement="top" title="<?php echo __("Specify a point value for a word to be considered learned. This option works with the right and wrong answer points options.", $this->plugin_name); ?>">
                                <i class="ays_fa_pd ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-8 ays_divider_left">
                        <input type="text" id="ays_pd_learned_points" name="ays_pd_learned_points" value="<?php echo $learned_points;?>">
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="ays_pd_right_points">
                            <?php echo __('Right answer points', $this->plugin_name); ?>
                            <a class="ays_help" data-toggle="tooltip" data-placement="top" title="<?php echo __("Specify the point value for users’ right answers. In case of a right answer, these points will be added to the point of the word and will positively affect the result.", $this->plugin_name); ?>">
                                <i class="ays_fa_pd ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-8 ays_divider_left">
                        <input type="text" id="ays_pd_right_points" name="ays_pd_right_points" value="<?php echo $right_points;?>">
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="ays_pd_wrong_points">
                            <?php echo __('Wrong answer points (-)', $this->plugin_name); ?>
                            <a class="ays_help" data-toggle="tooltip" data-placement="top" title="<?php echo __("Specify the point value for users’ wrong answers. In case of a wrong answer, these points will be added to the point of the word and will negatively affect the result.", $this->plugin_name); ?>">
                                <i class="ays_fa_pd ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-8 ays_divider_left">
                        <input type="text" id="ays_pd_wrong_points" name="ays_pd_wrong_points" value="<?php echo $wrong_points;?>">
                    </div>
                </div>
                <!-- <hr>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <?php echo __('Show correct answer', $this->plugin_name); ?>
                        <label for="ays_pd_show_correct_points">
                            <a class="ays_help" data-toggle="tooltip" data-placement="top" title="<?php echo __("Specify after how many attempts the word will be considered already learned.", $this->plugin_name); ?>">
                                <i class="ays_fa_pd ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6 ays_divider_left">
                        <input type="checkbox" id="ays_pd_show_correct_points" name="ays_pd_show_correct_points" value="on" <?php  ?>>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <?php echo __('Sorting words in groups by', $this->plugin_name); ?>
                        <label for="ays_pd_default_sorting_points">
                            <a class="ays_help" data-toggle="tooltip" data-placement="top" title="<?php echo __("Specify after how many attempts the word will be considered already learned.", $this->plugin_name); ?>">
                                <i class="ays_fa_pd ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6 ays_divider_left" id="ays_default_sorting_box">
                        <select name="ays_pd_default_sorting_points" id="ays_pd_default_sorting_points" class="ays-pd-select">
                            <?php ?>
                        </select>
                    </div>
                </div> GENERAL SETTINGS  -->
                <hr>
                <p class="ays-pd-subtitle"><?php echo __("Styles" , $this->plugin_name)?></p>
                <hr>
                 <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="ays_pd_bg_color">
                            <?php echo __('Background Color', $this->plugin_name); ?>
                            <a class="ays_help" data-toggle="tooltip" data-placement="top" title="<?php echo __("On the color picker, choose the background color of your dictionary and make it opaque if you wish. If you Clear the color, it will take the default value – white.", $this->plugin_name); ?>">
                                <i class="ays_fa_pd ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-8 ays_divider_left">
                        <input type="text" id="ays_pd_bg_color" name="ays_pd_bg_color" data-alpha="true" value="<?php echo $bg_color; ?>">
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="ays_pd_main_color">
                            <?php echo __('Main Color', $this->plugin_name); ?>
                            <a class="ays_help" data-toggle="tooltip" data-placement="top" title="<?php echo __("On the color picker, choose the main color of your dictionary and make it opaque if you wish. If you Clear the color, it will take the default value – blue.", $this->plugin_name); ?>">
                                <i class="ays_fa_pd ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-8 ays_divider_left">
                        <input type="text" id="ays_pd_main_color" name="ays_pd_main_color" data-alpha="true" value="<?php echo $main_color; ?>">
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="ays_pd_text_color">
                            <?php echo __('Text Color', $this->plugin_name); ?>
                            <a class="ays_help" data-toggle="tooltip" data-placement="top" title="<?php echo __("On the color picker, choose the text color of your dictionary and make it opaque if you wish. If you Clear the color, it will take the default value – black.", $this->plugin_name); ?>">
                                <i class="ays_fa_pd ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-8 ays_divider_left">
                        <input type="text" id="ays_pd_text_color" name="ays_pd_text_color" data-alpha="true" value="<?php echo $text_color; ?>">
                    </div>
                </div><!-- STYLES -->
                <hr>
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="ays_custom_css">
                            <?php echo __('Custom CSS',$this->plugin_name)?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Enter your CSS code on the field.',$this->plugin_name)?>">
                                <i class="ays_fa_pd ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-8 ays_divider_left">
                    <textarea class="ays-textarea" id="ays_custom_css" name="ays_pd_custom_css" cols="30"
                                rows="10"><?php echo $custom_css ?></textarea>
                    </div>
                </div> <!-- Custom CSS -->
            </div>
        </div>
        <?php
            $other_attributes = array();
            echo submit_button(__('Save', $this->plugin_name), 'primary ays-button-top ays-loader-banner', 'ays_pd_submit_top', false, $other_attributes);
        ?>
    </form>
</div>