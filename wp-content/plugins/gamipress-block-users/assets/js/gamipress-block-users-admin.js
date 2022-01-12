(function( $ ) {

    // Blocked roles
    $( '#gamipress_block_users_blocked_roles' ).gamipress_select2({
        theme: 'default gamipress-select2',
        placeholder: 'Select Roles',
        allowClear: true,
        multiple: true
    });

    // Blocked users
    $( '#gamipress_block_users_blocked_users' ).gamipress_select2({
        ajax: {
            url: ajaxurl,
            dataType: 'json',
            delay: 250,
            type: 'POST',
            data: function( params ) {
                return {
                    q: params.term,
                    page: params.page || 1,
                    action: 'gamipress_get_users',
                    nonce: gamipress_block_users_admin.nonce
                };
            },
            processResults: gamipress_select2_users_process_results
        },
        escapeMarkup: function ( markup ) { return markup; }, // Let our custom formatter work
        templateResult: gamipress_select2_users_template_result,
        theme: 'default gamipress-select2',
        placeholder: 'Select Users',
        allowClear: true,
        closeOnSelect: false,
        multiple: true
    });

})( jQuery );