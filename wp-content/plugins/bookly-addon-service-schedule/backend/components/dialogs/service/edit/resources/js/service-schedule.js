jQuery(function ($) {
    $(document.body).on('service.initForm', {},
        // Bind an event handler to the components for service panel.
        function (event, $panel, service_id) {
            let $container = $('#bookly-services-schedule', $panel);
            $container.off()
                .on('change', '.bookly-js-parent-range-start', function () {
                    var $parentRangeStart = $(this),
                        $rangeRow = $parentRangeStart.parents('.bookly-js-range-row');
                    if ($parentRangeStart.val() == '') {
                        $rangeRow
                            .find('.bookly-js-hide-on-off').hide().end()
                            .find('.bookly-js-invisible-on-off').addClass('invisible');
                    } else {
                        $rangeRow
                            .find('.bookly-js-hide-on-off').show().end()
                            .find('.bookly-js-invisible-on-off').removeClass('invisible');
                        rangeTools.hideInaccessibleEndTime($parentRangeStart, $('.bookly-js-parent-range-end', $rangeRow));
                    }
                })
                .on('click', '.popover-body .bookly-js-save-break', function (e) {
                    e.preventDefault();
                    // Listener for saving break.
                    var $button = $(this),
                        $popoverBody = $button.closest('.popover-body'),
                        ladda = rangeTools.ladda(this),
                        data = $.extend({
                            action    : 'bookly_service_schedule_save_break',
                            csrf_token: BooklyL10nGlobal.csrf_token,
                            start_time: $('.bookly-js-popover-range-start', $popoverBody).val(),
                            end_time  : $('.bookly-js-popover-range-end', $popoverBody).val(),
                            service_id: service_id,
                        }, $button.data('submit'));

                    $.ajax({
                        method: 'POST',
                        url: ajaxurl,
                        data: data,
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                if (data.hasOwnProperty('id')) {
                                    // Change text on button with new range value.
                                    var $interval_button = $('button.bookly-js-break-interval', $('[data-entity-id=' + data.id + ']'));
                                    $interval_button.html(response.data.interval);
                                } else {
                                    var $html = $.parseHTML(response.data.html);
                                    initContentListeners($html);
                                    $('.bookly-js-range-row[data-index=' + data.index + '] .bookly-js-breaks-list', $container)
                                        .append($html);
                                }
                                $button.parents('.bookly-popover').booklyPopover('hide');
                            } else {
                                if (response.data && response.data.message) {
                                    booklyAlert({error: [response.data.message]});
                                }
                            }
                        }
                    }).always(function () {
                        ladda.stop()
                    });
                })
                .on('change', '.bookly-js-popover-range-start', function () {
                    let $start = $(this),
                        $popoverBody = $start.closest('.popover-body'),
                        $end = $('.bookly-js-popover-range-end', $popoverBody),
                        index = $('.bookly-js-save-break', $popoverBody).data('submit').index,
                        $parent = $('.bookly-js-range-row[data-index=' + index + ']');
                    rangeTools.hideInaccessibleBreaks($start, $end, $parent);
                })
                .on('click', '.bookly-js-delete-break', function (e) {
                    // Delete break.
                    e.preventDefault();
                    if (confirm(ServiceScheduleL10n.are_you_sure)) {
                        var $button = $(this),
                            ladda = rangeTools.ladda(this);
                        $.ajax({
                            method: 'POST',
                            url: ajaxurl,
                            data: {action: 'bookly_service_schedule_delete_break', id: $button.closest('[data-entity-id]').data('entity-id'), csrf_token: BooklyL10nGlobal.csrf_token},
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    $button.parent().remove();
                                } else {
                                    if (response.data && response.data.message) {
                                        booklyAlert({error: [response.data.message]});
                                    }
                                }
                            }
                        }).always(function () {
                            ladda.stop();
                        });
                    }
                })
                .on('click', 'button.bookly-js-reset', function (e) {
                    $('form', $container).trigger('reset');
                })
                .on('click', 'button.bookly-js-save-schedule', function (e) {
                    e.preventDefault();
                    var data = $(this).closest('form').serializeArray(),
                        ladda = Ladda.create(this);
                    ladda.start();

                    data.push({name: 'action', value: 'bookly_service_schedule_update_schedule'});
                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: data,
                        dataType: 'json',
                        xhrFields: {withCredentials: true},
                        crossDomain: 'withCredentials' in new XMLHttpRequest(),
                        success: function (response) {
                            ladda.stop();
                            booklyAlert(response.data.alert);
                        }
                    });
                });

            $('.bookly-js-parent-range-start', $container).trigger('change');
            initContentListeners($container);

            function initContentListeners($panel) {
                $('.bookly-js-toggle-popover', $panel)
                    .booklyPopover({
                        html     : true,
                        placement: 'bottom',
                        container: $("#bookly-services-schedule-container", $container),
                        template : '<div class="bookly-popover mw-100" role="tooltip"><div class="arrow"></div><div class="popover-body"></div></div>',
                        trigger  : 'manual',
                        content  : function () {
                            let $button       = $(this),
                                $popover      = $('.bookly-js-edit-break-body > div', $container).clone(),
                                $popoverStart = $('.bookly-js-popover-range-start', $popover),
                                $popoverEnd   = $('.bookly-js-popover-range-end', $popover),
                                $saveButton   = $('.bookly-js-save-break', $popover),
                                force_keep_values = false;
                            if ($button.hasClass('bookly-js-break-interval')) {
                                let interval = $button.html().trim().split(' - ');
                                rangeTools.setVal($popoverStart, interval[0]);
                                rangeTools.setVal($popoverEnd, interval[1]);
                                force_keep_values = true;
                                $saveButton.data('submit', {
                                    id: $button.closest('[data-entity-id]').data('entity-id'),
                                    index: $button.closest('.bookly-js-range-row').data('index')
                                });
                            } else {
                                rangeTools.setPopoverRangeDefault($popoverStart, $popoverEnd, $button.closest('.bookly-js-range-row'));
                                $saveButton.data('submit', {
                                    index: $button.closest('.bookly-js-range-row').data('index')
                                });
                            }
                            rangeTools.hideInaccessibleBreaks($popoverStart, $popoverEnd, $button.closest('.bookly-js-range-row'), force_keep_values);
                            $('.bookly-js-close', $popover).on('click', function () {
                                $button.booklyPopover('hide');
                            });

                            return $popover;
                        }
                    })
                    .on('click', function () {
                        $('.bookly-js-toggle-popover').booklyPopover('hide');
                        $(this).booklyPopover('toggle');
                    });
            }
        }
    )
});