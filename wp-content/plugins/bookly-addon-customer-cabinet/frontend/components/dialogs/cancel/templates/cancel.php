<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components\Controls\Buttons;
?>
<div id="bookly-customer-cabinet-cancel-dialog" class="bookly-modal bookly-fade" tabindex=-1 role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5><?php esc_html_e( 'Cancel Appointment', 'bookly' ) ?></h5>
                    <button type="button" class="close" data-dismiss="bookly-modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger collapse" id="bookly-cancel-error"></div>
                    <?php esc_html_e( 'You are going to cancel a scheduled appointment. Are you sure?', 'bookly' ) ?>
                </div>
                <div class="modal-footer">
                    <div>
                        <?php Buttons::render( 'bookly-yes', 'btn-danger', __( 'Yes', 'bookly' ) ) ?>
                        <?php Buttons::renderCancel( __( 'No', 'bookly' ) ) ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
