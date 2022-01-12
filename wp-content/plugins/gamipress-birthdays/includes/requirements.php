<?php
/**
 * Requirements
 *
 * @package GamiPress\Birthdays\Requirements
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Add the score field to the requirement object
 *
 * @param $requirement
 * @param $requirement_id
 *
 * @return array
 */
function gamipress_birthdays_requirement_object( $requirement, $requirement_id ) {

    if( isset( $requirement['trigger_type'] )
        && ( $requirement['trigger_type'] === 'gamipress_birthdays_specific_birthday' ) ) {

        // Birthday
        $requirement['birthdays_birthday'] = get_post_meta( $requirement_id, '_gamipress_birthdays_birthday', true );

    }

    return $requirement;
}
add_filter( 'gamipress_requirement_object', 'gamipress_birthdays_requirement_object', 10, 2 );

/**
 * Category field on requirements UI
 *
 * @param $requirement_id
 * @param $post_id
 */
function gamipress_birthdays_requirement_ui_fields( $requirement_id, $post_id ) {

    $birthday = absint( get_post_meta( $requirement_id, '_gamipress_birthdays_birthday', true ) );

    if( $birthday === 0 ) {
        $birthday = 1;
    }
    ?>

    <span class="gamipress-birthdays-birthday"><?php echo __( 'Birthday:', 'gamipress-birthdays' ) ?><input type="number" min="1" step="1" value="<?php echo $birthday; ?>" placeholder="1" /></span>

    <?php
}
add_action( 'gamipress_requirement_ui_html_after_achievement_post', 'gamipress_birthdays_requirement_ui_fields', 10, 2 );

/**
 * Custom handler to save the score on requirements UI
 *
 * @param $requirement_id
 * @param $requirement
 */
function gamipress_birthdays_ajax_update_requirement( $requirement_id, $requirement ) {

    if( isset( $requirement['trigger_type'] )
        && ( $requirement['trigger_type'] === 'gamipress_birthdays_specific_birthday' ) ) {

        // Save the birthday field
        update_post_meta( $requirement_id, '_gamipress_birthdays_birthday', $requirement['birthdays_birthday'] );

    }

}
add_action( 'gamipress_ajax_update_requirement', 'gamipress_birthdays_ajax_update_requirement', 10, 2 );

/**
 * Settings warning
 *
 * @since 1.0.0
 *
 * @param integer $requirement_id
 * @param integer $post_id
 */
function gamipress_birthdays_requirements_notice( $requirement_id, $post_id ) {
    ?>
    <div class="gamipress-birthdays-requirements-notice" style="background-color: #fff0c9;color: #a27806;font-weight: 500;border-radius: 8px;padding: 14px 14px;margin-top: 8px;">
        <?php echo sprintf( __( '<strong>Important:</strong> Remember to configure the way to check the user birthday on the add-on <a href="%s" target="_blank">settings</a>.', 'gamipress-birthdays' ), admin_url( 'admin.php?page=gamipress_settings&tab=opt-tab-addons' ) ); ?>
    </div>
    <?php
}
add_action( 'gamipress_requirement_ui_html_after_requirement_title', 'gamipress_birthdays_requirements_notice', 10, 2 );