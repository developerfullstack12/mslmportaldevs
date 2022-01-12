<?php


use OTP\Addons\CustomMessage\Handler\CustomMessages;
$GD = CustomMessages::instance();
$Lk = $GD->moAddOnV();
$GZ = !$Lk ? "\144\151\x73\141\x62\154\145\144" : '';
$current_user = wp_get_current_user();
$XJ = MCM_DIR . "\x63\157\x6e\x74\162\157\154\x6c\145\162\x73\x2f";
$Ge = add_query_arg(array("\x70\141\x67\145" => "\x61\x64\x64\x6f\156"), remove_query_arg("\141\x64\144\x6f\x6e", $_SERVER["\x52\x45\121\125\x45\x53\124\137\125\122\x49"]));
if (!isset($_GET["\141\144\144\157\156"])) {
    goto dm;
}
switch ($_GET["\x61\144\x64\157\x6e"]) {
    case "\143\165\163\x74\157\155":
        include $XJ . "\x63\165\163\164\x6f\x6d\x2e\x70\x68\160";
        goto uA;
}
lJ:
uA:
dm:
