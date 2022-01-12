<?php


use OTP\Addons\WcSMSNotification\Handler\WooCommerceNotifications;
$Lk = WooCommerceNotifications::instance()->moAddOnV();
$GZ = !$Lk ? "\144\151\163\141\142\x6c\x65\144" : '';
$current_user = wp_get_current_user();
$XJ = MSN_DIR . "\143\157\x6e\x74\x72\157\x6c\154\145\162\x73\x2f";
$Ge = add_query_arg(array("\160\141\x67\145" => "\x61\144\x64\157\x6e"), remove_query_arg("\141\144\x64\x6f\x6e", $_SERVER["\x52\x45\121\x55\105\x53\124\x5f\125\122\111"]));
if (!isset($_GET["\141\x64\144\x6f\x6e"])) {
    goto AB;
}
switch ($_GET["\x61\144\144\157\x6e"]) {
    case "\167\x6f\x6f\143\x6f\155\155\x65\162\143\145\x5f\x6e\x6f\x74\x69\146":
        include $XJ . "\x77\143\x2d\163\x6d\x73\55\x6e\x6f\164\x69\146\151\x63\x61\164\151\157\156\56\160\x68\x70";
        goto aL;
}
j2:
aL:
AB:
