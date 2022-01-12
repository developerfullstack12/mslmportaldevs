<?php
    $dictionary_actions = new Personal_Dictionary_Dictionaries($this->plugin_name);
    $words_count = $dictionary_actions->ays_pd_get_words();
    $group_count = $dictionary_actions->ays_pd_get_categories();
    $users_count = $dictionary_actions->ays_pd_get_users();
    $games_count = $dictionary_actions->ays_pd_get_reports();
?>
<div class="wrap">
    <h1 class="ays-pd-wrapper ays_heart_beat">
        <?php echo __("How to use" , $this->plugin_name);?>
         <i class="ays_fa ays_fa_heart_o animated"></i>
    </h1>
    <div class="ays-pd-home-main">
        <h2>
            <?php echo __("How to create a simple personal dictionary", $this->plugin_name ); ?>
        </h2>
        <fieldset>
            <div class="ays-pd-ol-container">
                <ol>
                    <li>
                        <div >
                            <?php echo __( "Put this shortcode in any post",$this->plugin_name );?>
                        </div>
                        <div>
                            <input type="text" onclick="this.setSelectionRange(0, this.value.length)" readonly="" value="[ayspd_userpage]" class="ays_pd_shortcode">
                        </div>
                    </li>
                </ol>
            </div>
        </fieldset>
        <!-- <p class="ays-survey-faq-footer">
            <#?php echo __( "For more advanced needs, please take a look at our" , $this->plugin_name ); ?> 
            <a href="https://ays-pro.com/wordpress-survey-maker-user-manual" target="_blank"><#?php echo __( "Survey Maker plugin User Manual." , $this->plugin_name ); ?></a>
            <br>
            <#?php echo __( "If none of these guides help you, ask your question by contacting our" , $this->plugin_name ); ?>
            <a href="https://ays-pro.com/contact" target="_blank"><#?php echo __( "support specialists." , $this->plugin_name ); ?></a> 
            <#?php echo __( "and get a reply within a day." , $this->plugin_name ); ?>
        </p> -->
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-3 ays_pd_containers">
            <div>
                <img class="ays_fonts_size" src="<?php echo PERSONAL_DICTIONARY_ADMIN_URL; ?>/images/icons/word.svg">
                <span style="font-size: 20px;display: block;"><?php echo __('Words in total',$this->plugin_name)?></span>
            </div>
            <div>
                <span><?php echo $words_count;?></span>
            </div>
        </div>
        <div class="col-sm-3 ays_pd_containers">
            <div>
                <img class="ays_fonts_size" src="<?php echo PERSONAL_DICTIONARY_ADMIN_URL; ?>/images/icons/category.svg">
                <span style="font-size: 20px;display: block;"><?php echo __('Groups in total',$this->plugin_name)?></span>
            </div>  
            <div>
                <span><?php echo $group_count;?></span>
            </div>        
        </div>
        <div class="col-sm-3 ays_pd_containers">   
            <div>
                <img class="ays_fonts_size" src="<?php echo PERSONAL_DICTIONARY_ADMIN_URL; ?>/images/icons/users.svg">
                <span style="font-size: 20px;display: block;"><?php echo __('Users count',$this->plugin_name)?></span>
            </div>
            <div>
                <span><?php echo $users_count;?></span>
            </div>
        </div>
        <div class="col-sm-3 ays_pd_containers">
            <div>
                <img class="ays_fonts_size" src="<?php echo PERSONAL_DICTIONARY_ADMIN_URL; ?>/images/icons/puzzle.svg">
                <span style="font-size: 20px;display: block;"><?php echo __('Games played in total',$this->plugin_name)?></span>
            </div>  
            <div>
                <span><?php echo $games_count;?></span>
            </div>          
        </div>
    </div>
</div>
