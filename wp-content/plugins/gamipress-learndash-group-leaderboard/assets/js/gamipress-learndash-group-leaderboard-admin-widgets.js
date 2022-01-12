(function( $ ) {

    var groups_select2 = {
        ajax: {
            url: ajaxurl,
            dataType: 'json',
            delay: 250,
            type: 'POST',
            data: function( params ) {
                return {
                    q: params.term,
                    page: params.page || 1,
                    action: 'gamipress_get_posts',
                    post_type: 'groups',
                };
            },
            processResults: gamipress_select2_posts_process_results
        },
        escapeMarkup: function ( markup ) { return markup; }, // Let our custom formatter work
        templateResult: gamipress_select2_posts_template_result,
        theme: 'default gamipress-select2',
        placeholder: 'Select Group(s)',
        allowClear: true,
        multiple: true
    };

    var leaderboard_select2 = {
        ajax: {
            url: ajaxurl,
            dataType: 'json',
            delay: 250,
            type: 'POST',
            data: function( params ) {
                return {
                    q: params.term,
                    page: params.page || 1,
                    action: 'gamipress_get_posts',
                    post_type: 'leaderboard',
                };
            },
            processResults: gamipress_select2_posts_process_results
        },
        escapeMarkup: function ( markup ) { return markup; }, // Let our custom formatter work
        templateResult: gamipress_select2_posts_template_result,
        theme: 'default gamipress-select2',
        placeholder: 'Select Leaderboard(s)',
        allowClear: true,
        multiple: true
    };

    // Exclude Groups
    $( '#widgets-right select[id^="widget-gamipress_learndash_user_groups_leaderboards"][id$="[exclude_groups]"]:not(.select2-hidden-accessible)' ).select2( groups_select2 );

    // Exclude Leaderboards
    $( '#widgets-right select[id^="widget-gamipress_learndash_user_groups_leaderboards"][id$="[exclude_leaderboards]"]:not(.select2-hidden-accessible)' ).select2( leaderboard_select2 );

    // Initialize on widgets area
    $(document).on('widget-updated widget-added', function(e, widget) {

        // Exclude Groups
        widget.find( 'select[id^="widget-gamipress_learndash_user_groups_leaderboards"][id$="[exclude_groups]"]:not(.select2-hidden-accessible)' ).select2( groups_select2 );

        // Exclude Leaderboards
        widget.find( 'select[id^="widget-gamipress_learndash_user_groups_leaderboards"][id$="[exclude_leaderboards]"]:not(.select2-hidden-accessible)' ).select2( leaderboard_select2 );

    });

})( jQuery );