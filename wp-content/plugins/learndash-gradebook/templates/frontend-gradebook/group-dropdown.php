<?php
/**
 * Template for the Group Dropdown
 *
 * @since 2.0.0
 *
 * @var array           $group_ids
 * @var integer         $user_id
 * @var integer         $group_id
 */

defined( 'ABSPATH' ) || die();
?>

<div class="ld-gb-frontend-gradebook-group-dropdown-container">

    <?php $html_id = 'ld-gb-frontend-gradebook-group-dropdown-' . wp_generate_uuid4(); ?>

    <label for="<?php echo esc_attr( $html_id ); ?>">
        <?php _e( 'Showing Gradebook for:', 'learndash-gradebook' ); ?>
    </label>

    <select id="<?php echo esc_attr( $html_id ); ?>" class="ld-gb-frontend-gradebook-group-dropdown">
        <?php foreach ( $group_ids as $index => $id ) : ?>
            <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $id, $group_id ); ?>>
                <?php if ( $id == 0 ) : ?>
                    <?php _e( 'All Users', 'learndash-gradebook' ); ?>
                <?php else : ?>
                    <?php echo get_the_title( $id ); ?>
                <?php endif; ?>
            </option>
        <?php endforeach; ?>
    </select>

</div>