// {theme_dir}/js/yoursite.js
(function ($) {
    $(function () {

        //country code error
        $(document.body).on(
            'change',
            // eslint-disable-next-line max-len
            '.enable_disable_class',
            function () {
                var current_element = $(this);
                var getactive = $(this).is(':checked'),
                    get_status = getactive ? 'active' : 'inactive';
                var data = {
                    'action': 'enable_disable_class_ajax',
                    'value': $(this).val(),
                    'active': get_status,
                };
                $(current_element).closest('.learndash_snippet_list_item').find('.learndash-powerpack-content').addClass('learndash_powerpack_ajax_loader');
                $.post(learndash_powerpack_jquery_var.ajax_url, data, function (response) {
                    $(current_element).closest('.learndash_snippet_list_item').find('.learndash-powerpack-content').removeClass('learndash_powerpack_ajax_loader');
                    if ('success' === response.success) {
                        // If it's success then whatever you want
                    } else {
                        // Failed
                    }
                });
            });

        //country code error
        $(document.body).on(
            'change',
            // eslint-disable-next-line max-len
            '#ld_snippet_powerpack_filter_select',
            function () {
                var_current_element = $(this).val();
                if (var_current_element != 'all') {
                    $('#learndash_snippet_list .learndash_snippet_list_item').show().not('#' + var_current_element).hide();
                } else $('#learndash_snippet_list .learndash_snippet_list_item').show();
            });

        //load model popup
        $(document.body).on(
            'click',
            // eslint-disable-next-line max-len
            '.ldt-btn--setting',
            function () {

                var current_element = $(this);
                var data_class = $(this).attr('data-class');
                var modal = document.getElementById('learndash-powerpack-modal');
                var data = {
                    'action': 'learndash_get_model_content',
                    'class_name': data_class,
                };
                $(current_element).closest('.learndash_snippet_list_item').find('.learndash-powerpack-content').addClass('learndash_powerpack_ajax_loader');
                $.post(learndash_powerpack_jquery_var.ajax_url, data, function (response) {
                    $(current_element).closest('.learndash_snippet_list_item').find('.learndash-powerpack-content').removeClass('learndash_powerpack_ajax_loader');
                    var title = response.title;
                    var settings_content = response.settings_content;
                    var footer_content = response.footer_content;
                    $('.model_data_title').html(title);
                    $('.learndash-powerpack-modal-body').html(settings_content);
                    $('.learndash-powerpack-modal-footer').html(footer_content);
                    modal.style.display = 'block';
                    $('.learndash_success_message').html('');
                    if ('success' === response.success) {
                        // If it's success then whatever you want
                    } else {
                        // Failed
                    }
                });
            });

        var modal = document.getElementById('learndash-powerpack-modal');

        // Close model popup

        $(document.body).on('click', '.learndash-powerpack-close', function () {
            $('.modal').hide();
        });

        //ajax save classes data
        $(document.body).on(
            'click',
            // eslint-disable-next-line max-len
            '.learndash_save_form_data',
            function (e) {
                e.preventDefault();
                var current_element = $(this);
                var form = $('form.form_learndash_save_class_data');
                var formData = form.serializeArray();
                var data_class = $(this).attr('data-class');
                var data = {
                    'action': 'learndash_save_class_data_ajax',
                    'class_name': data_class,
                    'formData': formData,
                };
                $(current_element).closest('div.modal').find('.learndash-powerpack-modal-content').addClass('learndash_powerpack_ajax_loader_form');
                $.post(learndash_powerpack_jquery_var.ajax_url, data, function (response) {
                    $(current_element).closest('div.modal').find('.learndash-powerpack-modal-content').removeClass('learndash_powerpack_ajax_loader_form');
                    $(current_element).closest('div.modal').find('.learndash_success_message').html('<p>' + learndash_powerpack_jquery_var.ld_success_message + '</p>');
                    if ('success' === response.success) {
                        // If it's success then whatever you want
                    } else {
                        // Failed
                    }
                });
            });

        $('#ld-powerpack-tabs a.button').click(function () {
            var target = $(this).data('target-content');

            $('.ld-powerpack-tab').hide();
            $('.ld-powerpack-tab#' + target).show();

            $('#ld-powerpack-tabs a.button').removeClass('active');
            $(this).addClass('active');
        });

    });
})(jQuery); // Fully reference jQuery after this point.
