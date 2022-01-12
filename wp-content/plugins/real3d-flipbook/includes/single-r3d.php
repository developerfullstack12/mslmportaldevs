<?php 

$r3d_post_id = get_the_ID();
$r3d_id = get_post_meta($r3d_post_id, 'flipbook_id', true);
$flipbook = get_option('real3dflipbook_' . $r3d_id);
if(isset($flipbook['mode']) && $flipbook['mode'] == "fullscreen")
	?>
	<style>header, footer{display:none;}</script>
	<?php
get_header();
echo do_shortcode('[real3dflipbook id="'.$r3d_id.'"]');
get_footer();





