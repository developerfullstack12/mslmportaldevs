jQuery(function ($) {
    var $delete_dialog = $('#bookly-delete-recurring-appointment-dialog'),
        $notify = $('.bookly-js-recurring-notify', $delete_dialog),
        $reason = $('.bookly-js-delete-reason', $delete_dialog ),
        $reason_handle = $reason.parent(),
        calendar,
        calEvent;
    $notify.on('change', function() {
        $reason_handle.toggle($(this).prop('checked'));
    });
    $delete_dialog.find('.bookly-js-series-delete').on('click', function () {
        var ladda = Ladda.create(this);
        ladda.start();
        if ($delete_dialog.find('input.bookly-js-delete-series:checked').length) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'bookly_recurring_appointments_delete_appointment',
                    csrf_token: BooklyL10nGlobal.csrf_token,
                    series_id: calEvent.extendedProps.series_id,
                    what: $delete_dialog.find("input[type='radio'][name='delete-series']:checked").val(),
                    appointment_id: calEvent.id,
                    notify: $notify.prop('checked') ? 1 : 0,
                    reason: $reason.val()
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $delete_dialog.booklyModal('hide');
                        calendar.refetchEvents();
                        if (response.data && response.data.queue && response.data.queue.length) {
                            BooklyNotificationsQueueDialog.showDialog({queue: response.data.queue});
                        }
                    }
                },
                complete: function () {
                    ladda.stop();
                    $notify.prop('checked', false).trigger('change');
                    $reason.val('');
                }
            });
        } else {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'bookly_delete_appointment',
                    csrf_token: BooklyL10nGlobal.csrf_token,
                    appointment_id: calEvent.id,
                    notify: $notify.prop('checked') ? 1 : 0,
                    reason: $reason.val()
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $delete_dialog.booklyModal('hide');
                        calendar.removeEventById(calEvent.id);
                        if (response.data && response.data.queue && response.data.queue.length) {
                            BooklyNotificationsQueueDialog.showDialog({queue: response.data.queue});
                        }
                    }
                },
                complete: function () {
                    ladda.stop();
                    $notify.prop('checked', false).trigger('change');
                    $reason.val('');
                }
            });
        }
    });

    $(document.body).on('recurring_appointments.delete_dialog', {},
        function (event, eventCalendar, ce) {
            calendar = eventCalendar;
            calEvent = ce;
            $delete_dialog.booklyModal('show');
        }
    );
});