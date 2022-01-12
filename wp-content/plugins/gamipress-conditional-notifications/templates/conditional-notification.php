<?php
/**
 * Conditional Notification template
 *
 * This template can be overridden by copying it to yourtheme/gamipress/conditional-notifications/conditional-notification.php
 */
global $gamipress_conditional_notifications_template_args;

// Shorthand
$a = $gamipress_conditional_notifications_template_args; ?>

<div class="gamipress-conditional-notification gamipress-conditional-notification-<?php echo $a['conditional_notification_id']; ?>">

    <?php
    /**
     * Before render the conditional notification
     *
     * @since 1.0.0
     *
     * @param integer   $conditional_notification_id    The conditional notification ID
     * @param stdClass  $conditional_notification       The conditional notification object
     * @param array     $template_args                  Template received arguments
     */
    do_action( 'gamipress_conditional_notifications_before_render_conditional_notification', $a['conditional_notification_id'], $a['conditional_notification'], $a ); ?>

    <?php // The title ?>
    <?php if( ! empty( $a['notification_title'] ) ) : ?>
        <h2 class="gamipress-notification-title gamipress-conditional-notification-title"><?php echo $a['notification_title']; ?></h2>
    <?php endif; ?>

    <?php // The content ?>
    <?php if( ! empty( $a['notification_content'] ) ) : ?>
        <div class="gamipress-notification-description gamipress-conditional-notification-description">
            <?php echo $a['notification_content']; ?>
        </div>
    <?php endif; ?>

    <?php
    /**
     * After render the conditional notification
     *
     * @since 1.0.0
     *
     * @param integer   $conditional_notification_id    The conditional notification ID
     * @param stdClass  $conditional_notification       The conditional notification object
     * @param array     $template_args                  Template received arguments
     */
    do_action( 'gamipress_conditional_notifications_after_render_conditional_notification', $a['conditional_notification_id'], $a['conditional_notification'], $a ); ?>

</div>