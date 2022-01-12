<?php


if (defined("\x41\102\123\120\101\124\x48")) {
    goto K3;
}
die;
K3:
define("\x55\115\x50\x52\137\104\x49\x52", plugin_dir_path(__FILE__));
define("\x55\x4d\x50\122\x5f\125\x52\x4c", plugin_dir_url(__FILE__));
define("\125\115\120\122\137\126\x45\122\x53\111\x4f\x4e", "\61\56\60\x2e\60");
define("\125\x4d\x50\122\137\103\x53\x53\x5f\x55\x52\114", UMPR_URL . "\x69\156\143\154\165\x64\x65\163\57\x63\163\163\x2f\163\145\164\x74\x69\156\x67\163\x2e\155\x69\x6e\56\143\x73\x73\77\x76\x65\162\163\x69\x6f\156\75" . UMPR_VERSION);
function get_umpr_option($iz, $Qh = null)
{
    $iz = ($Qh == null ? "\x6d\x6f\x5f\x75\155\137\160\x72\137" : $Qh) . $iz;
    return get_mo_option($iz, '');
}
function update_umpr_option($hk, $zs, $Qh = null)
{
    $hk = ($Qh === null ? "\155\157\137\165\155\x5f\x70\x72\137" : $Qh) . $hk;
    update_mo_option($hk, $zs, '');
}
