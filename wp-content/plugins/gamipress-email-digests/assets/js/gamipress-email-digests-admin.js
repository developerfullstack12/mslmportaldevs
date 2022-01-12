(function( $ ) {

    var initial_load = true;

    // Periodicity visibility
    $('body').on('change', '#_gamipress_email_digests_periodicity', function() {

        var weekly = $('.cmb2-id--gamipress-email-digests-weekly-preference');
        var monthly = $('.cmb2-id--gamipress-email-digests-monthly-preference');
        var yearly = $('.cmb2-id--gamipress-email-digests-yearly-preference');

        var show_cb = ( initial_load ? 'show' : 'slideDown' );
        var hide_cb = ( initial_load ? 'hide' : 'slideUp' );

        switch( $(this).val() ) {
            case 'weekly':
                weekly[show_cb]();
                monthly[hide_cb]();
                yearly[hide_cb]();
                break;
            case 'monthly':
                weekly[hide_cb]();
                monthly[show_cb]();
                yearly[hide_cb]();
                break;
            case 'yearly':
                weekly[hide_cb]();
                monthly[hide_cb]();
                yearly[show_cb]();
                break;
            case 'daily':
            default:
                weekly[hide_cb]();
                monthly[hide_cb]();
                yearly[hide_cb]();
                break;
        }

        initial_load = false;

    });

    $('#_gamipress_email_digests_periodicity').trigger('change');

})( jQuery );