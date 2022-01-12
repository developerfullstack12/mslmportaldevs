<?php
/**
 * GamiPress Vimeo Shortcode
 *
 * @package     GamiPress\Shortcodes\Shortcode\GamiPress_Vimeo
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register the [gamipress_vimeo] shortcode.
 *
 * @since 1.0.0
 */
function gamipress_register_vimeo_shortcode() {

    gamipress_register_shortcode( 'gamipress_vimeo', array(
        'name'            => __( 'Vimeo', 'gamipress-vimeo-integration' ),
        'description'     => __( 'Render a vimeo video.', 'gamipress-vimeo-integration' ),
        'output_callback' => 'gamipress_vimeo_shortcode',
        'fields'      => array(
            'url' => array(
                'name'        => __( 'URL or ID', 'gamipress-vimeo-integration' ),
                'description' => __( 'The Vimeo video URL or ID.', 'gamipress-vimeo-integration' ),
                'type' 	    => 'text',
            ),
            'width' => array(
                'name'        => __( 'Player width', 'gamipress-vimeo-integration' ),
                'description' => __( 'The player width (in pixels). By default, 640.', 'gamipress-vimeo-integration' ),
                'type' 	    => 'text',
                'default' 	=> '640',
            ),
            'height' => array(
                'name'        => __( 'Player height', 'gamipress-vimeo-integration' ),
                'description' => __( 'The player height (in pixels). By default, 360.', 'gamipress-vimeo-integration' ),
                'type' 	    => 'text',
                'default' 	=> '360',
            ),
            'from_url' => array(
                'name'              => __( 'Load video from URL', 'gamipress-vimeo-integration' ),
                'description'       => __( 'By default, video is loaded from ID. Check this option if video is private or if you can not get it loaded correctly.', 'gamipress-vimeo-integration' ),
                'type' 		        => 'checkbox',
                'classes' 	        => 'gamipress-switch',
            ),
        ),
    ) );

}
add_action( 'init', 'gamipress_register_vimeo_shortcode' );

/**
 * Vimeo Shortcode.
 *
 * @since  1.0.0
 *
 * @param  array $atts Shortcode attributes.
 * @return string 	   HTML markup.
 */
function gamipress_vimeo_shortcode( $atts = array() ) {

    // Get the received shortcode attributes
    $atts = shortcode_atts( array(
        'url'       => '',
        'width'     => '640',
        'height'    => '360',
        'from_url'  => 'no',
    ), $atts, 'gamipress_vimeo' );

    $video_id = gamipress_vimeo_get_video_id_from_url( $atts['url'] );
    $thumbnail_url = GAMIPRESS_VIMEO_URL . 'assets/img/vimeo-preview.svg';

    // Show thumbnail only if is an admin preview
    $show_thumbnail = ( defined( 'REST_REQUEST' ) && REST_REQUEST );

    // Show thumbnail only for blocks
    if( gamipress_get_renderer() !== 'block' ) {
        $show_thumbnail = false;
    }

    if( ! empty( $video_id ) && $show_thumbnail ) {
        $response = wp_remote_get( "http://vimeo.com/api/v2/video/{$video_id}.json" );
        $response_body = wp_remote_retrieve_body( $response );

        $data = json_decode( $response_body, true );

        if( isset( $data[0] ) && isset( $data[0]['thumbnail_large'] ) ) {
            $thumbnail_url = $data[0]['thumbnail_large'];
        }
    }

    ob_start(); ?>
    <div id="<?php echo $video_id; ?>" class="gamipress-vimeo-video"
         data-id="<?php echo $video_id; ?>"
         <?php // Loop all atts to place them as data attributes
         foreach( $atts as $att => $val ) : ?>
             data-<?php echo str_replace('_', '-', $att ); ?>="<?php echo $atts[$att]; ?>"
         <?php endforeach; ?>
         ><?php if( $show_thumbnail ) : ?><img src="<?php echo $thumbnail_url; ?>" width="<?php echo $atts['width']; ?>"/><?php endif; ?></div>
    <?php $output = ob_get_clean();

    // Return our rendered vimeo video
    return $output;

}
