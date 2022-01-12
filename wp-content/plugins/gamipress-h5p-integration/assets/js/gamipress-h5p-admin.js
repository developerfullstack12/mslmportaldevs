(function( $ ) {

    // Listen for our change to our trigger type selectors
    $('.requirements-list').on( 'change', '.select-trigger-type', function() {

        // Grab our selected trigger type and achievement selector
        var trigger_type = $(this).val();
        var content_type_select = $(this).siblings('.h5p-content-type');
        var score_input = $(this).siblings('.h5p-score');
        var min_score_input = $(this).siblings('.h5p-min-score');
        var max_score_input = $(this).siblings('.h5p-max-score');

        if( trigger_type === 'gamipress_h5p_complete_specific_content_type'
            || trigger_type === 'gamipress_h5p_max_complete_specific_content_type'
            || trigger_type === 'gamipress_h5p_complete_specific_content_type_min_score'
            || trigger_type === 'gamipress_h5p_complete_specific_content_type_max_score'
            || trigger_type === 'gamipress_h5p_complete_specific_content_type_between_score' ) {
            content_type_select.show();
        } else {
            content_type_select.hide();
        }

        if( trigger_type === 'gamipress_h5p_complete_content_min_score'
            || trigger_type === 'gamipress_h5p_complete_specific_content_min_score'
            || trigger_type === 'gamipress_h5p_complete_specific_content_type_min_score'
            || trigger_type === 'gamipress_h5p_complete_content_max_score'
            || trigger_type === 'gamipress_h5p_complete_specific_content_max_score'
            || trigger_type === 'gamipress_h5p_complete_specific_content_type_max_score' ) {
            score_input.show();
        } else {
            score_input.hide();
        }

        if( trigger_type === 'gamipress_h5p_complete_content_between_score'
            || trigger_type === 'gamipress_h5p_complete_specific_content_between_score'
            || trigger_type === 'gamipress_h5p_complete_specific_content_type_between_score' ) {
            min_score_input.show();
            max_score_input.show();
        } else {
            min_score_input.hide();
            max_score_input.hide();
        }

    });

    // Loop requirement list items to show/hide amount input on initial load
    $('.requirements-list li').each(function() {

        // Grab our selected trigger type and achievement selector
        var trigger_type = $(this).find('.select-trigger-type').val();
        var content_type_select = $(this).find('.h5p-content-type');
        var score_input = $(this).find('.h5p-score');
        var min_score_input = $(this).find('.h5p-min-score');
        var max_score_input = $(this).find('.h5p-max-score');

        if( trigger_type === 'gamipress_h5p_complete_specific_content_type'
            || trigger_type === 'gamipress_h5p_max_complete_specific_content_type'
            || trigger_type === 'gamipress_h5p_complete_specific_content_type_min_score'
            || trigger_type === 'gamipress_h5p_complete_specific_content_type_max_score'
            || trigger_type === 'gamipress_h5p_complete_specific_content_type_between_score' ) {
            content_type_select.show();
        } else {
            content_type_select.hide();
        }

        if( trigger_type === 'gamipress_h5p_complete_content_min_score'
            || trigger_type === 'gamipress_h5p_complete_specific_content_min_score'
            || trigger_type === 'gamipress_h5p_complete_specific_content_type_min_score'
            || trigger_type === 'gamipress_h5p_complete_content_max_score'
            || trigger_type === 'gamipress_h5p_complete_specific_content_max_score'
            || trigger_type === 'gamipress_h5p_complete_specific_content_type_max_score' ) {
            score_input.show();
        } else {
            score_input.hide();
        }

        if( trigger_type === 'gamipress_h5p_complete_content_between_score'
            || trigger_type === 'gamipress_h5p_complete_specific_content_between_score'
            || trigger_type === 'gamipress_h5p_complete_specific_content_type_between_score' ) {
            min_score_input.show();
            max_score_input.show();
        } else {
            min_score_input.hide();
            max_score_input.hide();
        }

    });

    $('.requirements-list').on( 'update_requirement_data', '.requirement-row', function(e, requirement_details, requirement) {

        if( requirement_details.trigger_type === 'gamipress_h5p_complete_specific_content_type'
            || requirement_details.trigger_type === 'gamipress_h5p_max_complete_specific_content_type'
            || requirement_details.trigger_type === 'gamipress_h5p_complete_specific_content_type_min_score'
            || requirement_details.trigger_type === 'gamipress_h5p_complete_specific_content_type_max_score'
            || requirement_details.trigger_type === 'gamipress_h5p_complete_specific_content_type_between_score') {
            requirement_details.h5p_content_type = requirement.find( '.h5p-content-type select' ).val();
        }

        if( requirement_details.trigger_type === 'gamipress_h5p_complete_content_min_score'
            || requirement_details.trigger_type === 'gamipress_h5p_complete_specific_content_min_score'
            || requirement_details.trigger_type === 'gamipress_h5p_complete_specific_content_type_min_score'
            || requirement_details.trigger_type === 'gamipress_h5p_complete_content_max_score'
            || requirement_details.trigger_type === 'gamipress_h5p_complete_specific_content_max_score'
            || requirement_details.trigger_type === 'gamipress_h5p_complete_specific_content_type_max_score' ) {
            requirement_details.h5p_score = requirement.find( '.h5p-score input' ).val();
        }

        if( requirement_details.trigger_type === 'gamipress_h5p_complete_content_between_score'
            || requirement_details.trigger_type === 'gamipress_h5p_complete_specific_content_between_score'
            || requirement_details.trigger_type === 'gamipress_h5p_complete_specific_content_type_between_score' ) {
            requirement_details.h5p_min_score = requirement.find( '.h5p-min-score input' ).val();
            requirement_details.h5p_max_score = requirement.find( '.h5p-max-score input' ).val();
        }

    });

})( jQuery );