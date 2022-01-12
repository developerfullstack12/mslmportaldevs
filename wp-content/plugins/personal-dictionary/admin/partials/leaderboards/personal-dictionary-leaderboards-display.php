<h1 class="wp-heading-inline">
        <?php
        echo __(esc_html(get_admin_page_title()),$this->plugin_name);
        ?>
</h1>
<hr>

<div class="ays-pd-leaderboards-content">
        <?php
            global $wpdb;
            $words_table = esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'words');
            $reports_table = esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'reports');
            $categories_table = esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'categories');
            $globsettings_table = esc_sql($wpdb->prefix . PERSONAL_DICTIONARY_DB_PREFIX . 'globsettings');
            $sql = "SELECT w.user_id, COUNT(*) as w_count,
            ( SELECT COUNT( * )  FROM  $words_table w2 WHERE w2.user_id = w.user_id AND completed = 1 ) AS learned_words_count,
            ( SELECT SUM(point) FROM  $words_table w3 WHERE w3.user_id = w.user_id ) AS points_sum,
            ( SELECT COUNT( * ) FROM $reports_table r WHERE r.user_id = w.user_id ) AS games_count,
            ( SELECT COUNT( * ) FROM $categories_table c WHERE c.user_id = w.user_id ) AS groups_count,
            ( SELECT meta_value FROM $globsettings_table s WHERE meta_key = 'learned_points' ) AS learned_points
            FROM  $words_table w 
            GROUP BY w.user_id
            ORDER BY learned_words_count DESC";
            $result = $wpdb->get_results($sql, 'ARRAY_A');

            $c = 1;
            $content = "<div class='ays-pd-lb-container'>
            <table id='ays-pd-lb-table'>
                <thead class='ays-pd-lb-thead'>
                    <tr>
                    <th class='ays-pd-lb-pos'>Pos.</th>
                    <th class='ays-pd-lb-user'>".__("Name", $this->plugin_name)."</th>
                    <th class='ays-pd-lb-email'>".__("Email", $this->plugin_name)."</th>
                    <th class='ays-pd-lb-words-count'>".__("Words count", $this->plugin_name)."</th>
                    <th class='ays-pd-lb-learned-words-count'>".__("Learned words count", $this->plugin_name)."</th>
                    <th class='ays-pd-lb-percentage'>".__("Percentage", $this->plugin_name)."</th>
                    <th class='ays-pd-lb-games-count'>".__("Games count", $this->plugin_name)."</th>
                    <th class='ays-pd-lb-groups-count'>".__("Groups count", $this->plugin_name)."</th>
                    <th class='ays-pd-lb-rate'>".__("Rate", $this->plugin_name)."</th>
                    </tr>
                </thead>";
                $content .= "<tbody>";
            foreach ($result as $key => $val) {
                $user = get_user_by('id', $val['user_id']);
                if ($user !== false) {
                    $user_name = $user->data->display_name ? $user->data->display_name : $user->user_login;
                    $user_email =  $user->data->user_email ? $user->data->user_email : $user->user_login;
                    $words_count = (isset($val['w_count']) && $val['w_count'] != '') ? intval($val['w_count']) : 0;
                    $learned_words_count = (isset($val['learned_words_count']) && $val['learned_words_count'] != '') ? intval($val['learned_words_count']) : 0;
                    $games_count = (isset($val['games_count']) && $val['games_count'] != '') ? intval($val['games_count']) : 0;
                    $groups_count = (isset($val['groups_count']) && $val['groups_count'] != '') ? intval($val['groups_count']) : 0;
                    $points_sum = (isset($val['points_sum']) && $val['points_sum'] != '') ? floatval($val['points_sum']) : 0;
                    $learned_points = (isset($val['learned_points']) && $val['learned_points'] != '') ? floatval($val['learned_points']) : 10;
                    $percentage = 0;
                    $rate = 0;
 
                    if($words_count > 0){
                        $percentage = round(($learned_words_count / $words_count)*100);                        
                    }

                    if($words_count > 0 && $learned_points > 0){
                        $rate = round(($points_sum / ($words_count *  $learned_points) ) * 100);
                    }
                    
                    $content .= "<tr class='ays-pd-lb-tr'>
                                    <td class='ays-pd-lb-pos'>".$c.".</td>
                                    <td class='ays-pd-lb-name'>".$user_name."</td>
                                    <td class='ays-pd-lb-email'>".$user_email."</td>
                                    <td class='ays-pd-lb-words-count'>".$words_count."</td>
                                    <td class='ays-pd-lb-learned-words'>".$learned_words_count."</td>
                                    <td class='ays-pd-lb-percentage'>".$percentage."%</td>
                                    <td class='ays-pd-lb-games-count'>".$games_count."</td>
                                    <td class='ays-pd-lb-groups-count'>".$groups_count."</td>
                                    <td class='ays-pd-lb-rate'>".$rate."%</td>
                                    </tr>";
                    
                    $c++;
                }
            }
            $content .= "</tbody>";
            $content .= "</table>
            </div>";
            echo $content;
        ?>
    </div>