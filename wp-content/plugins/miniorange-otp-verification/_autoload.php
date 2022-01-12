<?php


use OTP\Helper\FormList;
use OTP\Helper\FormSessionData;
use OTP\Helper\MoUtility;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\SplClassLoader;
if (defined("\101\x42\123\120\101\124\110")) {
    goto eK;
}
die;
eK:
define("\x4d\x4f\126\x5f\104\x49\x52", plugin_dir_path(__FILE__));
define("\x4d\117\126\137\x55\x52\114", plugin_dir_url(__FILE__));
$Re = wp_remote_retrieve_body(wp_remote_get(MOV_URL . "\160\141\x63\x6b\x61\147\x65\56\152\x73\x6f\156", array("\x73\163\x6c\x76\x65\x72\151\146\x79" => false)));
$tK = json_decode($Re);
if (!(json_last_error() !== 0)) {
    goto UU;
}
$tK = json_decode(initializePackageJson());
UU:
define("\115\x4f\126\x5f\126\x45\122\123\x49\x4f\x4e", $tK->version);
define("\115\117\126\x5f\x54\131\x50\105", $tK->type);
define("\115\117\x56\137\x48\117\123\124", $tK->hostname);
define("\115\x4f\x56\x5f\104\x45\106\x41\x55\x4c\x54\137\x43\125\123\x54\117\115\105\x52\x4b\105\131", $tK->dCustomerKey);
define("\x4d\x4f\126\137\x44\x45\106\x41\125\x4c\x54\x5f\x41\x50\x49\113\x45\x59", $tK->dApiKey);
define("\115\x4f\126\x5f\x53\x53\x4c\x5f\126\x45\122\x49\106\x59", $tK->sslVerify);
define("\115\x4f\x56\137\103\x53\x53\x5f\125\x52\114", MOV_URL . "\151\x6e\x63\x6c\165\x64\145\x73\57\143\x73\x73\x2f\155\x6f\x5f\143\165\x73\x74\157\155\145\x72\x5f\166\141\x6c\x69\x64\x61\164\151\x6f\x6e\137\x73\164\171\154\145\56\x6d\x69\x6e\x2e\x63\163\x73\77\166\x65\x72\163\x69\x6f\x6e\x3d" . MOV_VERSION);
define("\115\117\126\x5f\x46\x4f\x52\115\137\103\123\x53", MOV_URL . "\x69\156\143\154\165\x64\145\x73\57\143\163\x73\x2f\155\157\x5f\x66\157\162\x6d\x73\137\143\163\x73\56\x6d\151\x6e\56\143\x73\x73\x3f\x76\x65\162\x73\151\157\156\x3d" . MOV_VERSION);
define("\115\117\x5f\111\x4e\124\x54\105\114\111\x4e\120\x55\124\x5f\103\x53\123", MOV_URL . "\151\156\x63\154\x75\x64\x65\x73\57\143\163\163\x2f\151\x6e\164\x6c\124\145\x6c\111\156\x70\x75\x74\x2e\155\x69\156\x2e\143\x73\x73\77\x76\145\x72\163\x69\x6f\x6e\75" . MOV_VERSION);
define("\x4d\x4f\126\x5f\x4a\123\x5f\125\122\114", MOV_URL . "\x69\x6e\x63\x6c\x75\144\145\163\x2f\152\163\57\x73\145\164\164\151\156\x67\x73\x2e\155\x69\x6e\x2e\x6a\163\77\x76\x65\x72\x73\151\157\x6e\x3d" . MOV_VERSION);
define("\x56\101\114\111\x44\101\x54\x49\x4f\116\137\x4a\123\137\x55\x52\x4c", MOV_URL . "\151\156\x63\x6c\165\144\145\163\x2f\152\x73\x2f\x66\x6f\162\x6d\x56\141\x6c\x69\144\x61\x74\x69\157\156\x2e\155\151\156\56\152\x73\77\x76\x65\162\x73\151\157\x6e\x3d" . MOV_VERSION);
define("\x4d\x4f\x5f\111\x4e\x54\x54\105\114\111\116\x50\125\x54\137\112\x53", MOV_URL . "\151\x6e\x63\x6c\x75\x64\x65\x73\x2f\152\163\57\x69\x6e\x74\154\x54\145\x6c\x49\x6e\160\x75\x74\56\155\151\156\56\x6a\163\77\166\145\162\x73\x69\157\156\75" . MOV_VERSION);
define("\x4d\x4f\137\x44\122\117\120\x44\117\127\x4e\137\112\x53", MOV_URL . "\151\156\143\x6c\x75\x64\x65\163\57\x6a\163\x2f\144\162\x6f\x70\144\x6f\x77\156\x2e\x6d\x69\x6e\x2e\152\x73\x3f\166\145\162\x73\151\x6f\156\x3d" . MOV_VERSION);
define("\115\x4f\x56\x5f\x4c\117\x41\104\105\x52\137\125\x52\x4c", MOV_URL . "\151\x6e\143\x6c\165\144\145\163\x2f\151\155\141\147\x65\x73\57\x6c\x6f\141\x64\x65\162\x2e\x67\151\146");
define("\115\117\x56\137\x44\117\116\101\124\x45", MOV_URL . "\x69\156\x63\154\165\144\145\163\x2f\151\x6d\x61\147\x65\x73\57\144\157\156\x61\164\145\56\160\156\147");
define("\115\117\x56\x5f\120\101\x59\x50\101\114", MOV_URL . "\151\x6e\143\154\165\144\x65\x73\57\x69\155\141\147\x65\x73\x2f\x70\141\171\x70\x61\154\x2e\x70\156\x67");
define("\x4d\x4f\x56\137\116\105\124\x42\101\x4e\113", MOV_URL . "\151\x6e\x63\154\165\x64\x65\163\57\151\155\141\147\145\x73\x2f\x6e\145\x74\x62\x61\x6e\153\x69\x6e\147\56\160\x6e\x67");
define("\x4d\117\126\x5f\103\101\122\x44", MOV_URL . "\x69\156\143\154\x75\x64\145\x73\57\x69\x6d\141\147\145\163\57\x63\x61\x72\x64\56\160\156\147");
define("\115\x4f\x56\x5f\114\x4f\107\x4f\137\x55\x52\114", MOV_URL . "\151\156\143\154\165\144\x65\x73\x2f\x69\155\x61\x67\145\163\57\x6c\x6f\147\x6f\56\x70\156\147");
define("\115\x4f\126\x5f\111\103\117\x4e", MOV_URL . "\x69\x6e\x63\154\x75\144\145\163\x2f\x69\x6d\x61\x67\145\163\57\155\151\x6e\x69\157\x72\x61\x6e\147\145\137\151\x63\157\x6e\x2e\x70\x6e\x67");
define("\115\x4f\x56\x5f\111\x43\117\x4e\x5f\107\111\106", MOV_URL . "\x69\x6e\x63\x6c\165\x64\x65\x73\x2f\151\155\141\x67\145\163\57\155\157\x5f\x69\143\x6f\x6e\x2e\147\x69\146");
define("\115\x4f\137\103\x55\x53\124\x4f\x4d\x5f\x46\x4f\x52\x4d", MOV_URL . "\x69\x6e\x63\154\165\x64\x65\x73\x2f\x6a\x73\57\143\x75\163\x74\x6f\x6d\106\157\x72\155\x2e\152\x73\x3f\x76\145\x72\x73\x69\157\x6e\75" . MOV_VERSION);
define("\x4d\x4f\x56\x5f\101\x44\x44\117\x4e\137\104\111\122", MOV_DIR . "\x61\144\x64\x6f\x6e\x73\57");
define("\x4d\117\126\x5f\x55\x53\x45\137\x50\x4f\114\x59\x4c\101\x4e\x47", TRUE);
define("\115\x4f\137\124\105\123\124\137\115\x4f\104\x45", $tK->testMode);
define("\x4d\117\137\x46\x41\111\x4c\137\x4d\x4f\104\x45", $tK->failMode);
define("\x4d\117\126\x5f\123\105\123\123\111\x4f\116\137\124\131\120\105", $tK->session);
define("\115\117\x56\137\115\x41\x49\x4c\x5f\114\117\x47\x4f", MOV_URL . "\151\x6e\143\x6c\x75\144\x65\163\57\151\x6d\141\147\x65\163\57\155\157\137\163\x75\x70\x70\x6f\162\164\x5f\151\143\157\x6e\56\160\x6e\147");
define("\x4d\117\x56\x5f\x4f\x46\x46\x45\122\123\x5f\x4c\117\x47\117", MOV_URL . "\x69\156\x63\154\165\x64\x65\163\57\151\155\141\147\x65\x73\x2f\155\157\x5f\x73\141\x6c\145\x5f\x69\143\157\x6e\x2e\x70\156\147");
define("\x4d\x4f\x56\x5f\x46\x45\x41\124\125\122\105\123\137\107\122\x41\120\x48\111\103", MOV_URL . "\x69\156\143\154\x75\x64\145\163\57\151\155\x61\x67\145\x73\57\155\157\137\x66\x65\141\164\165\x72\145\163\x5f\147\x72\141\160\x68\x69\143\56\x70\x6e\x67");
define("\115\117\x56\137\x54\131\120\105\137\120\114\101\x4e", $tK->typePlan);
define("\x4d\117\126\x5f\114\x49\x43\105\116\x53\105\x5f\116\x41\x4d\105", $tK->licenseName);
include "\x53\x70\154\x43\154\141\x73\163\x4c\x6f\x61\144\145\x72\56\160\x68\160";
$aj = new SplClassLoader("\117\x54\x50", realpath(__DIR__ . DIRECTORY_SEPARATOR . "\56\56"));
$aj->register();
require_once "\x76\x69\145\x77\163\x2f\143\x6f\x6d\x6d\157\x6e\x2d\x65\x6c\x65\155\x65\x6e\x74\163\56\x70\x68\x70";
initializeForms();
function initializeForms()
{
    $Mv = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(MOV_DIR . "\150\141\x6e\144\x6c\x65\162\x2f\146\x6f\162\155\163", RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($Mv as $D2) {
        $QN = $D2->getFilename();
        $S0 = "\x4f\x54\120\x5c\x48\x61\x6e\x64\x6c\145\x72\x5c\106\157\x72\x6d\x73\134" . str_replace("\56\x70\150\160", '', $QN);
        $ri = FormList::instance();
        $t8 = $S0::instance();
        $ri->add($t8->getFormKey(), $t8);
        Ja:
    }
    oE:
}
function admin_post_url()
{
    return admin_url("\141\x64\155\151\x6e\x2d\160\x6f\163\x74\x2e\160\150\160");
}
function wp_ajax_url()
{
    return admin_url("\x61\144\x6d\x69\x6e\x2d\x61\x6a\x61\x78\56\x70\150\160");
}
function mo_($iz)
{
    $E_ = "\155\151\x6e\x69\x6f\162\x61\156\147\145\x2d\x6f\x74\160\55\166\x65\162\x69\x66\151\143\x61\164\x69\157\x6e";
    $iz = preg_replace("\57\x5c\x73\53\57\x53", "\40", $iz);
    return is_scalar($iz) ? MoUtility::_is_polylang_installed() && MOV_USE_POLYLANG ? pll__($iz) : __($iz, $E_) : $iz;
}
function get_mo_option($iz, $Qh = null)
{
    $iz = ($Qh === null ? "\155\x6f\137\x63\165\163\x74\x6f\x6d\x65\x72\137\x76\141\x6c\x69\x64\x61\x74\x69\157\156\137" : $Qh) . $iz;
    return apply_filters("\x67\145\164\x5f\155\x6f\x5f\x6f\160\x74\151\157\x6e", get_site_option($iz));
}
function update_mo_option($iz, $zs, $Qh = null)
{
    $iz = ($Qh === null ? "\155\x6f\137\143\x75\163\164\157\x6d\x65\x72\x5f\166\x61\x6c\151\144\141\x74\151\157\x6e\x5f" : $Qh) . $iz;
    update_site_option($iz, apply_filters("\165\160\144\x61\164\145\137\155\x6f\x5f\157\x70\164\x69\x6f\x6e", $zs, $iz));
}
function delete_mo_option($iz, $Qh = null)
{
    $iz = ($Qh === null ? "\155\x6f\137\x63\x75\163\164\x6f\155\x65\x72\137\x76\141\154\151\144\141\164\x69\x6f\x6e\x5f" : $Qh) . $iz;
    delete_site_option($iz);
}
function get_mo_class($yG)
{
    $AZ = get_class($yG);
    return substr($AZ, strrpos($AZ, "\134") + 1);
}
function initializePackageJson()
{
    $E9 = json_encode(array("\x6e\141\x6d\x65" => "\x6d\x69\156\151\x6f\162\x61\x6e\x67\145\x2d\157\x74\160\55\166\145\162\151\146\151\143\141\x74\x69\157\x6e\55\x6f\156\x70\x72\145\x6d\55\164\167\x69\154\151\157", "\x76\145\x72\163\151\157\x6e" => "\61\x32\56\67", "\x74\171\160\x65" => "\124\167\151\x6c\x69\x6f\x47\x61\164\x65\x77\141\171\127\151\164\150\101\x64\x64\157\x6e\x73", "\x74\x65\x73\x74\x4d\157\x64\x65" => false, "\x66\x61\151\x6c\x4d\157\x64\145" => false, "\150\x6f\163\x74\156\141\x6d\145" => "\x68\x74\x74\x70\x73\72\x2f\x2f\154\157\x67\x69\x6e\56\x78\145\x63\x75\x72\151\146\x79\56\x63\x6f\155", "\144\x43\165\x73\164\x6f\155\x65\162\113\x65\x79" => "\x31\x36\65\65\65", "\144\x41\x70\151\113\x65\171" => "\146\106\144\62\x58\143\x76\124\107\104\x65\155\x5a\166\142\167\61\142\x63\x55\145\x73\116\x4a\x57\x45\161\113\x62\x62\x55\161", "\163\x73\x6c\x56\145\x72\151\146\171" => false, "\163\x65\163\163\151\x6f\156" => "\124\x52\101\x4e\x53\x49\x45\116\124", "\164\x79\160\x65\x50\154\x61\x6e" => "\x77\160\137\145\x6d\141\151\x6c\137\x76\145\x72\151\x66\151\x63\x61\164\x69\157\156\x5f\151\x6e\x74\x72\x61\156\x65\x74\x5f\164\x77\x69\x6c\x69\157\x5f\x62\141\163\151\x63\137\160\154\x61\156", "\x6c\151\143\x65\156\163\145\x4e\x61\155\x65" => "\x57\120\137\105\115\x41\x49\114\x5f\126\x45\122\111\106\x49\x43\101\x54\111\117\116\137\111\x4e\124\122\x41\116\x45\124\137\124\127\111\x4c\111\x4f\x5f\102\x41\123\x49\x43\137\120\114\101\116"));
    return $E9;
}
