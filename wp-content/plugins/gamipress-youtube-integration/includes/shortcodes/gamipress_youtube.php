<?php
/**
 * GamiPress Youtube Shortcode
 *
 * @package     GamiPress\Shortcodes\Shortcode\GamiPress_Youtube
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register the [gamipress_youtube] shortcode.
 *
 * @since 1.0.0
 */
function gamipress_register_youtube_shortcode() {

    gamipress_register_shortcode( 'gamipress_youtube', array(
        'name'            => __( 'Youtube', 'gamipress-youtube-integration' ),
        'description'     => __( 'Render a youtube video.', 'gamipress-youtube-integration' ),
        'output_callback' => 'gamipress_youtube_shortcode',
        'fields'      => array(
            'url' => array(
                'name'        => __( 'URL or ID', 'gamipress-youtube-integration' ),
                'description' => __( 'The Youtube video URL or ID.', 'gamipress-youtube-integration' ),
                'type' 	    => 'text',
            ),
            'width' => array(
                'name'        => __( 'Player width', 'gamipress-youtube-integration' ),
                'description' => __( 'The player width (in pixels). By default, 640.', 'gamipress-youtube-integration' ),
                'type' 	    => 'text',
                'default' 	=> '640',
            ),
            'height' => array(
                'name'        => __( 'Player height', 'gamipress-youtube-integration' ),
                'description' => __( 'The player height (in pixels). By default, 360.', 'gamipress-youtube-integration' ),
                'type' 	    => 'text',
                'default' 	=> '360',
            ),
            'autoplay' => array(
                'name'        => __( 'Autoplay', 'gamipress-youtube-integration' ),
                'description' => __( 'Check this option to automatically play the video.', 'gamipress-youtube-integration' ),
                'type' 	    => 'checkbox',
                'classes' 	=> 'gamipress-switch',
            ),
            'controls' => array(
                'name'        => __( 'Show player controls?', 'gamipress-youtube-integration' ),
                'description' => __( 'Check this option to show player controls.', 'gamipress-youtube-integration' ),
                'type' 	    => 'checkbox',
                'classes' 	=> 'gamipress-switch',
                'default' 	=> 'yes',
            ),
        ),
    ) );

}
add_action( 'init', 'gamipress_register_youtube_shortcode' );

/**
 * Youtube Shortcode.
 *
 * @since  1.0.0
 *
 * @param  array $atts Shortcode attributes.
 * @return string 	   HTML markup.
 */
function gamipress_youtube_shortcode( $atts = array() ) {

    // Get the received shortcode attributes
    $atts = shortcode_atts( array(
        'url'       => '',
        'width'     => '640',
        'height'    => '360',
        'autoplay'  => 'no',
        'controls'  => 'yes',
    ), $atts, 'gamipress_youtube' );

    $video_id = gamipress_youtube_get_video_id_from_url( $atts['url'] );
    $thumbnail_url = GAMIPRESS_YOUTUBE_URL . 'assets/img/youtube-preview.svg';

    // Show thumbnail only if is an admin preview
    $show_thumbnail = ( defined( 'REST_REQUEST' ) && REST_REQUEST );

    // Show thumbnail only for blocks
    if( gamipress_get_renderer() !== 'block' ) {
        $show_thumbnail = false;
    }

    if( ! empty( $video_id ) ) {
        $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/maxresdefault.jpg";
    }

    ob_start(); ?>
    <div id="<?php echo $video_id; ?>" class="gamipress-youtube-video"
         data-id="<?php echo $video_id; ?>"
         <?php // Loop all atts to place them as data attributes
         foreach( $atts as $att => $val ) : ?>
             data-<?php echo $att; ?>="<?php echo $atts[$att]; ?>"
         <?php endforeach; ?>
         ><?php if( $show_thumbnail ) : ?><img src="<?php echo $thumbnail_url; ?>" width="<?php echo $atts['width']; ?>"/><?php endif; ?></div>
    <?php $output = ob_get_clean();

    // Return our rendered youtube video
    return $output;

}
