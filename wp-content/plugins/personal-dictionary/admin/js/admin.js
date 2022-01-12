(function ($) {
    'use strict';

    $(document).on('click', '[data-slug="personal-dictionary"] .deactivate a', function () {
        swal({
            html:"<h2>Do you want to upgrade to Pro version or permanently delete the plugin?</h2><ul><li>Upgrade: Your data will be saved for upgrade.</li><li>Deactivate: Your data will be deleted completely.</li></ul>",
            footer: '<a href="javascript:void(0);" class="ays-pd-temporary-deactivation">Temporary deactivation</a>',
            type: 'question',
            showCloseButton: true,
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Upgrade',
            cancelButtonText: 'Deactivate',
            confirmButtonClass: "ays-pd-upgrade-button"
        }).then(function(result) {
            
            if( result.dismiss && result.dismiss == 'close' ){
                return false;
            }
            console.log(result);
            var upgrade_plugin = false;
            if (result.value) upgrade_plugin = true;
            var data = {
                action: 'deactivate_plugin_option_sm', 
                upgrade_plugin: upgrade_plugin
            };
            $.ajax({
                url: PersonalDictionaryAdmin.ajaxUrl,
                method: 'post',
                dataType: 'json',
                data: data,
                success:function () {
                    window.location = $(document).find('[data-slug="personal-dictionary"]').find('.deactivate').find('a').attr('href');
                }
            });
        });
        return false;
    });

    $(document).on('click', '.ays-pd-temporary-deactivation', function (e) {
        e.preventDefault();

        $(document).find('.ays-pd-upgrade-button').trigger('click');

    });
})(jQuery);