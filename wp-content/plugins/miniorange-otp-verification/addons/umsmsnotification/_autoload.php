<?php


if (defined("\101\102\x53\x50\x41\124\110")) {
    goto rU;
}
die;
rU:
define("\125\x4d\x53\116\x5f\104\x49\122", plugin_dir_path(__FILE__));
define("\x55\x4d\x53\x4e\x5f\125\x52\x4c", plugin_dir_url(__FILE__));
define("\x55\115\123\x4e\x5f\126\x45\122\x53\111\x4f\x4e", "\x31\x2e\60\x2e\x30");
define("\125\115\x53\x4e\137\103\x53\123\137\125\122\x4c", UMSN_URL . "\x69\156\x63\154\x75\x64\145\163\x2f\143\x73\163\x2f\x73\x65\x74\x74\151\x6e\x67\163\56\x6d\151\156\56\143\x73\x73\x3f\x76\145\x72\163\x69\157\156\x3d" . UMSN_VERSION);
function get_umsn_option($iz, $Qh = null)
{
    $iz = ($Qh == null ? "\x6d\157\137\x75\x6d\137\x73\155\x73\137" : $Qh) . $iz;
    return get_mo_option($iz, '');
}
function update_umsn_option($hk, $zs, $Qh = null)
{
    $hk = ($Qh === null ? "\x6d\157\x5f\x75\155\137\x73\155\163\137" : $Qh) . $hk;
    update_mo_option($hk, $zs, '');
}
