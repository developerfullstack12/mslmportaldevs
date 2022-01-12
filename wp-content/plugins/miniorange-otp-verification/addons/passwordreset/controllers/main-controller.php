<?php


use OTP\Addons\PasswordReset\Handler\UMPasswordResetAddOnHandler;
$GD = UMPasswordResetAddOnHandler::instance();
$Vs = $GD->moAddOnV();
$GZ = !$Vs ? "\144\x69\163\x61\142\154\145\144" : '';
$current_user = wp_get_current_user();
$XJ = UMPR_DIR . "\143\x6f\156\x74\x72\157\154\x6c\145\x72\163\x2f";
$Ge = add_query_arg(array("\x70\141\147\x65" => "\x61\144\x64\x6f\x6e"), remove_query_arg("\141\x64\x64\x6f\156", $_SERVER["\122\x45\x51\x55\x45\x53\124\137\125\x52\111"]));
if (!isset($_GET["\x61\x64\x64\157\156"])) {
    goto Lm;
}
switch ($_GET["\x61\x64\144\157\x6e"]) {
    case "\165\x6d\160\x72\x5f\156\x6f\164\151\x66":
        include $XJ . "\x55\115\x50\x61\163\163\167\157\x72\144\x52\145\163\145\164\x2e\160\150\x70";
        goto Ga;
}
Fs:
Ga:
Lm:
