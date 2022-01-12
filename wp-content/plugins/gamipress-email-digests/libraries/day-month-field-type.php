<?php

if( ! function_exists( 'gamipress_render_day_month_field_type' ) ) {

    /**
     * Adds a custom field type to store day month only.
     *
     * @param  object $field             The CMB2_Field type object.
     * @param  string $value             The saved (and escaped) value.
     * @param  int    $object_id         The current post ID.
     * @param  string $object_type       The current object type.
     * @param  object $field_type        The CMB2_Types object.
     *
     * @return void
     */
    function gamipress_render_day_month_field_type( $field, $value, $object_id, $object_type, $field_type ) {

        // Make sure we specify each part of the value we need.
        $value = wp_parse_args( $value, array(
            'day' => '',
            'month' => '',
        ) );

        $day_input = $field_type->input( array(
            'name'  => $field_type->_name( '[day]' ),
            'id'    => $field_type->_id( '_day' ),
            'value' => $value['day'],
            'desc'  => '',
            'type' => 'number',
            'step' => 1,
            'min' => 1,
            'max' => 31,
            'placeholder' => 'day',
            'class' => 'small-text',
            'style' => 'width: 70px;',
        ) );

        $month_input = $field_type->input( array(
            'name'  => $field_type->_name( '[month]' ),
            'id'    => $field_type->_id( '_month' ),
            'value' => $value['month'],
            'desc'  => '',
            'type' => 'number',
            'step' => 1,
            'min' => 1,
            'max' => 12,
            'placeholder' => 'month',
            'class' => 'small-text',
            'style' => 'width: 70px;',
        ) );

        ?>

        <ul class="cmb-inline">
            <li style="padding: 0;">
                <?php echo $day_input; ?>
            </li>
            <li style="padding: 0;">
                /
            </li>
            <li>
                <?php echo $month_input ?>
            </li>
        </ul>
        <?php

        $field_type->_desc( true, true );
    }
    add_action( 'cmb2_render_day_month', 'gamipress_render_day_month_field_type', 10, 5 );


    /**
     * Sanitize the selected value.
     */
    function gamipress_sanitize_day_month_callback( $override_value, $value ) {
        if ( is_array( $value ) ) {
            foreach ( $value as $key => $saved_value ) {
                $value[$key] = sanitize_text_field( $saved_value );
            }

            return $value;
        }

        return;
    }
    add_filter( 'cmb2_sanitize_day_month', 'gamipress_sanitize_day_month_callback', 10, 2 );

}