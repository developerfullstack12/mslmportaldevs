<?php
/**
 * Template for the Edit Panel Components
 *
 * @since 2.0.0
 *
 * @var integer         $user_id
 * @var integer         $gradebook_id
 * @var LD_GB_UserGrade $user_grade
 * @var array           $component
 * @var string          $grade_format
 */

defined( 'ABSPATH' ) || die();
?>

<div class="ld-gb-frontend-gradebook-component" data-component="<?php echo esc_attr( $component['id'] ); ?>">

    <?php do_action( 'ld_gb_frontend_gradebook_edit_panel_component_grade', $component, $grade_format, $user_id, $gradebook_id ); ?>

    <table>
        <thead>
            <tr>
                <th colspan="2">
                    <?php _e( 'Name', 'learndash-gradebook' ); ?>
                </th>
                <th>
                    <?php _e( 'Score', 'learndash-gradebook' ); ?>
                </th>
            </tr>
        </thead>
        <tbody>

            <?php if ( ! empty( $component['grades'] ) ) : ?>

                <?php foreach ( $component['grades'] as $grade ) : ?>

                    <?php do_action( 'ld_gb_frontend_gradebook_edit_panel_grade_row', $grade, $user_grade, $component, $user_id, $gradebook_id, $grade_format ); ?>

                <?php endforeach; ?>

            <?php else : ?>

                <?php do_action( 'ld_gb_frontend_gradebook_edit_panel_no_grades', $user_grade, $component, $user_id, $gradebook_id ); ?>

            <?php endif; ?>

        </tbody>
    </table>

    <?php 

    if ( ! get_option( 'ld_gb_disable_manual_grades', false ) ) : 
    
        do_action( 'ld_gb_frontend_gradebook_edit_panel_grade_add', $user_id, $gradebook_id, $component, $user_grade, $grade_format );

    endif;

    do_action( 'ld_gb_frontend_gradebook_edit_panel_grade_edit', $user_id, $gradebook_id, $component, $grade_format ); ?>

</div>