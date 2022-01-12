<?php
/**
 * Template for the Edit Panel
 *
 * @since 2.0.0
 *
 * @var integer         $user_id
 * @var integer         $gradebook_id
 * @var integer         $group_id
 * @var string          $grade_format
 */

defined( 'ABSPATH' ) || die();

$user_grade = new LD_GB_UserGrade( $user_id, $gradebook_id );

?>

<div class="ld-gb-frontend-gradebook-edit-panel">

    <?php do_action( 'ld_gb_frontend_gradebook_edit_panel_back_to_gradebook', $user_id, $gradebook_id ); ?>

    <?php if ( $user_id ) : ?>

        <?php do_action( 'lb_gb_frontend_gradebook_edit_panel_user_grade', $user_id, $gradebook_id, $user_grade, $grade_format ); ?>

        <?php do_action( 'ld_gb_frontend_gradebook_edit_panel_components', $user_id, $gradebook_id, $user_grade, $grade_format ); ?>

        <?php do_action( 'ld_gb_frontend_gradebook_edit_panel_manual_grade_form', $user_id, $gradebook_id ); ?>

    <?php endif; ?>

</div>