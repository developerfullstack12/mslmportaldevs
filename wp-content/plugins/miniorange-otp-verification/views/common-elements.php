<?php


use OTP\Helper\CountryList;
use OTP\Helper\FormList;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoUtility;
use OTP\Helper\Templates\DefaultPopup;
use OTP\Helper\Templates\ErrorPopup;
use OTP\Helper\Templates\ExternalPopup;
use OTP\Helper\Templates\UserChoicePopup;
use OTP\Objects\FormHandler;
use OTP\Objects\TabDetails;
use OTP\Objects\Tabs;
function get_plugin_form_link($Cg)
{
    if (!MoUtility::sanitizeCheck("\x66\157\162\x6d\x4c\151\x6e\153", $Cg)) {
        goto QS;
    }
    echo "\x3c\x61\40\x20\40\40\x63\x6c\x61\163\x73\x3d\x22\144\x61\x73\x68\x69\143\157\156\163\40\x6d\x6f\55\x66\157\162\155\x2d\x6c\151\156\153\x73\40\144\x61\x73\x68\x69\143\157\156\163\55\146\x65\145\x64\142\141\143\x6b\40\155\157\x5f\x66\157\162\155\137\151\143\157\x6e\42\40\15\12\x20\x20\x20\x20\40\40\40\40\40\40\40\x20\40\40\x20\x20\x20\x20\x20\40\150\x72\x65\x66\x3d\x22" . $Cg["\146\157\162\x6d\114\151\x6e\153"] . "\42\x20\xd\xa\40\40\40\40\x20\x20\40\x20\40\40\40\x20\40\40\x20\40\40\x20\40\x20\x74\151\164\154\x65\75\x22" . $Cg["\x66\x6f\x72\x6d\x4c\151\x6e\x6b"] . "\42\15\12\x20\x20\40\40\x20\40\40\40\x20\x20\40\40\x20\40\x20\40\40\x20\x20\x20\151\144\x3d\x22\146\x6f\162\155\114\151\156\153\42\40\x20\15\xa\40\x20\40\x20\40\40\40\40\x20\x20\x20\x20\x20\40\x20\40\x20\40\x20\40\x74\x61\162\147\x65\x74\75\x22\137\142\154\x61\156\x6b\x22\76" . "\74\163\x70\x61\156\x20\x63\x6c\x61\163\163\75\42\155\157\x2d\x6c\x69\156\153\x2d\x74\x65\x78\164\42\76" . mo_("\x46\157\x72\x6d\x4c\151\156\x6b") . "\74\x2f\163\x70\x61\x6e\76" . "\x3c\57\x61\x3e";
    QS:
    if (!MoUtility::sanitizeCheck("\147\165\151\144\x65\x4c\x69\x6e\x6b", $Cg)) {
        goto bJ;
    }
    echo "\x3c\x61\40\40\40\40\143\x6c\x61\163\x73\x3d\x22\x64\x61\x73\150\151\x63\157\x6e\163\x20\x6d\x6f\x2d\146\157\x72\x6d\x2d\154\151\x6e\x6b\x73\40\x64\x61\x73\150\151\143\157\x6e\x73\x2d\x62\x6f\x6f\153\55\x61\x6c\164\40\155\157\x5f\x62\157\x6f\x6b\x5f\151\143\x6f\x6e\x22\x20\15\12\40\40\x20\x20\x20\40\40\x20\x20\x20\x20\40\40\40\40\x20\40\40\40\x20\150\162\x65\x66\75\42" . $Cg["\x67\165\x69\144\145\x4c\151\x6e\x6b"] . "\x22\x20\xd\xa\x20\x20\40\x20\40\40\x20\x20\x20\40\x20\x20\x20\40\40\x20\40\40\40\x20\x74\x69\x74\x6c\145\x3d\42\x49\156\163\164\162\x75\143\164\x69\x6f\156\x20\x47\165\151\144\145\x22\xd\xa\40\40\x20\x20\x20\x20\40\40\40\x20\40\40\40\40\x20\x20\40\x20\40\40\x69\x64\x3d\42\147\x75\x69\x64\x65\x4c\151\156\153\x22\x20\xd\xa\x20\40\x20\x20\40\x20\x20\40\x20\x20\40\x20\40\40\x20\40\40\40\40\40\x74\141\162\x67\145\164\75\42\137\x62\154\x61\156\153\x22\x3e" . "\74\x73\160\x61\156\x20\143\x6c\141\x73\x73\x3d\x22\155\157\55\x6c\151\x6e\153\55\x74\x65\x78\x74\42\x3e" . mo_("\123\145\164\165\x70\x20\x47\165\x69\x64\145") . "\74\x2f\163\160\141\x6e\x3e" . "\x3c\57\x61\x3e";
    bJ:
    if (!MoUtility::sanitizeCheck("\166\151\x64\145\157\114\x69\156\x6b", $Cg)) {
        goto Rn;
    }
    echo "\x3c\141\x20\40\40\40\143\x6c\141\163\x73\x3d\x22\144\x61\163\150\x69\x63\157\156\x73\x20\x6d\157\x2d\146\157\162\155\x2d\x6c\x69\x6e\x6b\163\x20\144\141\x73\150\x69\143\x6f\x6e\x73\x2d\x76\151\144\x65\x6f\x2d\x61\154\164\63\x20\x6d\157\x5f\x76\151\144\x65\x6f\137\151\x63\x6f\x6e\x22\40\xd\xa\40\40\40\x20\x20\x20\40\40\x20\40\x20\x20\x20\x20\x20\40\x20\40\40\x20\150\162\145\x66\75\x22" . $Cg["\166\x69\x64\x65\x6f\x4c\x69\156\x6b"] . "\42\x20\15\xa\40\x20\40\40\x20\x20\x20\x20\x20\40\40\x20\40\40\40\x20\x20\40\40\x20\164\151\x74\154\145\75\42\x54\x75\164\157\x72\151\x61\154\40\126\x69\144\x65\x6f\x22\xd\12\40\x20\x20\x20\x20\40\x20\x20\x20\40\x20\x20\40\40\40\40\x20\x20\x20\x20\151\x64\75\x22\x76\151\x64\x65\x6f\114\x69\156\x6b\42\40\40\xd\xa\x20\x20\40\x20\x20\40\x20\x20\x20\40\x20\40\40\x20\x20\x20\x20\x20\x20\x20\164\x61\x72\x67\145\164\x3d\x22\x5f\x62\x6c\141\x6e\x6b\x22\x3e" . "\x3c\163\160\x61\x6e\x20\x63\154\141\x73\163\75\42\155\x6f\55\154\151\156\153\x2d\x74\145\170\x74\x22\76" . mo_("\126\x69\144\x65\157\40\124\165\x74\x6f\x72\151\141\x6c") . "\74\57\163\160\x61\x6e\x3e" . "\74\57\x61\x3e";
    Rn:
    echo "\x3c\x62\x72\x2f\76\74\142\x72\x2f\76";
}
function mo_draw_tooltip($w_, $SF)
{
    echo "\x3c\163\160\x61\156\40\143\154\141\163\x73\75\x22\164\157\x6f\154\164\x69\x70\x22\76\xd\xa\x20\40\40\x20\40\40\x20\40\40\40\40\x20\x3c\x73\160\x61\x6e\x20\x63\x6c\141\x73\163\75\x22\144\141\163\x68\x69\x63\157\156\163\x20\144\141\x73\x68\151\143\157\x6e\163\55\145\144\x69\164\x6f\162\x2d\150\145\x6c\x70\42\76\x3c\x2f\163\160\x61\156\76\xd\12\40\x20\40\x20\x20\x20\40\x20\40\x20\40\x20\74\x73\x70\141\156\40\x63\x6c\141\x73\163\x3d\42\x74\157\x6f\x6c\164\x69\x70\x74\145\170\164\x22\76\xd\xa\40\x20\40\x20\40\40\40\x20\x20\x20\40\x20\40\x20\x20\x20\74\x73\160\141\x6e\40\143\154\x61\163\x73\x3d\x22\150\x65\141\144\x65\162\42\76\74\142\76\74\151\x3e" . mo_($w_) . "\x3c\57\151\76\x3c\x2f\142\76\x3c\57\163\x70\x61\x6e\x3e\x3c\x62\162\x2f\76\x3c\142\x72\57\76\xd\xa\x20\x20\40\40\40\x20\x20\x20\x20\x20\40\40\x20\x20\40\x20\74\163\x70\141\156\40\143\154\141\163\x73\x3d\x22\x62\157\x64\x79\x22\x3e" . mo_($SF) . "\74\57\x73\160\141\156\x3e\xd\12\40\x20\40\x20\40\40\40\40\40\x20\40\40\74\57\163\160\x61\x6e\x3e\xd\xa\x20\40\40\40\40\40\40\40\x20\40\74\x2f\163\x70\141\156\76";
}
function extra_post_data($pO = null)
{
    $ZA = array("\x6d\x6f\x46\x69\145\154\x64\163" => array("\157\x70\x74\151\x6f\x6e", "\x6d\x6f\x5f\157\x74\160\137\164\157\153\x65\x6e", "\x6d\x69\156\x69\x6f\x72\x61\156\147\145\137\157\164\160\x5f\x74\157\153\145\x6e\x5f\x73\165\142\x6d\x69\x74", "\155\151\156\x69\x6f\x72\141\156\x67\x65\x2d\166\x61\x6c\151\x64\141\164\x65\55\x6f\x74\160\x2d\143\150\157\151\x63\145\55\146\x6f\x72\x6d", "\x73\165\x62\x6d\151\164", "\155\x6f\x5f\x63\x75\x73\x74\x6f\155\145\162\x5f\x76\x61\x6c\x69\144\x61\x74\x69\x6f\156\x5f\157\164\x70\137\x63\150\157\x69\143\x65", "\x72\145\147\x69\x73\164\145\162\x5f\x6e\x6f\x6e\x63\x65", "\164\151\155\145\x73\164\x61\155\x70"), "\x6c\x6f\147\151\x6e\117\x72\x53\x6f\x63\x69\141\154\x46\x6f\x72\155" => array("\x75\x73\145\x72\x5f\154\x6f\x67\151\x6e", "\x75\x73\145\162\x5f\145\x6d\x61\151\154", "\162\145\147\151\x73\164\x65\162\137\x6e\157\156\143\x65", "\157\160\164\x69\x6f\156", "\162\x65\147\x69\163\164\x65\x72\137\164\155\154\x5f\x6e\157\156\143\x65", "\x6d\x6f\137\157\x74\160\137\x74\x6f\153\x65\x6e"));
    $jt = '';
    $d1 = FALSE;
    $d1 = apply_filters("\x69\163\x5f\x6c\157\147\x69\156\137\157\162\137\163\x6f\143\x69\x61\154\137\146\157\162\x6d", $d1);
    $KB = !$d1 ? "\155\x6f\x46\151\x65\x6c\x64\163" : "\x6c\x6f\147\151\x6e\117\x72\123\x6f\x63\x69\x61\154\x46\157\162\x6d";
    foreach ($_POST as $Zm => $zs) {
        $jt .= !in_array($Zm, $ZA[$KB]) ? get_hidden_fields($Zm, $zs) : '';
        fV:
    }
    zc:
    return $jt;
}
function get_hidden_fields($Zm, $zs)
{
    if (!($Zm == "\x77\157\162\x64\x66\145\156\143\x65\137\x75\x73\x65\162\x44\x61\x74")) {
        goto w9;
    }
    return;
    w9:
    $At = '';
    if (is_array($zs)) {
        goto Cq;
    }
    $At .= "\x3c\x69\156\x70\x75\x74\40\164\x79\x70\x65\x3d\42\150\x69\x64\x64\145\156\42\40\156\141\155\x65\x3d\42" . $Zm . "\42\40\166\141\x6c\165\145\x3d\42" . $zs . "\42\40\57\76";
    goto PS;
    Cq:
    foreach ($zs as $Bo => $vv) {
        $At .= get_hidden_fields($Zm . "\133" . $Bo . "\x5d", $vv);
        Wx:
    }
    pY:
    PS:
    return $At;
}
function miniorange_site_otp_validation_form($wB, $CG, $J9, $SF, $rI, $Wj)
{
    if (headers_sent()) {
        goto VL;
    }
    header("\x43\x6f\156\164\x65\156\x74\x2d\x54\x79\x70\x65\72\40\x74\145\170\164\x2f\150\164\x6d\154\73\40\143\x68\141\162\x73\x65\164\75\165\x74\x66\55\70");
    VL:
    $Ur = ErrorPopup::instance();
    $a_ = DefaultPopup::instance();
    $aU = MoUtility::isBlank($CG) && MoUtility::isBlank($J9) ? apply_filters("\x6d\157\137\x74\x65\155\160\x6c\x61\164\x65\x5f\142\x75\151\x6c\x64", '', $Ur->getTemplateKey(), $SF, $rI, $Wj) : apply_filters("\x6d\x6f\137\x74\x65\155\x70\x6c\141\164\x65\137\142\165\x69\154\x64", '', $a_->getTemplateKey(), $SF, $rI, $Wj);
    echo $aU;
    die;
}
function miniorange_verification_user_choice($wB, $CG, $J9, $SF, $rI)
{
    if (headers_sent()) {
        goto wZ;
    }
    header("\x43\x6f\x6e\x74\x65\156\x74\x2d\124\171\x70\x65\72\x20\x74\145\170\164\57\150\x74\155\154\x3b\x20\143\150\x61\162\x73\x65\164\75\165\164\x66\55\x38");
    wZ:
    $K3 = UserChoicePopup::instance();
    $Xt = apply_filters("\x6d\x6f\x5f\x74\145\155\160\154\x61\x74\x65\x5f\142\165\x69\154\144", '', $K3->getTemplateKey(), $SF, $rI, TRUE);
    echo $Xt;
    die;
}
function mo_external_phone_validation_form($bY, $CG, $SF, $form, $N9)
{
    if (headers_sent()) {
        goto x3;
    }
    header("\x43\157\x6e\x74\145\156\x74\55\124\x79\x70\145\x3a\40\x74\145\x78\x74\57\150\164\x6d\154\73\x20\143\x68\141\x72\163\145\164\x3d\165\164\146\x2d\70");
    x3:
    $Jf = ExternalPopup::instance();
    $Xt = apply_filters("\155\157\x5f\164\145\x6d\x70\154\141\x74\x65\x5f\x62\x75\151\x6c\x64", '', $Jf->getTemplateKey(), $SF, NULL, FALSE);
    echo $Xt;
    die;
}
function get_otp_verification_form_dropdown()
{
    $Wx = 0;
    $t8 = FormList::instance();
    $qZ = TabDetails::instance();
    $QL = $_SERVER["\122\x45\121\x55\105\123\x54\137\x55\x52\x49"];
    echo "\15\12\x20\x20\x20\x20\x20\40\40\40\x3c\x64\x69\166\x20\143\x6c\x61\x73\163\x3d\42\x6d\x6f\x64\162\157\160\144\157\167\156\x22\x20\151\144\x3d\42\x6d\157\144\x72\157\x70\x64\157\x77\156\x22\x3e\15\12\40\x20\x20\x20\x20\x20\40\40\40\40\x20\x20\x3c\x73\160\x61\156\40\143\154\x61\x73\163\x3d\42\x64\141\163\x68\151\143\157\x6e\163\40\x64\x61\163\x68\x69\x63\157\x6e\x73\55\163\145\x61\162\x63\150\x22\x3e\74\57\163\x70\x61\156\76\xd\xa\x20\40\40\40\40\x20\x20\40\40\40\40\40\x20\40\x20\40\x3c\x69\156\160\165\164\x20\164\171\x70\145\75\42\164\145\x78\164\x22\x20\151\x64\75\x22\163\145\141\x72\x63\x68\x46\157\162\155\x22\x20\x63\154\141\163\163\x3d\x22\x64\162\157\160\x62\x74\x6e\42\x20\x70\154\x61\x63\145\x68\x6f\x6c\x64\145\x72\x3d\x22" . mo_("\123\145\x61\x72\x63\x68\40\x61\156\x64\x20\x73\145\x6c\145\143\164\40\x79\157\x75\162\40\x46\157\x72\x6d\x2e") . "\x22\x20\x2f\76\x9\11\x9\11\xd\xa\x20\40\x20\40\40\x20\x20\x20\40\x20\x20\40\x3c\x64\151\166\40\143\154\x61\163\163\x3d\x22\x6d\x6f\x64\162\x6f\x70\144\x6f\x77\x6e\x2d\143\157\x6e\x74\145\x6e\164\x22\40\x69\144\x3d\x22\146\157\162\x6d\114\x69\163\x74\x22\x3e";
    foreach ($t8->getList() as $Zm => $form) {
        $Wx++;
        $S0 = get_mo_class($form);
        $S0 = $form->isFormEnabled() ? "\x63\x6f\x6e\x66\151\147\x75\x72\x65\x64\137\x66\157\x72\155\x73\x23" . $S0 : $S0 . "\43" . $S0;
        $JX = add_query_arg(array("\x70\141\147\x65" => $qZ->_tabDetails[Tabs::FORMS]->_menuSlug, "\x66\x6f\162\155" => $S0), $QL);
        if ($form->isAddOnForm()) {
            goto OE;
        }
        echo "\74\x64\151\x76\40\143\154\x61\x73\163\x3d\x22\163\145\x61\162\x63\x68\137\x62\157\x78\x22\76";
        echo "\74\x61\40\143\154\141\163\x73\75\42\155\x6f\x5f\x73\x65\x61\162\x63\x68\42";
        echo "\40\150\x72\145\146\x3d\42" . $JX . "\x22\40";
        echo "\40\x64\141\x74\141\x2d\166\x61\x6c\x75\145\x3d\42" . $form->getFormName() . "\x22\40\144\x61\x74\x61\55\x66\x6f\x72\155\75\x22" . $S0 . "\42\76";
        echo "\x20\74\163\160\x61\156\40\143\154\141\163\x73\75\42";
        echo $form->isFormEnabled() ? "\x65\156\141\x62\154\145\144\42\x3e" : "\42\x3e";
        if (!(strrpos($S0, "\131\157\165\x72\x4f\x77\156\x46\x6f\162\155") == 0)) {
            goto cc;
        }
        echo $Wx . "\x2e\x26\156\x62\163\160";
        cc:
        echo $form->isFormEnabled() ? "\50\x20\x45\116\101\x42\x4c\105\104\x20\51\x20" : '';
        echo $form->getFormName() . "\x3c\x2f\163\160\141\x6e\x3e\x3c\57\141\x3e\74\57\144\x69\166\x3e";
        OE:
        gP:
    }
    S2:
    echo "\x3c\57\x64\151\166\76\xd\12\40\40\x20\40\x20\x20\40\40\74\x2f\x64\151\x76\x3e";
}
function get_country_code_dropdown()
{
    echo "\74\x73\x65\154\x65\143\164\x20\156\141\x6d\145\x3d\x22\144\145\146\x61\x75\x6c\x74\137\143\x6f\x75\x6e\x74\162\x79\137\x63\x6f\x64\145\42\x20\x69\144\x3d\42\x6d\157\x5f\143\x6f\165\x6e\164\162\171\x5f\x63\x6f\x64\145\x22\x3e";
    echo "\74\157\x70\x74\151\157\156\40\x76\x61\154\x75\x65\75\x22\42\x20\144\151\163\141\142\x6c\x65\x64\x20\163\145\x6c\145\x63\164\x65\x64\x3d\42\163\145\154\x65\143\164\145\x64\42\76\xd\12\x20\x20\x20\x20\40\40\40\x20\x20\x20\x20\x20\x2d\x2d\x2d\x2d\x2d\x2d\55\x2d\55\x20" . mo_("\123\145\154\145\143\164\x20\171\157\165\x72\40\x43\x6f\x75\x6e\x74\x72\x79") . "\x20\x2d\55\x2d\55\55\55\55\15\12\x20\x20\40\40\40\x20\40\40\x20\40\x3c\57\x6f\160\164\151\157\x6e\x3e";
    foreach (CountryList::getCountryCodeList() as $Zm => $L7) {
        echo "\74\x6f\x70\164\x69\x6f\156\40\x64\141\164\x61\55\x63\157\x75\x6e\164\x72\171\143\157\144\x65\x3d\42" . $L7["\143\157\x75\x6e\x74\162\171\103\157\144\x65"] . "\42\40\166\141\x6c\x75\x65\75\42" . $Zm . "\42";
        echo CountryList::isCountrySelected($L7["\x63\x6f\165\156\164\162\x79\103\x6f\x64\145"], $L7["\x61\154\x70\150\x61\x63\x6f\144\x65"]) ? "\163\145\x6c\145\x63\164\x65\x64" : '';
        echo "\76" . $L7["\x6e\x61\x6d\145"] . "\74\57\x6f\160\x74\151\157\x6e\76";
        G3:
    }
    bp:
    echo "\74\57\x73\145\x6c\145\143\164\x3e";
}
function get_country_code_multiple_dropdown()
{
    echo "\x3c\x73\145\x6c\145\143\x74\40\155\165\x6c\164\151\x70\154\x65\40\163\151\x7a\145\x3d\x22\65\42\x20\x6e\x61\x6d\145\x3d\42\141\154\x6c\x6f\x77\137\143\157\165\156\164\162\x69\145\x73\x5b\x5d\x22\40\x69\x64\x3d\x22\x6d\x6f\137\x63\x6f\165\156\x74\x72\171\x5f\x63\x6f\x64\x65\42\76";
    echo "\x3c\x6f\160\164\151\157\x6e\x20\x76\141\154\x75\145\x3d\x22\42\40\144\x69\163\x61\x62\x6c\x65\x64\x20\x73\145\x6c\x65\143\x74\145\144\x3d\42\163\145\154\x65\143\164\x65\144\x22\76\15\xa\x20\40\x20\x20\40\40\x20\x20\x20\x20\x20\40\55\x2d\55\x2d\55\x2d\x2d\x2d\x2d\40" . mo_("\x53\145\x6c\145\143\164\x20\x79\157\x75\162\40\103\157\x75\156\164\x72\151\x65\163") . "\x20\55\x2d\x2d\x2d\55\55\x2d\xd\12\40\x20\x20\40\x20\40\40\x20\x20\x20\x3c\x2f\x6f\x70\164\x69\x6f\x6e\76";
    echo "\x3c\x2f\163\145\154\145\143\x74\76";
}
function show_configured_form_details($XJ, $GZ, $rp)
{
    $t8 = FormList::instance();
    foreach ($t8->getList() as $form) {
        if (!($form->isFormEnabled() && !$form->isAddOnForm())) {
            goto qu;
        }
        $AZ = get_class($form);
        $S0 = substr($AZ, strrpos($AZ, "\x5c") + 1);
        include $XJ . "\146\x6f\x72\155\x73\57" . $S0 . "\56\160\150\160";
        echo "\74\142\x72\x2f\76";
        qu:
        o4:
    }
    X0:
}
function get_wc_payment_dropdown($GZ, $gu)
{
    if (is_plugin_active("\x77\157\157\143\x6f\x6d\x6d\145\x72\x63\x65\x2f\x77\x6f\157\x63\x6f\155\x6d\x65\x72\x63\x65\56\160\x68\x70")) {
        goto Pa;
    }
    echo mo_("\x5b\40\x50\x6c\x65\x61\x73\x65\40\141\x63\x74\x69\x76\x61\x74\145\x20\x74\150\x65\x20\127\x6f\x6f\103\157\x6d\x6d\x65\162\143\145\x20\120\x6c\165\x67\x69\156\x20\x5d");
    return;
    Pa:
    $gy = WC()->payment_gateways->payment_gateways();
    echo "\74\163\145\x6c\x65\143\164\x20\155\165\154\164\x69\x70\x6c\x65\x20\x73\151\172\145\75\x22\65\x22\x20\156\141\x6d\145\x3d\x22\x77\x63\137\160\141\171\x6d\x65\x6e\x74\x5b\135\42\40\x69\x64\x3d\42\167\143\137\x70\141\171\x6d\145\x6e\x74\42\76";
    echo "\x3c\x6f\x70\164\151\157\x6e\x20\166\141\154\165\145\75\42\x22\x20\144\151\163\x61\x62\x6c\x65\x64\x3e" . mo_("\123\145\x6c\145\x63\x74\40\x79\157\165\162\40\120\x61\x79\x6d\x65\x6e\164\40\115\145\164\150\157\x64\163") . "\74\x2f\x6f\x70\x74\x69\157\156\x3e";
    foreach ($gy as $f4) {
        echo "\x3c\157\x70\x74\x69\x6f\x6e\x20";
        if ($gu && array_key_exists($f4->id, $gu)) {
            goto gt;
        }
        if (!$gu) {
            goto qH;
        }
        goto zK;
        gt:
        echo "\163\145\x6c\x65\x63\x74\x65\x64";
        goto zK;
        qH:
        echo "\x73\x65\x6c\x65\143\x74\x65\x64";
        zK:
        echo "\40\166\x61\154\165\x65\75\x22" . esc_attr($f4->id) . "\42\76" . $f4->title . "\74\x2f\157\x70\x74\151\x6f\x6e\76";
        pe:
    }
    px:
    echo "\74\x2f\x73\145\154\145\143\164\x3e";
}
function get_multiple_form_select($rE, $cL, $BN, $GZ, $Zm, $sb, $NJ)
{
    $CD = "\74\x64\151\166\40\x69\144\75\x27\162\x6f\167\x7b\106\x4f\122\x4d\175\173\113\105\x59\x7d\x5f\173\x49\116\104\105\x58\x7d\x27\x3e\15\12\40\40\x20\40\40\x20\x20\40\x20\x20\x20\40\40\40\40\40\40\x20\x20\x20\x20\40\x20\40\x20\40\40\40\45\x73\x20\x3a\40\xd\xa\x20\x20\x20\x20\x20\x20\40\40\40\40\40\x20\40\x20\x20\x20\x20\x20\40\40\40\x20\40\40\40\x20\x20\40\74\151\156\160\165\164\x20\x9\x69\144\75\x27\x7b\x46\x4f\122\x4d\x7d\x5f\146\157\x72\x6d\137\x7b\x4b\105\x59\x7d\x5f\x7b\x49\116\104\105\130\175\47\40\xd\12\40\x20\x20\40\x20\40\x20\40\40\40\40\x20\40\40\x20\40\40\40\40\x20\40\40\40\x20\40\40\40\40\x20\40\x20\40\40\x20\x20\40\143\154\x61\x73\x73\x3d\47\146\151\145\154\x64\137\x64\x61\164\x61\x27\x20\xd\12\x20\x20\x20\x20\x20\40\x20\x20\40\40\40\x20\x20\x20\x20\x20\x20\40\x20\40\40\x20\40\x20\40\x20\40\40\x20\40\40\40\40\x20\40\x20\156\141\155\145\x3d\47\173\x46\117\x52\115\x7d\137\146\157\x72\155\133\x66\x6f\x72\x6d\x5d\133\135\47\40\xd\xa\40\x20\40\40\x20\40\x20\x20\40\40\x20\40\x20\40\40\x20\x20\40\40\40\x20\40\x20\x20\40\40\40\40\40\40\40\40\x20\40\40\x20\x74\171\160\145\75\x27\x74\x65\170\164\47\x20\xd\12\x20\40\40\40\x20\40\x20\x20\40\40\40\x20\40\40\x20\40\40\x20\x20\x20\40\x20\40\x20\x20\40\x20\x20\x20\x20\40\x20\40\x20\x20\x20\166\x61\154\165\145\x3d\47\173\106\x4f\x52\x4d\x5f\x49\104\137\x56\x41\x4c\x7d\47\76\xd\xa\x20\x20\40\x20\40\40\x20\40\x20\40\x20\40\40\x20\40\x20\x20\40\40\40\40\40\x20\x20\x20\x20\40\x20\40\40\40\40\x20\40\40\x20\x7b\105\x4d\x41\x49\x4c\137\x41\116\104\x5f\x50\110\x4f\116\105\x5f\106\x49\x45\114\x44\x7d\xd\xa\x20\x20\40\40\x20\40\x20\x20\x20\x20\40\x20\x20\40\40\x20\40\40\x20\40\40\x20\x20\40\x20\x20\40\x20\40\40\40\40\x20\40\40\x20\x7b\x56\x45\122\x49\106\x59\137\106\x49\x45\114\104\x7d\15\12\x20\40\40\x20\40\x20\40\40\40\40\40\40\x20\40\40\40\x20\x20\x20\40\40\x20\x20\x20\x3c\x2f\x64\151\x76\x3e";
    $o2 = "\40\x3c\163\x70\141\x6e\x20\x7b\x48\x49\104\x44\105\116\61\175\76\15\12\40\40\40\40\40\40\x20\x20\x20\x20\x20\40\x20\40\x20\40\40\x20\x20\40\x20\x20\40\x20\40\40\40\40\40\40\40\x20\x20\x20\40\x20\x25\x73\72\x20\15\xa\40\x20\x20\x20\40\x20\x20\40\x20\40\x20\40\40\40\40\40\x20\x20\40\40\40\40\40\x20\x20\40\x20\40\x20\40\40\x20\40\40\x20\40\74\x69\156\x70\x75\x74\x20\x20\151\x64\75\47\173\106\x4f\122\x4d\x7d\137\146\x6f\x72\155\137\x65\x6d\141\x69\154\137\173\x4b\x45\131\x7d\x5f\x7b\x49\x4e\x44\105\130\x7d\47\x20\xd\12\40\40\x20\x20\x20\x20\40\x20\x20\40\40\40\x20\x20\x20\40\40\x20\x20\40\40\x20\40\x20\40\40\40\40\x20\x20\40\x20\x20\x20\x20\40\40\x20\40\40\40\40\40\40\143\154\141\x73\163\x3d\47\x66\x69\145\154\144\x5f\144\141\x74\x61\47\x20\xd\12\x20\x20\40\x20\x20\40\40\x20\x20\x20\x20\x20\40\x20\x20\x20\x20\x20\40\x20\40\40\x20\40\x20\40\40\x20\40\40\x20\x20\x20\x20\40\x20\40\x20\40\x20\40\x20\x20\40\156\x61\155\x65\x3d\x27\173\x46\117\122\115\x7d\137\x66\157\162\155\133\x65\x6d\141\x69\x6c\153\145\171\x5d\133\135\47\x20\15\12\40\x20\x20\40\x20\40\40\x20\40\x20\40\x20\x20\x20\x20\40\40\x20\40\x20\40\40\x20\x20\x20\x20\40\x20\x20\x20\x20\x20\x20\x20\40\x20\40\40\40\x20\40\x20\x20\x20\x74\171\x70\145\75\47\x74\145\170\164\x27\x20\xd\12\40\40\x20\40\40\40\40\40\x20\40\x20\40\40\40\x20\x20\40\40\x20\x20\x20\x20\40\x20\40\40\x20\x20\40\40\x20\40\x20\40\40\40\x20\40\x20\x20\40\40\x20\40\x76\x61\x6c\165\145\x3d\x27\x7b\x45\x4d\101\x49\x4c\x5f\113\x45\131\x5f\x56\101\114\x7d\47\x3e\xd\xa\x20\40\x20\40\x20\40\x20\x20\40\x20\40\40\40\40\x20\x20\x20\40\40\40\x20\x20\x20\x20\x20\x20\x20\x20\40\40\x20\x20\74\x2f\x73\160\141\156\76\xd\12\40\x20\x20\40\x20\40\x20\x20\40\40\40\x20\40\40\40\x20\40\40\x20\40\40\x20\x20\x20\40\40\40\x20\40\40\x20\x20\74\163\160\x61\x6e\x20\173\110\x49\104\x44\x45\116\x32\x7d\76\xd\12\40\40\x20\x20\40\40\x20\40\40\x20\x20\40\x20\x20\40\x20\x20\40\x20\40\x20\40\x20\x20\40\40\x20\x20\40\40\40\x20\x20\40\x20\40\x25\x73\x3a\40\xd\xa\40\x20\40\40\x20\40\40\40\x20\x20\x20\x20\40\40\x20\40\x20\x20\x20\40\x20\x20\x20\40\x20\x20\40\x20\x20\x20\40\40\40\x20\x20\40\74\x69\x6e\160\x75\x74\40\x20\x69\144\x3d\47\x7b\x46\117\122\115\x7d\x5f\x66\157\162\x6d\137\x70\x68\x6f\156\x65\x5f\173\x4b\105\131\x7d\137\173\x49\116\x44\x45\130\x7d\x27\40\xd\12\40\40\40\x20\x20\x20\x20\40\x20\40\40\x20\40\40\40\40\x20\x20\x20\x20\x20\40\x20\x20\40\x20\x20\40\40\x20\40\x20\40\x20\x20\x20\40\40\x20\x20\40\40\x20\x20\x63\x6c\x61\163\x73\75\x27\x66\x69\145\154\x64\137\x64\x61\x74\141\x27\x20\x20\15\12\x20\x20\x20\40\40\x20\x20\x20\40\x20\x20\x20\x20\40\x20\x20\40\x20\x20\x20\40\40\40\x20\x20\x20\x20\40\x20\x20\x20\x20\x20\x20\x20\40\x20\40\x20\x20\40\x20\40\40\x6e\x61\x6d\x65\x3d\47\x7b\106\117\122\x4d\175\x5f\x66\157\x72\155\x5b\160\150\157\x6e\145\x6b\x65\x79\135\x5b\135\x27\x20\15\12\40\x20\40\40\40\x20\x20\x20\40\x20\40\x20\40\40\x20\40\40\x20\40\x20\x20\40\40\40\40\x20\x20\x20\40\x20\40\40\40\x20\40\40\40\40\40\40\x20\x20\x20\x20\x74\171\x70\x65\x3d\47\x74\x65\170\x74\x27\x20\x76\x61\154\x75\x65\x3d\x27\x7b\120\x48\117\116\105\x5f\113\105\x59\x5f\126\x41\x4c\175\x27\76\15\12\x20\40\x20\40\x20\40\x20\x20\x20\40\x20\40\40\40\40\40\40\40\x20\40\x20\x20\x20\40\40\40\40\x20\x20\x20\40\x20\74\x2f\x73\160\141\156\x3e";
    $DI = "\x3c\163\x70\141\x6e\x3e\15\12\40\x20\40\x20\x20\40\x20\x20\x20\40\x20\40\40\x20\40\40\40\x20\x20\x20\x20\x20\40\x20\x20\x20\40\x20\x25\x73\x3a\40\15\12\x20\x20\x20\x20\40\x20\x20\x20\x20\40\40\40\x20\40\x20\40\x20\x20\40\x20\40\40\x20\40\x20\40\x20\x20\x3c\x69\x6e\x70\165\x74\40\11\143\x6c\141\x73\163\75\47\x66\151\x65\x6c\144\137\144\x61\x74\x61\47\40\xd\xa\x20\x20\x20\x20\x20\40\x20\x20\x20\x20\x20\x20\40\40\40\x20\40\40\40\x20\40\x20\x20\40\x20\x20\x20\40\40\40\x20\x20\40\x20\40\40\x69\x64\x3d\x27\x7b\106\x4f\122\115\175\137\x66\x6f\162\155\x5f\166\x65\x72\151\x66\171\x5f\173\113\x45\131\x7d\137\x7b\111\116\x44\x45\x58\x7d\47\x20\xd\xa\x20\40\x20\40\x20\x20\x20\x20\x20\40\40\x20\40\x20\x20\40\x20\x20\40\x20\x20\x20\40\x20\x20\40\x20\x20\40\40\40\x20\40\x20\x20\40\x6e\x61\155\x65\75\47\x7b\106\117\x52\x4d\x7d\x5f\x66\157\162\x6d\x5b\x76\x65\162\x69\x66\171\113\145\171\135\x5b\x5d\x27\40\xd\12\40\40\x20\x20\x20\40\x20\x20\x20\40\40\40\40\x20\40\x20\x20\x20\x20\x20\40\40\40\40\40\40\x20\40\x20\x20\x20\40\x20\40\x20\40\164\171\160\145\75\47\164\x65\x78\x74\x27\40\166\141\154\x75\145\x3d\x27\173\126\105\x52\111\x46\x59\x5f\113\x45\x59\x5f\126\x41\114\175\x27\x3e\xd\xa\40\40\40\x20\x20\x20\x20\40\40\40\x20\x20\x20\40\40\40\x20\x20\x20\40\x20\x20\40\x20\x3c\57\x73\160\141\156\x3e";
    $DI = $cL ? $DI : '';
    $o2 = $BN ? $o2 : '';
    $CD = MoUtility::replaceString(array("\x56\105\x52\111\x46\x59\x5f\x46\x49\x45\x4c\104" => $DI, "\x45\x4d\101\111\114\137\x41\x4e\x44\x5f\120\110\x4f\116\x45\137\x46\111\105\114\104" => $o2), $CD);
    $CD = sprintf($CD, mo_("\106\x6f\x72\155\40\111\104"), mo_("\x45\x6d\x61\x69\x6c\40\106\x69\x65\x6c\x64\x20{$NJ}"), mo_("\x50\x68\157\156\x65\40\106\151\145\154\144\x20{$NJ}"), mo_("\x56\145\162\x69\146\151\x63\x61\x74\151\157\x6e\x20\x46\151\x65\154\144\40{$NJ}"));
    $WI = 0;
    if (MoUtility::isBlank($rE)) {
        goto d5;
    }
    foreach ($rE as $EC => $Cy) {
        $we = array("\x4b\105\131" => $Zm, "\x49\116\x44\105\130" => $WI, "\x46\x4f\122\115" => $sb, "\x48\111\104\104\105\x4e\x31" => $Zm === 2 ? "\x68\x69\144\x64\x65\x6e" : '', "\110\111\104\104\x45\116\x32" => $Zm === 1 ? "\150\151\144\x64\x65\x6e" : '', "\x46\117\122\x4d\x5f\x49\x44\137\x56\101\x4c" => $BN ? $EC : $Cy, "\105\x4d\x41\111\x4c\x5f\113\105\131\137\126\x41\x4c" => $BN ? $Cy["\x65\x6d\x61\x69\x6c\137\x73\x68\157\167"] : '', "\120\110\x4f\x4e\105\x5f\x4b\x45\x59\x5f\126\x41\x4c" => $BN ? $Cy["\160\x68\157\156\x65\x5f\163\150\x6f\167"] : '', "\126\105\x52\111\106\x59\137\x4b\x45\x59\x5f\126\101\x4c" => $cL ? $Cy["\166\x65\x72\151\146\171\x5f\x73\x68\x6f\167"] : '');
        echo MoUtility::replaceString($we, $CD);
        $WI++;
        VF:
    }
    NX:
    goto xY;
    d5:
    $we = array("\x4b\x45\x59" => $Zm, "\x49\x4e\104\x45\x58" => 0, "\x46\117\122\115" => $sb, "\x48\x49\104\x44\105\x4e\61" => $Zm === 2 ? "\x68\x69\144\x64\145\156" : '', "\110\x49\104\x44\x45\116\62" => $Zm === 1 ? "\150\151\144\144\x65\x6e" : '', "\106\117\x52\x4d\x5f\x49\x44\137\126\x41\114" => '', "\105\115\x41\111\x4c\137\x4b\x45\x59\137\126\101\114" => '', "\x50\x48\x4f\116\105\137\113\105\x59\137\x56\x41\114" => '', "\126\105\122\111\106\x59\x5f\113\x45\x59\x5f\126\x41\114" => '');
    echo MoUtility::replaceString($we, $CD);
    xY:
    $fM["\143\157\165\x6e\x74\145\x72"] = $WI;
    return $fM;
}
function multiple_from_select_script_generator($cL, $BN, $sb, $NJ, $fr)
{
    $CD = "\x3c\x64\151\x76\40\151\x64\x3d\47\x72\x6f\x77\x7b\x46\117\122\115\175\x7b\x4b\x45\131\x7d\x5f\173\111\x4e\104\x45\x58\x7d\47\76\xd\12\40\x20\40\40\40\40\x20\x20\x20\40\x20\x20\x20\x20\x20\40\40\40\40\x20\40\40\40\x20\x20\40\40\x20\45\x73\40\x3a\40\xd\xa\40\x20\x20\x20\x20\40\40\x20\40\x20\40\40\x20\40\x20\x20\x20\40\40\x20\x20\x20\40\40\x20\40\x20\40\74\151\x6e\x70\165\164\x20\40\151\144\x3d\x27\x7b\x46\117\x52\115\175\x5f\146\x6f\162\x6d\x5f\x7b\x4b\x45\131\x7d\x5f\x7b\111\116\104\105\x58\175\x27\x20\xd\xa\x20\40\40\40\40\x20\x20\40\40\x20\x20\x20\40\40\40\x20\x20\x20\40\x20\x20\40\x20\40\x20\40\40\40\40\x20\40\x20\40\40\40\x20\x63\x6c\x61\163\x73\75\x27\146\x69\x65\154\x64\137\144\x61\164\x61\47\40\15\12\40\x20\40\40\x20\x20\x20\40\x20\40\40\x20\x20\40\40\x20\x20\40\40\40\40\40\40\40\40\x20\40\40\x20\x20\x20\x20\x20\40\x20\x20\156\141\155\x65\x3d\47\x7b\106\117\x52\115\175\x5f\146\x6f\x72\155\133\x66\157\x72\x6d\135\x5b\135\47\40\15\xa\40\40\x20\40\40\40\x20\40\x20\x20\40\40\40\40\x20\x20\40\40\40\40\40\x20\40\x20\40\40\x20\40\x20\x20\x20\40\x20\40\x20\40\164\x79\160\x65\75\47\164\x65\x78\164\x27\x20\xd\12\40\40\40\40\x20\40\x20\40\40\x20\40\x20\x20\x20\40\40\x20\x20\40\40\40\x20\40\40\x20\40\40\x20\40\40\x20\40\40\x20\40\40\x76\141\x6c\x75\x65\x3d\47\x27\x3e\40\xd\12\40\40\x20\40\40\40\x20\x20\x20\40\x20\40\x20\x20\40\40\x20\40\40\40\x20\40\x20\40\x20\40\40\40\x20\x20\x20\40\40\40\40\x20\173\105\x4d\x41\111\114\x5f\101\116\104\137\120\x48\117\x4e\x45\137\106\111\105\x4c\x44\x7d\173\x56\x45\x52\111\106\131\x5f\x46\x49\x45\x4c\x44\x7d\40\xd\xa\40\40\40\x20\40\40\x20\40\40\x20\x20\x20\40\x20\x20\x20\x20\40\40\x20\x20\x20\40\x20\x3c\57\x64\x69\166\x3e";
    $DI = "\74\x73\x70\141\156\x3e\40\x25\x73\72\40\15\xa\x20\40\40\40\40\x20\40\40\40\x20\x20\40\40\x20\40\x20\40\x20\40\40\x20\x20\40\40\x20\x20\x20\x20\x3c\x69\x6e\160\165\164\x20\x9\x63\154\141\163\x73\75\47\146\151\145\154\x64\x5f\x64\141\164\141\47\x20\xd\12\40\40\x20\x20\x20\40\x20\x20\40\40\40\x20\x20\40\40\40\40\40\x20\40\40\40\x20\40\x20\40\40\x20\40\40\x20\x20\40\40\x20\x20\x69\x64\75\x27\173\106\x4f\x52\115\x7d\x5f\146\x6f\162\x6d\x5f\166\145\x72\x69\146\x79\137\173\x4b\105\x59\x7d\137\x7b\111\x4e\104\105\130\x7d\x27\x20\15\12\x20\40\40\40\40\x20\40\40\x20\40\x20\x20\40\x20\40\x20\x20\x20\x20\x20\40\x20\x20\40\40\x20\x20\x20\40\x20\x20\40\x20\x20\40\40\156\141\x6d\x65\75\x27\x7b\106\x4f\122\x4d\175\x5f\x66\157\162\155\x5b\x76\x65\x72\151\146\171\x4b\145\x79\135\x5b\x5d\x27\40\xd\12\40\40\x20\40\x20\40\x20\40\40\40\40\x20\40\40\x20\x20\40\40\40\x20\x20\40\x20\40\40\40\40\x20\x20\x20\40\x20\x20\40\40\x20\164\x79\160\145\75\47\164\145\170\x74\x27\x20\166\x61\154\x75\145\x3d\47\x27\76\xd\xa\x20\x20\40\x20\x20\x20\40\x20\40\x20\40\x20\40\x20\x20\x20\x20\40\40\x20\40\x20\x20\40\74\57\x73\160\141\156\x3e";
    $o2 = "\x3c\163\x70\141\156\40\173\x48\x49\x44\x44\105\116\61\175\x3e\40\45\163\72\40\xd\xa\x20\x20\x20\x20\x20\x20\x20\x20\40\x20\x20\40\40\x20\40\x20\x20\x20\40\x20\x20\x20\x20\x20\x20\40\40\x20\x20\40\40\40\40\40\40\x20\x3c\x69\156\160\165\164\x20\x9\151\144\x3d\47\x7b\x46\x4f\x52\115\x7d\137\x66\x6f\162\155\137\145\155\141\151\154\x5f\173\113\x45\131\175\137\x7b\111\x4e\x44\x45\x58\175\x27\x20\xd\12\40\x20\x20\x20\x20\40\x20\x20\x20\40\x20\40\x20\x20\40\40\40\x20\40\40\x20\40\40\40\40\40\40\x20\40\40\40\x20\40\40\40\40\x20\40\40\40\40\x20\40\40\x63\x6c\141\x73\x73\75\x27\x66\x69\x65\x6c\144\137\144\141\164\141\x27\x20\15\12\40\40\x20\x20\x20\x20\x20\40\40\x20\x20\40\40\40\x20\x20\x20\x20\x20\40\40\40\40\x20\40\40\40\40\40\40\x20\x20\40\40\x20\x20\x20\x20\40\x20\40\40\x20\x20\x6e\x61\x6d\145\x3d\x27\173\x46\x4f\122\115\x7d\137\146\157\162\x6d\133\x65\155\x61\151\154\x6b\145\x79\x5d\133\135\47\x20\xd\xa\40\x20\x20\40\40\x20\x20\40\x20\40\40\40\40\40\40\x20\x20\x20\40\x20\40\x20\x20\40\40\x20\x20\40\40\40\40\x20\40\x20\40\x20\x20\x20\x20\40\x20\x20\40\x20\164\x79\x70\x65\x3d\x27\164\145\170\x74\47\x20\x76\x61\x6c\x75\145\75\x27\x27\76\xd\12\x20\40\x20\40\40\40\40\x20\x20\40\x20\x20\40\40\x20\40\x20\40\x20\40\x20\x20\40\x20\40\40\x20\x20\40\x20\x20\x20\74\x2f\x73\x70\141\x6e\76\xd\12\40\40\40\x20\x20\40\x20\x20\x20\x20\40\40\40\x20\x20\40\40\40\x20\x20\x20\x20\x20\40\x20\40\40\40\x20\x20\40\x20\74\163\160\141\x6e\40\173\x48\111\104\x44\105\x4e\x32\x7d\76\x20\45\163\72\x20\15\12\40\40\x20\x20\40\40\40\x20\x20\40\x20\x20\40\40\40\x20\x20\x20\40\x20\x20\x20\x20\40\40\40\40\40\x20\x20\40\40\40\40\40\x20\74\x69\x6e\160\x75\164\x20\11\x69\x64\75\x27\x7b\106\117\x52\115\175\x5f\x66\157\x72\155\x5f\160\150\x6f\x6e\x65\x5f\x7b\x4b\105\x59\175\137\x7b\x49\x4e\104\x45\130\x7d\47\40\xd\xa\x20\40\x20\x20\40\40\40\40\40\x20\40\40\x20\x20\x20\x20\40\40\x20\40\40\x20\40\40\x20\40\x20\40\40\40\40\x20\40\40\x20\x20\40\x20\40\40\x20\40\x20\x20\x63\x6c\141\163\163\x3d\x27\x66\x69\x65\x6c\144\137\144\x61\164\141\x27\x20\40\xd\xa\40\40\x20\40\40\x20\40\x20\40\40\40\40\x20\x20\x20\x20\x20\40\40\40\40\40\40\x20\40\40\40\x20\x20\x20\x20\40\40\x20\40\x20\40\40\x20\40\40\40\40\x20\x6e\141\x6d\145\x3d\x27\x7b\x46\x4f\122\x4d\175\137\146\x6f\x72\155\133\x70\150\x6f\x6e\145\x6b\145\x79\x5d\x5b\x5d\47\x20\15\12\40\40\x20\40\40\40\40\40\40\x20\40\40\40\x20\40\40\40\40\x20\40\x20\40\x20\40\x20\x20\x20\40\x20\40\40\x20\40\40\x20\x20\x20\x20\x20\x20\40\x20\40\x20\x74\x79\160\145\x3d\x27\164\145\170\164\47\40\xd\12\40\40\40\x20\x20\40\40\x20\40\40\x20\x20\x20\x20\x20\x20\40\40\x20\40\x20\40\40\40\40\x20\x20\40\40\x20\x20\40\x20\x20\40\40\x20\40\x20\40\40\40\x20\x20\166\x61\154\165\145\x3d\47\x27\x3e\15\xa\40\x20\40\40\40\40\40\40\40\x20\40\40\x20\x20\x20\x20\40\40\x20\40\40\40\40\40\x20\40\x20\40\40\x20\40\40\x3c\57\163\160\141\156\x3e";
    $DI = $cL ? $DI : '';
    $o2 = $BN ? $o2 : '';
    $CD = MoUtility::replaceString(array("\126\x45\122\111\106\x59\x5f\x46\111\105\x4c\104" => $DI, "\x45\115\101\x49\114\x5f\x41\x4e\x44\137\120\110\x4f\x4e\x45\137\x46\111\105\x4c\104" => $o2), $CD);
    $CD = sprintf($CD, mo_("\x46\157\x72\155\40\111\x44"), mo_("\105\155\x61\151\154\x20\106\x69\145\154\x64\40{$NJ}"), mo_("\x50\x68\157\x6e\x65\40\x46\x69\x65\x6c\x64\x20{$NJ}"), mo_("\x56\x65\x72\151\x66\151\143\x61\x74\x69\157\156\40\x46\x69\145\154\144\40{$NJ}"));
    $CD = trim(preg_replace("\x2f\134\x73\x5c\x73\x2b\57", "\x20", $CD));
    $W_ = "\40\x3c\163\x63\162\151\160\x74\x3e\15\12\40\40\x20\x20\40\40\40\x20\x20\40\x20\x20\x20\x20\x20\x20\x20\40\40\40\x20\40\x20\40\x20\40\x20\40\40\40\40\40\166\141\x72\x20\x7b\106\117\x52\x4d\175\137\143\x6f\x75\156\164\145\162\x31\x2c\x20\173\106\117\122\x4d\175\x5f\143\x6f\165\156\164\x65\162\x32\x2c\x20\x7b\x46\117\122\x4d\175\137\x63\x6f\165\156\x74\x65\162\63\x3b\xd\12\40\x20\40\40\x20\40\x20\40\40\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\40\x20\x20\x20\x20\x20\40\x20\x20\40\40\40\152\121\x75\x65\x72\171\x28\144\157\143\x75\x6d\145\x6e\164\51\56\x72\x65\141\x64\171\x28\x66\165\156\143\x74\x69\x6f\x6e\50\x29\x7b\40\40\15\12\x20\40\40\x20\40\x20\x20\40\x20\x20\x20\x20\40\x20\x20\x20\40\40\x20\x20\40\x20\40\40\x20\40\x20\x20\x20\x20\40\x20\x20\x20\40\x20\x7b\x46\x4f\x52\115\175\137\x63\157\165\156\x74\145\162\x31\40\x3d\40" . $fr[0] . "\73\40\x7b\106\x4f\x52\115\x7d\x5f\x63\157\x75\x6e\164\145\x72\x32\40\75\x20" . $fr[1] . "\x3b\40\x7b\x46\117\122\115\x7d\x5f\143\x6f\165\x6e\x74\x65\162\x33\40\75\x20" . $fr[2] . "\x3b\40\15\xa\40\40\40\40\40\x20\x20\x20\40\x20\40\40\x20\x20\x20\x20\x20\40\x20\40\x20\40\40\40\40\x20\x20\x20\40\40\40\40\x7d\x29\x3b\15\12\40\40\40\40\x20\x20\40\x20\40\x20\x20\x20\x20\x20\x20\x20\40\x20\x20\40\40\40\40\x20\40\40\x20\x20\74\x2f\163\x63\162\x69\160\x74\76\xd\xa\x20\40\x20\x20\40\40\40\x20\x20\x20\x20\40\40\x20\40\x20\x20\x20\x20\40\40\40\x20\40\x20\x20\x20\x20\x3c\x73\x63\x72\151\160\x74\x3e\15\12\40\40\x20\x20\40\x20\x20\x20\40\40\x20\x20\x20\x20\x20\x20\x20\x20\40\x20\x20\40\x20\40\40\x20\40\x20\40\40\x20\x20\146\165\156\x63\164\x69\157\x6e\x20\141\144\x64\137\173\x46\x4f\x52\x4d\x7d\50\164\x2c\156\51\xd\12\x20\40\40\x20\x20\40\x20\x20\x20\40\x20\40\x20\x20\40\40\x20\40\x20\40\x20\40\x20\40\x20\x20\x20\x20\40\x20\40\x20\173\15\xa\40\40\40\40\40\40\40\x20\x20\x20\x20\x20\40\x20\40\x20\x20\x20\40\x20\40\x20\40\x20\40\40\40\x20\x20\40\x20\40\x20\40\x20\40\166\x61\x72\x20\143\x6f\x75\156\x74\x20\75\40\x74\150\x69\x73\133\47\x7b\x46\x4f\122\115\175\137\x63\x6f\165\x6e\164\x65\162\47\53\156\135\x3b\15\12\x20\x20\40\x20\x20\40\40\40\x20\40\40\40\x20\x20\x20\x20\40\40\x20\x20\x20\40\40\x20\40\40\x20\x20\x20\40\40\40\x20\x20\40\40\166\141\x72\x20\x68\x69\x64\144\x65\156\61\x3d\x27\x27\54\150\x69\x64\x64\145\156\x32\x3d\47\47\x2c\x62\157\164\x68\x3d\x27\47\x3b\15\12\x20\40\x20\40\x20\x20\40\40\40\40\40\x20\x20\x20\40\40\x20\40\40\40\x20\40\x20\40\x20\x20\x20\x20\x20\40\40\x20\40\40\x20\x20\x76\x61\x72\40\x68\164\155\154\x20\75\40\x22" . $CD . "\42\x3b\xd\xa\40\x20\x20\x20\40\x20\x20\x20\x20\40\x20\x20\40\x20\x20\40\x20\40\x20\x20\x20\x20\x20\x20\x20\x20\40\x20\40\x20\x20\x20\40\40\40\x20\151\146\50\156\x3d\x3d\75\61\x29\x20\150\151\x64\x64\x65\x6e\x32\40\x3d\x20\47\x68\x69\144\144\x65\156\47\73\xd\12\x20\x20\40\40\40\x20\40\x20\x20\x20\40\x20\x20\x20\x20\x20\40\x20\x20\40\40\40\40\x20\40\40\40\40\40\x20\x20\x20\x20\40\x20\40\x69\146\x28\x6e\75\75\x3d\62\x29\x20\150\151\x64\x64\x65\x6e\x31\x20\x3d\40\47\x68\151\144\x64\145\x6e\x27\x3b\xd\12\x20\40\x20\x20\40\x20\x20\x20\40\40\40\x20\x20\x20\x20\40\x20\x20\40\40\40\x20\x20\x20\x20\40\x20\x20\x20\x20\40\x20\40\x20\40\x20\x69\x66\50\x6e\75\x3d\75\x33\x29\40\x62\x6f\164\150\x20\75\x20\47\142\x6f\164\x68\x5f\47\x3b\15\xa\x20\40\40\x20\x20\40\x20\40\40\40\x20\40\x20\40\40\x20\40\40\40\40\x20\40\x20\40\x20\40\40\40\40\x20\40\40\40\x20\40\x20\x63\157\165\156\164\x2b\53\x3b\15\xa\x20\40\40\40\x20\40\x20\x20\40\x20\40\x20\40\x20\40\40\40\x20\40\x20\x20\40\x20\x20\40\40\40\40\40\40\x20\x20\x20\x20\40\x20\150\164\x6d\x6c\x20\75\40\150\x74\x6d\x6c\x2e\x72\x65\160\x6c\x61\x63\x65\50\47\x7b\x4b\105\131\x7d\47\54\x20\156\51\x2e\x72\145\160\154\141\143\145\x28\x27\173\111\x4e\x44\105\x58\x7d\x27\54\x63\157\165\x6e\x74\51\56\x72\145\x70\154\141\143\145\50\47\173\x48\111\104\104\105\x4e\x31\x7d\x27\54\150\x69\144\144\145\156\61\51\x2e\162\145\160\x6c\141\143\145\50\x27\173\110\x49\x44\x44\x45\116\x32\x7d\47\x2c\x68\x69\144\144\145\x6e\x32\51\73\xd\12\x20\x20\40\40\40\x20\x20\40\x20\x20\40\x20\x20\x20\40\40\40\x20\40\x20\x20\40\40\40\x20\40\x20\x20\x20\x20\x20\40\x20\40\x20\x20\x69\146\x28\x63\x6f\165\156\x74\x21\x3d\x3d\60\51\40\173\15\xa\40\x20\x20\x20\x20\x20\40\x20\40\x20\40\40\x20\40\40\40\x20\40\40\40\x20\40\x20\x20\x20\40\x20\40\40\40\40\40\40\40\40\40\40\40\40\x20\x24\x6d\157\50\150\164\x6d\x6c\51\x2e\x69\156\163\x65\x72\164\x41\146\x74\145\x72\x28\44\x6d\x6f\x28\47\x23\x72\x6f\167\x7b\x46\117\x52\x4d\x7d\47\53\x6e\x2b\47\x5f\47\53\x28\x63\x6f\165\x6e\164\x2d\61\x29\53\47\x27\51\x29\73\xd\xa\40\x20\x20\x20\40\40\x20\40\x20\40\x20\x20\40\40\40\x20\40\40\40\40\x20\x20\x20\x20\x20\40\x20\40\x20\40\40\x20\40\40\x20\40\175\xd\xa\40\40\x20\40\x20\x20\40\x20\40\40\40\40\40\40\40\x20\40\x20\x20\x20\x20\x20\40\x20\40\x20\x20\40\x20\x20\40\40\40\x20\40\x20\x74\x68\x69\x73\133\47\x7b\x46\117\x52\x4d\175\x5f\x63\x6f\x75\x6e\x74\x65\x72\x27\53\156\x5d\x3d\143\157\x75\x6e\164\73\xd\12\x20\40\x20\40\40\40\x20\40\40\40\40\x20\x20\40\40\40\x20\40\x20\40\40\40\x20\x20\x20\x20\40\40\40\x20\40\x20\175\15\12\40\40\x20\x20\x20\40\40\x20\40\x20\40\40\40\40\40\x20\x20\40\x20\40\x20\40\x20\x20\40\40\x20\x20\15\xa\40\x20\x20\40\40\x20\x20\x20\x20\40\40\x20\x20\40\40\x20\x20\40\40\40\40\x20\x20\40\40\x20\x20\x20\x20\x20\x20\40\x66\165\x6e\x63\x74\151\x6f\156\40\162\x65\155\157\x76\x65\137\173\x46\x4f\122\115\x7d\50\x6e\51\xd\xa\x20\x20\x20\40\40\40\x20\40\x20\40\40\x20\x20\40\40\x20\x20\40\40\40\x20\40\40\40\x20\x20\x20\x20\40\40\40\x20\x7b\xd\xa\x20\x20\40\40\x20\x20\x20\40\40\x20\40\x20\x20\40\40\40\40\x20\40\40\40\40\x20\x20\x20\x20\40\40\40\x20\40\x20\40\40\x20\x20\x76\x61\x72\x20\x63\157\165\x6e\164\x20\75\40\40\x20\115\x61\x74\150\x2e\155\x61\x78\x28\164\x68\151\163\133\x27\173\x46\117\122\x4d\x7d\137\143\157\x75\156\x74\145\x72\61\47\x5d\54\164\150\x69\x73\133\47\x7b\106\117\x52\x4d\175\137\x63\x6f\165\x6e\x74\145\x72\62\47\x5d\x2c\x74\x68\151\x73\x5b\47\173\106\117\122\x4d\175\137\x63\157\x75\156\164\x65\x72\x33\47\135\x29\x3b\xd\xa\x20\x20\x20\40\40\x20\x20\x20\x20\x20\40\40\40\x20\x20\x20\40\x20\x20\40\40\x20\x20\x20\x20\40\40\x20\40\x20\40\x20\40\40\x20\x20\151\x66\50\143\x6f\x75\x6e\x74\40\x21\x3d\75\x20\x30\x29\40\x7b\xd\xa\40\x20\x20\x20\40\40\40\40\40\x20\x20\40\x20\40\40\40\x20\x20\x20\x20\x20\x20\40\x20\x20\40\x20\40\40\40\40\x20\40\40\x20\40\40\40\40\40\x24\x6d\x6f\x28\x27\x23\x72\x6f\x77\x7b\106\117\122\x4d\175\61\x5f\x27\x20\x2b\40\x63\x6f\165\x6e\164\x29\56\x72\x65\x6d\157\x76\x65\50\x29\73\15\xa\40\40\x20\x20\x20\40\40\x20\x20\40\40\x20\40\40\40\40\40\x20\40\40\x20\40\x20\40\x20\40\x20\40\40\x20\x20\40\x20\x20\x20\40\x20\40\x20\x20\x24\x6d\157\50\47\x23\x72\157\167\x7b\106\117\122\115\x7d\x32\x5f\47\40\x2b\40\143\157\x75\156\164\x29\56\162\x65\x6d\x6f\166\145\x28\51\73\xd\xa\x20\40\40\x20\40\x20\40\40\x20\40\40\40\40\x20\x20\40\40\x20\x20\x20\40\40\x20\x20\40\x20\40\40\40\40\x20\40\40\40\x20\40\x20\40\40\40\44\155\157\50\47\x23\x72\x6f\x77\x7b\106\x4f\122\115\175\63\x5f\47\40\53\40\x63\x6f\165\156\x74\51\x2e\162\x65\x6d\x6f\x76\x65\50\x29\x3b\15\xa\40\x20\40\40\x20\40\x20\x20\x20\x20\x20\x20\40\40\40\40\x20\x20\x20\x20\40\40\40\40\x20\x20\x20\x20\x20\40\x20\40\x20\x20\x20\x20\40\x20\40\40\x63\157\165\x6e\164\x2d\55\73\xd\12\x20\40\x20\40\x20\x20\x20\40\x20\x20\x20\40\x20\40\x20\40\x20\x20\40\x20\x20\x20\40\x20\40\x20\40\40\40\40\40\x20\40\x20\40\40\40\40\40\40\164\150\x69\x73\133\47\173\106\117\x52\115\x7d\137\143\x6f\165\156\x74\145\162\x33\x27\135\75\164\x68\151\163\133\x27\173\x46\117\x52\x4d\175\137\143\157\x75\x6e\164\x65\x72\x31\x27\135\75\x74\150\x69\163\133\x27\x7b\x46\117\122\115\x7d\x5f\143\157\x75\x6e\x74\145\162\x32\x27\135\75\x63\157\x75\156\x74\x3b\xd\12\x20\40\40\x20\x20\x20\x20\40\40\x20\x20\40\40\40\40\40\x20\x20\x20\40\x20\x20\40\x20\40\x20\x20\x20\40\x20\40\40\40\40\40\x20\x7d\40\x20\x20\40\x20\40\40\xd\xa\x20\40\40\40\x20\x20\x20\40\40\x20\x20\x20\40\40\x20\40\40\40\40\40\x20\x20\40\40\x20\40\x20\40\x20\40\40\x20\175\xd\xa\x20\x20\40\x20\x20\x20\40\x20\40\40\40\40\x20\x20\40\40\x20\40\x20\x20\40\40\x20\40\x20\x20\40\40\74\x2f\163\143\162\x69\x70\164\x3e";
    $W_ = MoUtility::replaceString(array("\x46\117\x52\115" => $sb), $W_);
    echo $W_;
}
function show_addon_list()
{
    $tu = GatewayFunctions::instance();
    $tu->showAddOnList();
}