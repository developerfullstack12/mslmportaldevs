<?php

use OTP\Addons\passwordResetWp\Handler\WpPasswordResetAddOnHandler;

/** @var WpPasswordResetAddOnHandler $handler */
$handler        = WpPasswordResetAddOnHandler::instance();
$registered 	= $handler->moAddOnV();
$disabled  	 	= !$registered ? "disabled" : "";
$current_user 	= wp_get_current_user();
$controller 	= WPPR_DIR . 'controllers/';
$addon          = add_query_arg( array('page' => 'addon'), remove_query_arg('addon',$_SERVER['REQUEST_URI']));

if(isset( $_GET[ 'addon' ]))
{
    switch($_GET['addon'])
    {
        case 'wppr_notif':
            include $controller . 'WpPasswordReset.php'; break;
    }
}