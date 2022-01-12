<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components\Controls\Buttons;
use Bookly\Backend\Components\Controls\Inputs;
?>
<div id="bookly-delete-recurring-appointment-dialog" class="bookly-modal bookly-fade" tabindex=-1 role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php esc_html_e( 'Delete Appointment', 'bookly' ) ?></h5>
                <button type="button" class="close" data-dismiss="bookly-modal" aria-hidden="true" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?php Inputs::renderRadio( __( 'Delete only this appointment', 'bookly' ), null, true, array( 'name' => 'delete-series' ) ) ?>
                    <?php Inputs::renderRadio( __( 'Delete this and the following appointments', 'bookly' ), 'current-and-next', null, array( 'name' => 'delete-series', 'class' => 'bookly-js-delete-series' ) ) ?>
                    <?php Inputs::renderRadio( __( 'Delete all appointments in series', 'bookly' ), 'series', null, array( 'name' => 'delete-series', 'class' => 'bookly-js-delete-series' ) ) ?>
                </div>
                <div class="form-group mb-0">
                    <?php Inputs::renderCheckBox( __( 'Send notifications', 'bookly' ), null, false, array( 'class' => 'bookly-js-recurring-notify' ) ) ?>
                </div>
                <div class="form-group collapse">
                    <input class="form-control bookly-js-delete-reason" type="text" placeholder="<?php esc_html_e( 'Cancellation reason (optional)', 'bookly' ) ?>" />
                </div>
            </div>
            <div class="modal-footer">
                <?php Buttons::render( null, 'bookly-js-series-delete btn-success', __( 'Delete', 'bookly' ) ) ?>
                <?php Buttons::renderCancel() ?>
            </div>
        </div>
    </div>
</div>