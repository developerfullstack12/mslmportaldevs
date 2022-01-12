<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components\Controls\Buttons;
use Bookly\Backend\Components\Controls\Inputs;
use Bookly\Backend\Components\Settings\Selects;
?>
<div class="tab-pane" id="bookly_settings_collaborative_services">
    <form method="post" action="<?php echo esc_url( add_query_arg( 'tab', 'collaborative_services' ) ) ?>">
        <div class="card-body">
            <?php Selects::renderSingle( 'bookly_collaborative_hide_staff', __( 'Do not allow to select a specific staff member', 'bookly' ), __( 'If this option is enabled then customers won\'t be able to select a staff member for collaborative services in the first step of the booking form', 'bookly' ) ) ?>
        </div>

        <div class="card-footer bg-transparent d-flex justify-content-end">
            <?php Inputs::renderCsrf() ?>
            <?php Buttons::renderSubmit() ?>
            <?php Buttons::renderReset( null, 'ml-2' ) ?>
        </div>
    </form>
</div>