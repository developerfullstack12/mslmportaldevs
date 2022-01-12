<?php


use OTP\Addons\UmSMSNotification\Handler\UltimateMemberSMSNotificationsHandler;
$GD = UltimateMemberSMSNotificationsHandler::instance();
$Lk = $GD->moAddOnV();
$GZ = !$Lk ? "\144\151\x73\x61\x62\154\x65\x64" : '';
$current_user = wp_get_current_user();
$XJ = UMSN_DIR . "\143\x6f\x6e\x74\x72\157\154\154\x65\x72\x73\57";
$Ge = add_query_arg(array("\160\141\x67\145" => "\141\144\x64\x6f\156"), remove_query_arg("\141\144\x64\157\156", $_SERVER["\122\x45\121\x55\105\x53\124\137\125\x52\x49"]));
if (!isset($_GET["\141\x64\x64\x6f\x6e"])) {
    goto E_;
}
switch ($_GET["\x61\x64\x64\157\156"]) {
    case "\x75\x6d\x5f\x6e\x6f\x74\151\x66":
        include $XJ . "\165\155\55\x73\155\163\55\156\x6f\164\x69\146\151\x63\141\x74\x69\157\x6e\56\160\150\x70";
        goto oG;
}
Ok:
oG:
E_:
