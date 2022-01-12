<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * @var array $service
 * @var array $frequencies
 * @var array $recurrence_frequencies
 */
?>
<div class="form-group">
    <label><?php esc_html_e( 'Repeat', 'bookly' ) ?></label>
    <div class="custom-control custom-radio">
        <input type="radio" id="bookly-repeat-0" name="recurrence_enabled" value="0"<?php checked( $service['recurrence_enabled'], 0 ) ?> class="custom-control-input" />
        <label for="bookly-repeat-0" class="custom-control-label"><?php esc_html_e( 'Disabled', 'bookly' ) ?></label>
    </div>
    <div class="custom-control custom-radio">
        <input type="radio" id="bookly-repeat-1" name="recurrence_enabled" value="1"<?php checked( $service['recurrence_enabled'], 1 ) ?> class="custom-control-input" />
        <label for="bookly-repeat-1" class="custom-control-label"><?php esc_html_e( 'Enabled', 'bookly' ) ?></label>
    </div>
    <small class="form-text text-muted"><?php esc_html_e( 'Allow this service to have recurring appointments.', 'bookly' ) ?></small>
</div>
<div class="form-group border-left ml-4 pl-3"<?php if ( ! $service['recurrence_enabled'] ) : ?> style="display: none;"<?php endif ?>>
    <label><?php esc_html_e( 'Frequencies', 'bookly' ) ?></label>
    <ul class="bookly-js-simple-dropdown bookly-js-frequencies"
        data-container-class="bookly-dropdown-block"
        data-icon-class="far fa-calendar-alt"
        data-txt-select-all="<?php esc_attr_e( 'All', 'bookly' ) ?>"
        data-txt-all-selected="<?php esc_attr_e( 'All', 'bookly' ) ?>"
        data-txt-nothing-selected="<?php esc_attr_e( 'Nothing selected', 'bookly' ) ?>"
    >
        <?php foreach ( $frequencies as $type ): ?>
            <li data-input-name="recurrence_frequencies[]" data-value="<?php echo $type ?>" data-selected="<?php echo (int) in_array( $type, $recurrence_frequencies ) ?>">
                <?php esc_html_e( ucfirst( $type ), 'bookly' ) ?>
            </li>
        <?php endforeach ?>
    </ul>
</div>