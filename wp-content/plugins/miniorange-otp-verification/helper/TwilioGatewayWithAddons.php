<?php


namespace OTP\Helper;

if (defined("\101\x42\x53\x50\101\x54\110")) {
    goto xC;
}
die;
xC:
use OTP\Addons\CustomMessage\MiniOrangeCustomMessage;
use OTP\Addons\PasswordResetwc\WooCommercePasswordReset;
use OTP\Addons\WpSMSNotification\WordPressSmsNotification;
use OTP\Addons\regwithphone\RegisterWithPhoneOnly;
use OTP\Addons\PasswordReset\UltimateMemberPasswordReset;
use OTP\Addons\UmSMSNotification\UltimateMemberSmsNotification;
use OTP\Addons\WcSMSNotification\WooCommerceSmsNotification;
use OTP\Addons\passwordresetwp\WordPressPasswordReset;
use OTP\Addons\CountryCode\SelectedCountryCode;
use OTP\Addons\APIVerification\APIAddon;
use OTP\Addons\ResendControl\MiniOrangeOTPControl;
use OTP\Addons\PasscodeOverCall\OTPOverCallAddon;
use OTP\Objects\BaseAddOnHandler;
use OTP\Objects\IGatewayFunctions;
use OTP\Traits\Instance;
class TwilioGatewayWithAddons extends CustomGateway implements IGatewayFunctions
{
    use Instance;
    protected $applicationName = "\x77\160\137\145\x6d\x61\151\154\x5f\166\145\162\151\x66\x69\x63\x61\164\x69\157\156\137\x69\x6e\164\162\141\x6e\145\164\x5f\164\167\x69\x6c\x69\157";
    public function registerAddOns()
    {
        $passwordresetwp = MOV_DIR.'addons/passwordresetwp';
        if(file_exists($passwordresetwp ))
        {
             WordPressPasswordReset::instance();

        }
        $lR = MOV_DIR . "\x61\144\x64\x6f\x6e\x73\x2f\143\x75\163\164\157\155\155\145\163\163\x61\x67\145";
        if (!file_exists($lR)) {
            goto BC;
        }
        MiniOrangeCustomMessage::instance();
        BC:
        $HY = MOV_DIR . "\141\144\x64\x6f\156\163\57\x70\x61\x73\163\x77\x6f\x72\x64\x72\x65\163\x65\164";
        if (!file_exists($HY)) {
            goto FL;
        }
        UltimateMemberPasswordReset::instance();
        FL:
        $Er = MOV_DIR . "\141\x64\x64\x6f\156\x73\x2f\x75\155\x73\x6d\163\x6e\x6f\x74\x69\146\x69\143\141\x74\151\157\156";
        if (!file_exists($Er)) {
            goto Xx;
        }
        UltimateMemberSmsNotification::instance();
        Xx:
        $Po = MOV_DIR . "\x61\x64\144\x6f\x6e\163\x2f\167\143\x73\155\163\156\157\x74\151\146\x69\x63\x61\x74\x69\157\156";
        if (!file_exists($Po)) {
            goto FJ;
        }
        WooCommerceSmsNotification::instance();
        FJ:
        $pe = MOV_DIR . "\141\144\x64\157\x6e\163\x2f\x70\141\163\x73\x77\x6f\x72\x64\x72\145\163\145\x74\x77\x63";
        if (!file_exists($pe)) {
            goto IA;
        }
        WooCommercePasswordReset::instance();
        IA:
        $qY = MOV_DIR . "\141\x64\x64\x6f\x6e\x73\x2f\162\x65\x67\167\151\x74\150\x70\x68\157\x6e\145";
        if (!file_exists($qY)) {
            goto Yt;
        }
        RegisterWithPhoneOnly::instance();
        Yt:
        $u1 = MOV_DIR . "\x61\144\x64\157\156\x73\x2f\167\160\163\155\x73\x6e\x6f\164\151\x66\151\143\x61\164\151\x6f\156";
        if (!file_exists($u1)) {
            goto v0;
        }
        WordPressSmsNotification::instance();
        v0:
        $u1 = MOV_DIR . "\x61\144\x64\x6f\156\x73\57\x77\160\163\155\163\156\157\x74\151\x66\x69\x63\x61\164\151\x6f\156";
        if (!file_exists($u1)) {
            goto Ox;
        }
        WordPressSmsNotification::instance();
        Ox:
        if (!file_exists(MOV_DIR . "\x61\144\x64\157\x6e\163\x2f\x61\160\151\x76\145\x72\151\146\151\143\x61\164\x69\x6f\x6e")) {
            goto bS;
        }
        APIAddon::instance();
        bS:
        if (!file_exists(MOV_DIR . "\141\x64\x64\157\156\x73\57\162\x65\163\145\x6e\144\x63\157\x6e\x74\x72\x6f\154")) {
            goto sR;
        }
        MiniOrangeOTPControl::instance();
        sR:
        if (!file_exists(MOV_DIR . "\141\x64\144\157\156\163\57\143\157\x75\156\164\162\x79\x63\x6f\144\x65")) {
            goto TJ;
        }
        SelectedCountryCode::instance();
        TJ:
        if (!file_exists(MOV_DIR . "\x61\144\144\157\156\x73\x2f\x70\141\x73\x73\143\x6f\144\x65\157\166\145\x72\143\141\x6c\154")) {
            goto d4;
        }
        OTPOverCallAddon::instance();
        d4:
    }
    public function showAddOnList()
    {
        $J6 = AddOnList::instance();
        $J6 = $J6->getList();
        foreach ($J6 as $Ge) {
            echo "\x3c\164\162\76\xd\xa\40\40\x20\40\40\x20\x20\40\40\40\x20\x20\x20\40\x20\40\x20\x20\40\40\74\x74\x64\40\x63\154\x61\163\163\x3d\42\141\144\144\x6f\x6e\55\164\x61\x62\x6c\x65\55\154\x69\x73\164\55\163\164\141\x74\165\x73\42\76\15\12\40\40\40\40\40\40\x20\40\x20\40\40\x20\40\40\x20\40\x20\x20\40\40\40\40\x20\x20" . $Ge->getAddOnName() . "\xd\12\40\x20\x20\x20\x20\40\40\40\x20\40\x20\40\x20\x20\x20\40\40\x20\40\40\74\57\x74\144\x3e\15\xa\x20\x20\x20\40\x20\x20\x20\x20\40\40\x20\40\40\x20\x20\40\x20\x20\40\x20\x3c\164\x64\x20\143\x6c\141\x73\163\75\42\x61\x64\144\157\156\55\164\x61\x62\x6c\145\x2d\x6c\x69\x73\164\55\156\x61\155\145\42\x3e\15\xa\x20\40\x20\x20\x20\x20\40\x20\x20\x20\40\x20\x20\x20\40\40\40\x20\40\x20\40\40\x20\40\x3c\x69\x3e\xd\xa\40\x20\40\40\40\x20\40\x20\40\40\40\40\x20\x20\x20\40\40\x20\40\40\40\40\x20\40\x20\40\x20\40" . $Ge->getAddOnDesc() . "\xd\12\40\x20\x20\x20\x20\40\40\40\x20\x20\x20\40\x20\40\x20\40\x20\40\40\x20\40\40\40\40\x3c\57\151\x3e\15\xa\x20\x20\40\40\40\40\40\x20\x20\40\x20\40\40\x20\x20\40\40\x20\40\x20\74\57\164\144\76\xd\12\40\x20\x20\40\40\40\40\x20\x20\40\40\40\40\40\40\40\40\x20\40\x20\74\x74\x64\x20\143\154\141\163\163\75\x22\141\x64\x64\157\156\55\x74\x61\142\154\x65\x2d\154\x69\163\x74\x2d\x61\143\164\151\x6f\x6e\163\42\76\15\12\40\40\x20\40\x20\40\40\40\x20\40\40\x20\40\40\x20\x20\40\40\x20\40\x20\x20\x20\40\74\141\40\x20\143\154\x61\163\163\x3d\42\x62\165\164\164\157\156\x2d\x70\162\151\x6d\141\162\171\x20\x62\x75\x74\x74\157\x6e\x20\x74\x69\x70\163\x22\40\xd\12\40\x20\40\40\40\40\x20\40\40\40\x20\x20\40\x20\x20\40\x20\x20\x20\40\x20\x20\40\40\40\40\x20\40\x68\x72\x65\146\75\x22" . $Ge->getSettingsUrl() . "\42\76\xd\xa\40\x20\40\x20\40\x20\40\x20\x20\x20\40\x20\x20\40\40\40\40\40\x20\40\40\40\40\40\40\x20\40\x20" . mo_("\x53\145\164\164\151\x6e\x67\x73") . "\xd\12\x20\x20\40\x20\40\x20\x20\40\x20\40\40\40\40\40\x20\40\40\x20\x20\40\40\40\40\40\74\57\141\76\15\xa\x20\40\x20\x20\40\x20\x20\40\x20\40\x20\40\x20\x20\40\40\40\40\40\40\74\57\x74\x64\76";
            echo "\xd\12\x20\40\40\40\40\40\x20\40\x20\40\40\x20\x20\40\x20\40\74\57\164\162\x3e";
            bu:
        }
        LZ:
    }
    public function getConfigPagePointers()
    {
        return array();
    }
}
