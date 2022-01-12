(function( $ ) {

    var prefix = 'learndash-group-leaderboard-';
    var _prefix = 'learndash_group_leaderboard_';

    $('.cmb2-id-' + prefix + 'metrics input').on('change', function() {

        // Makes columns sortable

        $('.cmb2-id-' + prefix + 'columns .cmb2-list').sortable({
            handle: 'label',
            placeholder: 'ui-state-highlight',
            forcePlaceholderSize: true,
        });

        // Columns visibility

        var target = $('.cmb2-id-' + prefix + 'columns input[value="' +  $(this).val() + '"]');

        if( ! target.length ) {
            return;
        }

        if( $(this).prop('checked') ) {
            //target.prop('checked', true);
            target.parent().show();
        } else {
            //target.prop('checked', false);
            target.parent().hide();
        }
    });

    $('.cmb2-id-' + prefix + 'metrics input').each(function() {
        $(this).trigger('change');
    });

    // Period start and end dates visibility

    $('#' + _prefix + 'period').on('change', function() {
        var target = $('.cmb2-id-' + prefix + 'period-start-date, .cmb2-id-' + prefix + 'period-end-date');

        if( $(this).val() === 'custom' ) {
            target.slideDown();
        } else {
            target.slideUp();
        }
    });

    if( $('#' + _prefix + 'period').val() !== 'custom' ) {
        $('.cmb2-id-' + prefix + 'period-start-date, .cmb2-id-' + prefix + 'period-end-date').hide();
    }

    // Avatar size visibility

    $('.cmb2-id-' + prefix + 'columns input[type="checkbox"][value="avatar"]').on('change', function() {
        var target = $('.cmb2-id-' + prefix + 'avatar-size');

        if( $(this).prop('checked') ) {
            target.slideDown();
        } else {
            target.slideUp();
        }
    });

    $('.cmb2-id-' + prefix + 'columns input[type="checkbox"][value="avatar"]').trigger('change');

    // Regenerate group leaderboards

    $('#' + _prefix + 'regenerate_leaderboards').on('click', function( e ) {
        e.preventDefault();

        if( ! $('#' + prefix + 'regenerate-response').length ) {
            $(this).parent().append('<span id="' + prefix + 'regenerate-response" style="display: inline-block; padding: 5px 0 0 8px;"></span>');
        }

        if( ! $('#' + prefix + 'regenerate-response').find('.spinner').length ) {
            // Show the spinner
            $('#' + prefix + 'regenerate-response').html('<span class="spinner is-active" style="float: none; margin: 0;"></span>');
        }

        $.post(
            ajaxurl,
            { action: 'gamipress_learndash_group_leaderboard_regenerate_leaderboards' },
            function( response ) {

                // Disable the export button
                $(this).prop('disabled', true);

                // If error make response looks red
                if( response.success === false ) {
                    $('#' + prefix + 'regenerate-response').css({color:'#a00'});
                }

                // Append the server response
                $('#' + prefix + 'regenerate-response').html(( response.data.message !== undefined ? response.data.message : response.data ) );

                // Enable the export button
                $(this).prop('disabled', false);
            }
        ).fail(function() {

            $('#' + prefix + 'regenerate-response').html('The server has returned an internal error.');

            // Enable the export button
            $(this).prop('disabled', false);
        });
    });

})( jQuery );