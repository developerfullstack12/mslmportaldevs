<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<div class='wrap'>

  <p id="msg"></p>
	
</div>
<?php 


$real3dflipbooks_ids = get_option('real3dflipbooks_ids');
if(!$real3dflipbooks_ids){
	$real3dflipbooks_ids = array();
}

wp_enqueue_script( "real3d-flipbook-activation"); 
$r3d_nonce = wp_create_nonce( "r3d_nonce");
wp_localize_script( 'real3d-flipbook-activation', 'r3d_nonce', array($r3d_nonce) );
wp_localize_script( 'real3d-flipbook-activation', 'flipbooks', array($real3dflipbooks_ids) );