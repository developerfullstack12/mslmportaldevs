<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components\Controls\Inputs;
?>
<div class="col-lg-4 col-xl-3 mb-2">
    <?php Inputs::renderCheckBox( __( 'Show Repeat step', 'bookly' ), null, get_option( 'bookly_recurring_appointments_enabled' ), array( 'id' => 'bookly-show-step-repeat', 'data-target' => 'bookly-step-4', 'data-type' => 'bookly-show-step-checkbox' ) ) ?>
</div>