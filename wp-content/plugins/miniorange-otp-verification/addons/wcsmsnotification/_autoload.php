<?php


if (defined("\x41\x42\123\x50\x41\124\110")) {
    goto bn;
}
die;
bn:
define("\115\x53\x4e\137\104\x49\x52", plugin_dir_path(__FILE__));
define("\x4d\x53\116\137\x55\x52\x4c", plugin_dir_url(__FILE__));
define("\115\x53\x4e\137\126\105\x52\123\111\x4f\116", "\61\x2e\x30\x2e\60");
define("\x4d\123\x4e\x5f\103\x53\x53\x5f\125\x52\x4c", MSN_URL . "\151\x6e\143\x6c\x75\x64\145\x73\57\143\163\163\57\x73\145\164\164\x69\156\x67\163\x2e\x6d\151\x6e\56\143\x73\163\x3f\x76\145\x72\163\151\157\156\75" . MSN_VERSION);
define("\115\123\116\137\112\123\137\x55\122\114", MSN_URL . "\x69\156\143\154\165\144\145\163\57\152\163\x2f\163\145\164\x74\x69\x6e\147\x73\x2e\155\151\156\x2e\152\163\x3f\x76\x65\162\163\x69\x6f\x6e\75" . MSN_VERSION);
function get_wc_option($iz, $Qh = null)
{
    $iz = ($Qh === null ? "\155\157\137\x77\143\x5f\x73\155\x73\137" : $Qh) . $iz;
    return get_mo_option($iz, '');
}
function update_wc_option($hk, $zs, $Qh = null)
{
    $hk = ($Qh === null ? "\x6d\157\x5f\167\143\x5f\x73\x6d\x73\x5f" : $Qh) . $hk;
    update_mo_option($hk, $zs, '');
}
