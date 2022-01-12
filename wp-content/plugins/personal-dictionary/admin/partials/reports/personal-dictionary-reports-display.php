<?php
    $global_actions = new Personal_Dictionary_Reports_Actions($this->plugin_name);        
    
    $get_games_count_per_day    = $global_actions->get_games_count_line_chart();
    $get_words_count_per_day    = $global_actions->get_words_count_line_chart();
    $get_users_count_per_day    = $global_actions->get_users_count_line_chart();


    wp_localize_script( $this->plugin_name, 'PdChartData', array( 
        'gamesCountPerDayData' => $get_games_count_per_day,
        'wordsCountPerDayData' => $get_words_count_per_day,
        'usersCountPerDayData' => $get_users_count_per_day,
    ) );


?>

<div id="statistics" class="ays-pd-reports-tab-content ">
        <div class="wrap">
            <div class="form-group row ays-pd-reports-statistic-container">
                <div class="col-sm-8 ays-pd-reports-games-count-box-chart">
                    <div class="ays-pd-reports-games-count-header">
                        <div class="ays-pd-reports-games-count-header-content">
                            <h1 style="text-align:center;"><?php echo __("Games count per day", $this->plugin_name); ?></h1>
                        </div>
                    </div>
                    <div class="ays-pd-reports-games-count-content">
                        <div id="pd_games_chart_div" class="chart_div"></div>
                    </div>
                </div>
            </div>

            <div class="form-group row  ays-pd-reports-statistic-container">
                <div class="col-sm-8 ays-pd-reports-words-count-box-chart">
                    <div class="ays-pd-reports-words-count-header">
                        <div class="ays-pd-reports-words-count-header-content">
                            <h1 style="text-align:center;"><?php echo __("Words count per day", $this->plugin_name); ?></h1>
                        </div>
                    </div>
                    <div class="ays-pd-reports-words-count-content">
                        <div id="pd_words_chart_div" class="chart_div"></div>
                    </div>
                </div>                
            </div>

            <div class="form-group row  ays-pd-reports-statistic-container">
                <div class="col-sm-8 ays-pd-reports-users-count-box-chart">
                    <div class="ays-pd-reports-users-count-header">
                        <div class="ays-pd-reports-users-count-header-content">
                            <h1 style="text-align:center;"><?php echo __("Users count per day", $this->plugin_name); ?></h1>
                        </div>
                    </div>
                    <div class="ays-pd-reports-users-count-content">
                        <div id="pd_users_chart_div" class="chart_div"></div>
                    </div>
                </div>                
            </div>

            


        <div class="form-group row ays-pd-reports-stat-signboard" >

            <div class="col-sm-4 ays-pd-reports-games-stat" >
                    <h1><?php echo __('Statistics Signboard',$this->plugin_name)?></h1>
                    <hr/>
                    <ul class="ays-collection">
                        <?php
                        $statistics_items = array(1,7,30);
                        foreach ($statistics_items as $statistics_item){
                            $img = '';
                            $element = $global_actions->get_games_count_by_days($statistics_item);
                            $diff = $element['difference'];
                            if($diff < 0){
                                $img = '<img src="' . PERSONAL_DICTIONARY_ADMIN_URL . '/images/down_red_arrow.png" alt="Down">';
                            }elseif ($diff > 0){
                                $img = '<img src="' . PERSONAL_DICTIONARY_ADMIN_URL . '/images/up_green_arrow.png" alt="Up">';
                            }else{
                                $img = '<img src="' . PERSONAL_DICTIONARY_ADMIN_URL . '/images/equal.png" alt="Equal">';
                            }
                            echo "<li class=\"ays-collection-item\">
                                <div class=\"stat-left-div\">
                                    <p class=\"stat-count\"> ".$element['games_count']."</p>
                                    <span class=\"stat-description\">".__('Games played last',$this->plugin_name). " $statistics_item " .__('day',$this->plugin_name)."</span>
                                </div>
                                <div class=\"stat-right-div\">
                                    <p class=\"stat-diff-count\">".$element['difference']."%</p>
                                    ".$img."
                                </div>
                            </li>";
                        }
                        ?>

                    </ul>
            </div>

            <div class="col-sm-4 ays-pd-reports-stat-box" >
                <h1><?php echo __('Learned Words',$this->plugin_name)?></h1>
                <hr/>
                <?php
                $get_completed_words_count  = $global_actions->get_complete_words_count();

                echo "<div class=\"ays-pd-reports-statistic-learned-words\">
                    <a> <img class='learned_icon' src='". PERSONAL_DICTIONARY_ADMIN_URL ."/images/icons/school.svg'> </a>
                    <p class=\"ays-pd-learned-words-percentage\"> ".$get_completed_words_count['percentage']."%</p>
                    <span class=\"stat-description\">".__('Learned words average',$this->plugin_name)."</span>
                </div>";
                ?>  
            </div>

            <div class="col-sm-4 ays-pd-reports-stat-box" >
                <h1><?php echo __('Inactive Users',$this->plugin_name)?></h1>
                <hr/>
                <?php
                $get_inactive_users_count  = $global_actions->get_inactive_users_count();


                echo "<div class=\"ays-pd-reports-statistic-learned-words\">
                    <a> <img class='learned_icon' src='". PERSONAL_DICTIONARY_ADMIN_URL ."/images/icons/inactive_person.svg'> </a>
                    <p class=\"ays-pd-learned-words-percentage\"> ".$get_inactive_users_count."</p>
                    <span class=\"stat-description\">".__('Inactive users count last 30 day',$this->plugin_name)."</span>
                </div>";
                ?>  
            </div>

        </div>

        </div>
    </div>