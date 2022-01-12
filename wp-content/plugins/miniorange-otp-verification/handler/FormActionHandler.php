<?php


namespace OTP\Handler;

if (defined("\x41\102\123\x50\101\x54\110")) {
    goto trJ;
}
die;
trJ:
use OTP\Helper\FormSessionVars;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoMessages;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseActionHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
class FormActionHandler extends BaseActionHandler
{
    use Instance;
    function __construct()
    {
        parent::__construct();
        $this->_nonce = "\155\157\137\146\157\x72\x6d\x5f\141\x63\x74\151\157\156\163";
        add_action("\151\156\x69\164", array($this, "\150\x61\156\144\x6c\145\106\157\x72\x6d\101\143\164\151\x6f\x6e\x73"), 1);
        add_action("\155\x6f\137\x76\141\154\x69\x64\x61\164\145\137\157\164\x70", array($this, "\166\141\154\151\144\141\x74\x65\117\124\120"), 1, 3);
        add_action("\x6d\x6f\x5f\x67\145\x6e\145\x72\x61\x74\145\137\x6f\x74\160", array($this, "\x63\150\141\154\x6c\x65\156\147\x65"), 2, 8);
        add_filter("\x6d\x6f\137\146\151\x6c\x74\145\162\137\x70\150\x6f\x6e\145\x5f\x62\145\146\157\162\x65\x5f\x61\160\x69\x5f\143\x61\x6c\154", array($this, "\146\x69\154\x74\x65\162\120\150\x6f\156\x65"), 1, 1);
    }
    public function challenge($wB, $CG, $errors, $J9 = null, $rI = "\145\155\141\151\154", $hs = '', $tA = null, $Wj = false)
    {
        $J9 = MoUtility::processPhoneNumber($J9);
        MoPHPSessions::addSessionVar("\x63\x75\x72\162\145\x6e\x74\x5f\165\162\x6c", MoUtility::currentPageUrl());
        MoPHPSessions::addSessionVar("\x75\163\x65\x72\x5f\145\x6d\x61\x69\154", $CG);
        MoPHPSessions::addSessionVar("\165\163\x65\x72\x5f\154\157\147\151\156", $wB);
        MoPHPSessions::addSessionVar("\x75\163\145\x72\x5f\160\x61\163\x73\167\157\x72\144", $hs);
        MoPHPSessions::addSessionVar("\160\x68\x6f\156\x65\137\x6e\x75\155\x62\145\x72\x5f\x6d\x6f", $J9);
        MoPHPSessions::addSessionVar("\x65\x78\x74\162\x61\137\x64\141\x74\141", $tA);
        $this->handleOTPAction($wB, $CG, $J9, $rI, $Wj, $tA);
    }
    private function handleResendOTP($rI, $Wj)
    {
        $CG = MoPHPSessions::getSessionVar("\165\x73\145\162\x5f\x65\155\x61\151\154");
        $wB = MoPHPSessions::getSessionVar("\x75\163\x65\x72\x5f\x6c\157\147\x69\156");
        $J9 = MoPHPSessions::getSessionVar("\x70\x68\x6f\156\145\137\156\165\155\142\x65\x72\x5f\155\x6f");
        $tA = MoPHPSessions::getSessionVar("\145\x78\x74\x72\x61\137\x64\x61\164\141");
        $this->handleOTPAction($wB, $CG, $J9, $rI, $Wj, $tA);
    }
    function handleOTPAction($wB, $CG, $J9, $rI, $Wj, $tA)
    {
        global $phoneLogic, $emailLogic;
        switch ($rI) {
            case VerificationType::PHONE:
                $phoneLogic->_handle_logic($wB, $CG, $J9, $rI, $Wj);
                goto Siu;
            case VerificationType::EMAIL:
                $emailLogic->_handle_logic($wB, $CG, $J9, $rI, $Wj);
                goto Siu;
            case VerificationType::BOTH:
                miniorange_verification_user_choice($wB, $CG, $J9, MoMessages::showMessage(MoMessages::CHOOSE_METHOD), $rI);
                goto Siu;
            case VerificationType::EXTERNAL:
                mo_external_phone_validation_form($tA["\143\x75\162\x6c"], $CG, $tA["\155\145\163\163\141\x67\145"], $tA["\146\157\162\x6d"], $tA["\144\x61\x74\x61"]);
                goto Siu;
        }
        Ymr:
        Siu:
    }
    function handleGoBackAction()
    {
        $JX = MoPHPSessions::getSessionVar("\143\165\162\x72\x65\156\x74\x5f\x75\162\154");
        do_action("\x75\x6e\163\145\164\x5f\163\x65\163\163\x69\157\156\137\166\141\x72\151\x61\142\x6c\145");
        header("\154\x6f\143\x61\x74\151\x6f\156\72" . $JX);
    }
    function validateOTP($lr, $xb, $lo)
    {
        $wB = MoPHPSessions::getSessionVar("\x75\163\x65\x72\137\154\157\x67\151\x6e");
        $CG = MoPHPSessions::getSessionVar("\165\x73\x65\162\137\x65\155\x61\x69\x6c");
        $J9 = MoPHPSessions::getSessionVar("\x70\150\157\156\x65\137\156\165\155\142\145\x72\137\x6d\157");
        $hs = MoPHPSessions::getSessionVar("\x75\x73\x65\162\137\x70\x61\163\163\x77\x6f\x72\x64");
        $tA = MoPHPSessions::getSessionVar("\145\x78\164\x72\x61\137\144\x61\x74\x61");
        $Oo = Sessionutils::getTransactionId($lr);
        $w0 = MoUtility::sanitizeCheck($xb, $_REQUEST);
        $w0 = !$w0 ? $lo : $w0;
        if (is_null($Oo)) {
            goto klj;
        }
        $tu = GatewayFunctions::instance();
        $SC = $tu->mo_validate_otp_token($Oo, $w0);
        switch ($SC["\x73\x74\x61\164\x75\x73"]) {
            case "\x53\x55\103\x43\105\x53\123":
                $this->onValidationSuccess($wB, $CG, $hs, $J9, $tA, $lr);
                goto joV;
            default:
                $this->onValidationFailed($wB, $CG, $J9, $lr);
                goto joV;
        }
        PtW:
        joV:
        klj:
    }
    private function onValidationSuccess($wB, $CG, $hs, $J9, $tA, $lr)
    {
        $u8 = array_key_exists("\162\x65\144\x69\x72\145\x63\164\137\x74\x6f", $_POST) ? $_POST["\x72\x65\144\x69\x72\x65\x63\x74\x5f\164\157"] : '';
        do_action("\157\164\160\x5f\166\145\x72\151\146\x69\x63\141\x74\x69\x6f\156\137\163\165\x63\143\x65\x73\x73\146\x75\x6c", $u8, $wB, $CG, $hs, $J9, $tA, $lr);
    }
    private function onValidationFailed($wB, $CG, $J9, $lr)
    {
        do_action("\x6f\x74\160\x5f\166\145\x72\151\x66\151\x63\x61\164\x69\157\156\x5f\x66\x61\x69\x6c\x65\x64", $wB, $CG, $J9, $lr);
    }
    private function handleOTPChoice($AA)
    {
        $kv = MoPHPSessions::getSessionVar("\165\163\145\x72\137\x6c\157\x67\151\x6e");
        $TK = MoPHPSessions::getSessionVar("\x75\x73\145\162\137\x65\155\x61\151\x6c");
        $xI = MoPHPSessions::getSessionVar("\160\150\157\156\x65\137\x6e\x75\155\142\x65\162\x5f\155\157");
        $aI = MoPHPSessions::getSessionVar("\x75\163\x65\162\x5f\x70\x61\x73\x73\x77\x6f\x72\x64");
        $iU = MoPHPSessions::getSessionVar("\x65\170\x74\x72\141\x5f\144\x61\164\x61");
        $HV = strcasecmp($AA["\x6d\157\137\143\x75\x73\x74\157\155\145\x72\x5f\x76\x61\x6c\151\x64\141\x74\151\157\x6e\137\x6f\164\x70\137\x63\x68\x6f\151\143\145"], "\165\163\145\x72\137\145\155\x61\151\x6c\137\166\145\162\x69\146\x69\143\141\164\151\x6f\156") == 0 ? VerificationType::EMAIL : VerificationType::PHONE;
        $this->challenge($kv, $TK, null, $xI, $HV, $aI, $iU, true);
    }
    function filterPhone($fk)
    {
        return str_replace("\x2b", '', $fk);
    }
    function handleFormActions()
    {
        if (!(array_key_exists("\x6f\x70\x74\x69\x6f\x6e", $_REQUEST) && MoUtility::micr())) {
            goto sRX;
        }
        $Wj = MoUtility::sanitizeCheck("\146\162\157\x6d\x5f\142\x6f\164\150", $_POST);
        $lr = MoUtility::sanitizeCheck("\157\x74\x70\x5f\164\x79\160\x65", $_POST);
        switch (trim($_REQUEST["\157\160\164\x69\157\156"])) {
            case "\166\x61\154\x69\x64\141\164\x69\x6f\156\x5f\x67\x6f\102\x61\143\153":
                $this->handleGoBackAction();
                goto fR6;
            case "\x6d\x69\156\x69\x6f\162\x61\x6e\x67\145\55\166\x61\x6c\151\144\x61\x74\145\55\x6f\164\160\55\x66\157\x72\x6d":
                $this->validateOTP($lr, "\155\157\x5f\157\x74\160\137\x74\x6f\x6b\x65\x6e", null);
                goto fR6;
            case "\166\145\x72\151\146\151\x63\141\164\151\x6f\156\x5f\x72\145\163\x65\x6e\144\137\x6f\x74\160":
                $this->handleResendOTP($lr, $Wj);
                goto fR6;
            case "\155\x69\x6e\x69\x6f\162\x61\x6e\147\x65\55\166\x61\154\151\144\141\x74\x65\x2d\157\164\x70\55\x63\x68\x6f\151\143\145\55\x66\x6f\x72\x6d":
                $this->handleOTPChoice($_POST);
                goto fR6;
        }
        eUp:
        fR6:
        sRX:
    }
}
