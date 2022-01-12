(function( $ ) {

    // Listen for our change to our trigger type selectors
    $('.requirements-list').on( 'change', '.select-trigger-type', function() {

        // Grab our selected trigger type and achievement selector
        var trigger_type = $(this).val();
        var birthday_input = $(this).siblings('.gamipress-birthdays-birthday');
        var birthday_notice = $(this).siblings('.gamipress-birthdays-requirements-notice');

        // Toggle birthday field visibility
        if( trigger_type === 'gamipress_birthdays_specific_birthday' ) {
            birthday_input.show();
        } else {
            birthday_input.hide();
        }

        if( trigger_type === 'gamipress_birthdays_any_birthday'
            || trigger_type === 'gamipress_birthdays_specific_birthday' ) {
            birthday_notice.show();
        } else {
            birthday_notice.hide();
        }

    });

    // Loop requirement list items to show/hide birthday input on initial load
    $('.requirements-list li').each(function() {

        // Grab our selected trigger type and achievement selector
        var trigger_type = $(this).find('.select-trigger-type').val();
        var birthday_input = $(this).find('.gamipress-birthdays-birthday');
        var birthday_notice = $(this).find('.gamipress-birthdays-requirements-notice');

        // Toggle birthday field visibility
        if( trigger_type === 'gamipress_birthdays_specific_birthday' ) {
            birthday_input.show();
        } else {
            birthday_input.hide();
        }

        if( trigger_type === 'gamipress_birthdays_any_birthday'
            || trigger_type === 'gamipress_birthdays_specific_birthday' ) {
            birthday_notice.show();
        } else {
            birthday_notice.hide();
        }

    });

    $('.requirements-list').on( 'update_requirement_data', '.requirement-row', function(e, requirement_details, requirement) {

        // Add birthday field
        if( requirement_details.trigger_type === 'gamipress_birthdays_specific_birthday' ) {
            requirement_details.birthdays_birthday = requirement.find( '.gamipress-birthdays-birthday input' ).val();
        }

    });

    var birthdays_first_change = true;

    // Settings
    if( $('#gamipress_birthdays_from option').length > 1 ) {
        $('body').on('change', '#gamipress_birthdays_from', function() {

            var value = $(this).val();

            if( ! value.length ) {
                value = 'user_meta';
            }

            var selector = '.cmb2-id-gamipress-birthdays-' + value.replaceAll( '_', '-' );
            var to_hide = $(this).closest('.cmb2-metabox').find('.cmb-row:not(' + selector + ', .cmb2-id-gamipress-birthdays-from)');
            var to_show = $(selector);

            // Hide the rest of fields and show the field for this option
            if( birthdays_first_change ) {
                to_hide.hide();
                to_show.show();
            } else {
                to_hide.slideUp();
                to_show.slideDown();
            }

            birthdays_first_change = false;

        });

        $('#gamipress_birthdays_from').trigger('change');
    } else {

        // If there is only 1 option, them means that there is not any integration installed
        var selector = '.cmb2-id-gamipress-birthdays-user-meta';

        $(this).closest('.cmb2-metabox').find('.cmb-row:not(' + selector + ')').hide();
        $(selector).show();
    }

})( jQuery );