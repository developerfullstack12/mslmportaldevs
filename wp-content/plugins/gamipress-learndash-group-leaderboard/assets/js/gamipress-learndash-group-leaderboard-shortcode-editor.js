(function( $ ) {

    var group_select2 = {
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
        placeholder: 'Select Leaderboard(s)',
        allowClear: true,
        multiple: true
    };

    $( '#gamipress_learndash_user_groups_leaderboards_exclude_groups' ).select2( group_select2 );

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

    $( '#gamipress_learndash_user_groups_leaderboards_exclude_leaderboards' ).select2( leaderboard_select2 );

    // User ajax
    $( '#gamipress_learndash_user_groups_leaderboards_user_id' ).select2({
        ajax: {
            url: ajaxurl,
            dataType: 'json',
            delay: 250,
            type: 'POST',
            data: function( params ) {
                return {
                    q: params.term,
                    page: params.page || 1,
                    action: 'gamipress_get_users'
                };
            },
            processResults: gamipress_select2_users_process_results
        },
        escapeMarkup: function ( markup ) { return markup; }, // Let our custom formatter work
        templateResult: gamipress_select2_users_template_result,
        theme: 'default gamipress-select2',
        placeholder: 'Select an User',
        allowClear: true,
        multiple: false
    });

    // Current user field
    $( '#gamipress_learndash_user_groups_leaderboards_current_user').on('change', function() {
        var target = $(this).closest('.cmb-row').next(); // User ID field

        if( $(this).prop('checked') ) {
            target.slideUp().addClass('cmb2-tab-ignore');
        } else {
            if( target.closest('.cmb-tabs-wrap').length ) {
                // Just show if item tab is active
                if( target.hasClass('cmb-tab-active-item') ) {
                    target.slideDown();
                }
            } else {
                target.slideDown();
            }

            target.removeClass('cmb2-tab-ignore');
        }
    });

})( jQuery );