<?php
/**
 * Template for the Edit Panel Component
 *
 * @since 2.0.0
 *
 * @var integer         $user_id
 * @var integer         $gradebook_id
 * @var LD_GB_UserGrade $user_grade
 * @var string          $grade_format
 */

defined( 'ABSPATH' ) || die();
?>

<?php foreach ( $user_grade->get_components() as $component ) : ?>

    <?php do_action( 'ld_gb_frontend_gradebook_edit_panel_component', $user_id, $gradebook_id, $user_grade, $component, $grade_format ); ?>

<?php endforeach; ?>