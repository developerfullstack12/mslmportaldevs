(function( $ ) {

    var prefix = 'gamipress_mycred_importer_';

    var first_run = true;
    var current_process = 0;
    var process = [
        'points',
        //'achievements',   // User is able to select if import it or not
        //'ranks',          // User is able to select if import it or not
        //'earnings',       // User is able to select if import it or not
        //'logs'            // User is able to select if import it or not
    ];

    function gamipress_mycred_migrate( show_info ) {

        if( show_info === undefined )
            show_info = true;

        if( process[current_process] === undefined ) {
            // Remove the spinner
            $('#' + prefix + 'response').find('.spinner').remove();

            // Restore the run import button
            $('#' + prefix + 'run').prop('disabled', false);

            // Restore current process
            current_process = 0;

            $('#' + prefix + 'response').append( '<br>Process finished succesfully!' );
            return;
        } else if( show_info ) {
            $('#' + prefix + 'response').append( '<br>Migrating ' + process[current_process] + '...' );
        }

        var data = {
            action: prefix + 'import_'+ process[current_process],
            first_run: ( first_run ? 1 : 0 ),
            // Tool data
            badges_achievement_type: $('#' + prefix + 'badges_achievement_type').val(),
            badges_requirements_as_events: ( $('#' + prefix + 'badges_requirements_as_events').prop('checked') ? 1 : 0 ),
            override_points: ( $('#' + prefix + 'override_points').prop('checked') ? 1 : 0 ),
        };

        // Dynamic rank type selects
        $('select[id^="' + prefix + '"][id$="_rank_type"]').each(function() {
            data[$(this).attr('id').replace(prefix, '')] = $(this).val();
        });

        $.ajax({
            url: ajaxurl,
            data: data,
            success: function( response ) {

                // Clear first run
                first_run = false;

                var running_selector = $('#' + prefix + 'response #running-' + process[current_process]);

                if( response.data.run_again !== undefined && response.data.run_again ) {
                    // If run again is set, we need to send again the same action

                    if( response.data.message !== undefined ) {

                        // If data message is set like "Remaining items ..." add it to a custom span element t be removed
                        if( ! running_selector.length ) {
                            $('#' + prefix + 'response').append( '<br><span id="running-' + process[current_process] + '"></span>' );

                            // Re-assign running selector
                            running_selector = $('#' + prefix + 'response #running-' + process[current_process]);
                        }

                        // Set the response message
                        running_selector.html( response.data.message );
                    }

                    // Runs again the same process without show the "Migrating {processs}..." text
                    gamipress_mycred_migrate( false );
                } else {

                    // Check if there is a message from run again to remove it
                    if( running_selector.length ) {
                        running_selector.prev('br').remove();
                        running_selector.remove();
                    }

                    // Add the response message
                    $('#' + prefix + 'response').append( '<br>' + response.data );

                    current_process++;

                    // Run the next process
                    setTimeout( gamipress_mycred_migrate, 500 );
                }

            },
            error: function( response ) {
                //$('#' + prefix + 'response').css({color:'#a00'});
                $('#' + prefix + 'response').append( '<br>' + '<span style="color: #a00;">' + response.data !== undefined ? response.data : 'Internal server error' + '</span>' );
                return;
            }
        });
    }

    $('#' + prefix + 'run').on('click', function(e) {
        e.preventDefault();

        var $this = $(this);

        $this.prop('disabled', true);

        if( $('#' + prefix + 'response').length )
            $('#' + prefix + 'response').remove();

        // Show the spinner
        $this.parent().append('<div id="' + prefix + 'response"><span class="spinner is-active" style="float: none;"></span></div>');

        // Add user selected process
        if( $('#' + prefix + 'import_achievements').prop('checked') )
            process.push('achievements');

        // Add user selected process
        if( $('#' + prefix + 'import_ranks').prop('checked') )
            process.push('ranks');

        // Add user selected process
        if( $('#' + prefix + 'import_earnings').prop('checked') )
            process.push('earnings');

        // Add user selected process
        if( $('#' + prefix + 'import_logs').prop('checked') )
            process.push('logs');

        // On click, set this var to meet that is first time that it runs
        first_run = true;

        gamipress_mycred_migrate();
    });

    // Achievements visibility
    $('#' + prefix + 'import_achievements').on('change', function() {
        var target = $('.cmb2-id-gamipress-mycred-importer-badges-achievement-type, .cmb2-id-gamipress-mycred-importer-badges-requirements-as-events');

        if( $(this).prop('checked') ) {
            target.slideDown(250);
        } else {
            target.slideUp(250);
        }
    });

    if( ! $('#' + prefix + 'import_achievements').prop('checked') ) {
        $('.cmb2-id-gamipress-mycred-importer-badges-achievement-type, .cmb2-id-gamipress-mycred-importer-badges-requirements-as-events').hide();
    }

    // Ranks visibility
    $('#' + prefix + 'import_ranks').on('change', function() {
        var target = $(this).closest('.cmb2-metabox').find('.cmb-row[class*="-rank-type"]');

        if( $(this).prop('checked') ) {
            target.slideDown(250);
        } else {
            target.slideUp(250);
        }
    });

    if( ! $('#' + prefix + 'import_ranks').prop('checked') ) {
        $('#' + prefix + 'import_ranks').closest('.cmb2-metabox').find('.cmb-row[class*="-rank-type"]').hide();
    }

})( jQuery );