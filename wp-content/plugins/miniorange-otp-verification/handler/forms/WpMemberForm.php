<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class WpMemberForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WPMEMBER_REG;
        $this->_emailKey = "\x75\x73\x65\x72\x5f\145\155\x61\151\154";
        $this->_phoneKey = get_mo_option("\167\x70\x5f\x6d\x65\x6d\142\x65\162\x5f\162\145\x67\x5f\160\x68\157\156\145\137\x66\151\x65\154\x64\137\153\145\x79");
        $this->_phoneFormId = "\x69\156\160\165\164\133\156\141\155\145\x3d{$this->_phoneKey}\x5d";
        $this->_formKey = "\127\120\x5f\x4d\105\115\x42\x45\x52\137\106\x4f\x52\x4d";
        $this->_typePhoneTag = "\x6d\x6f\x5f\167\x70\155\x65\x6d\142\145\162\x5f\162\x65\x67\x5f\x70\150\x6f\x6e\x65\137\145\x6e\141\x62\x6c\145";
        $this->_typeEmailTag = "\155\x6f\137\x77\x70\x6d\145\155\x62\x65\162\137\x72\145\x67\x5f\x65\x6d\141\x69\154\x5f\x65\156\141\142\x6c\145";
        $this->_formName = mo_("\x57\120\x2d\115\145\155\x62\145\x72\x73");
        $this->_isFormEnabled = get_mo_option("\x77\160\x5f\155\x65\x6d\x62\145\162\x5f\x72\x65\147\137\145\156\141\142\154\145");
        $this->_formDocuments = MoOTPDocs::WP_MEMBER_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x77\x70\x5f\x6d\145\x6d\x62\145\162\x5f\x72\145\x67\x5f\145\156\x61\x62\154\145\137\x74\171\160\x65");
        add_filter("\167\160\155\145\155\x5f\x72\x65\147\151\x73\x74\145\162\137\146\x6f\x72\x6d\x5f\x72\157\x77\163", array($this, "\x77\160\x6d\x65\x6d\142\145\x72\137\x61\144\x64\x5f\142\x75\164\164\x6f\156"), 99, 2);
        add_action("\167\x70\155\145\155\x5f\160\162\x65\x5f\x72\x65\x67\151\163\x74\x65\x72\137\144\x61\x74\x61", array($this, "\x76\x61\x6c\x69\x64\x61\164\x65\x5f\167\160\x6d\x65\155\142\x65\x72\137\x73\165\x62\x6d\151\x74"), 99, 1);
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\160\x74\x69\157\x6e", $_REQUEST)) {
            goto lQB;
        }
        return;
        lQB:
        switch (trim($_REQUEST["\x6f\x70\x74\151\157\156"])) {
            case "\155\x69\x6e\151\157\x72\x61\x6e\x67\x65\55\x77\x70\x6d\x65\x6d\x62\x65\162\55\146\157\x72\x6d":
                $this->_handle_wp_member_form($_POST);
                goto EOl;
        }
        dZj:
        EOl:
    }
    function _handle_wp_member_form($pO)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (!($this->_otpType === $this->_typeEmailTag)) {
            goto cuN;
        }
        $this->processEmailAndStartOTPVerificationProcess($pO);
        cuN:
        if (!($this->_otpType === $this->_typePhoneTag)) {
            goto pQ_;
        }
        $this->processPhoneAndStartOTPVerificationProcess($pO);
        pQ_:
    }
    function processEmailAndStartOTPVerificationProcess($pO)
    {
        if (MoUtility::sanitizeCheck("\165\163\145\x72\137\145\155\x61\x69\154", $pO)) {
            goto L6y;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto Bf2;
        L6y:
        SessionUtils::addEmailVerified($this->_formSessionVar, $pO["\x75\163\x65\x72\137\x65\x6d\x61\x69\x6c"]);
        $this->sendChallenge(null, $pO["\165\x73\145\162\137\x65\x6d\x61\151\154"], null, '', VerificationType::EMAIL, null, null, false);
        Bf2:
    }
    function processPhoneAndStartOTPVerificationProcess($pO)
    {
        if (MoUtility::sanitizeCheck("\165\x73\x65\x72\x5f\x70\x68\157\156\x65", $pO)) {
            goto HbJ;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto H4n;
        HbJ:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $pO["\x75\163\x65\x72\137\160\x68\157\156\145"]);
        $this->sendChallenge(null, '', null, $pO["\x75\163\x65\162\x5f\x70\x68\x6f\156\x65"], VerificationType::PHONE, null, null, false);
        H4n:
    }
    function wpmember_add_button($PC, $dy)
    {
        foreach ($PC as $Zm => $Pj) {
            if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 && $Zm === $this->_phoneKey) {
                goto KpD;
            }
            if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0 && $Zm === $this->_emailKey)) {
                goto o6E;
            }
            $PC[$Zm]["\146\x69\x65\154\x64"] .= $this->_add_shortcode_to_wpmember("\145\x6d\x61\x69\154", $Pj["\155\145\x74\x61"]);
            goto yz5;
            o6E:
            goto BXN;
            KpD:
            $PC[$Zm]["\146\x69\x65\154\144"] .= $this->_add_shortcode_to_wpmember("\160\150\157\156\145", $Pj["\155\145\164\x61"]);
            goto yz5;
            BXN:
            DQV:
        }
        yz5:
        return $PC;
    }
    function validate_wpmember_submit($KB)
    {
        global $wpmem_themsg;
        $lr = $this->getVerificationType();
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Lox;
        }
        if ($this->validate_submitted($KB, $lr)) {
            goto Wiw;
        }
        return;
        Wiw:
        goto Yk4;
        Lox:
        $wpmem_themsg = MoMessages::showMessage(MoMessages::PLEASE_VALIDATE);
        Yk4:
        $this->validateChallenge($lr, NULL, $KB["\166\x61\x6c\x69\x64\x61\x74\x65\137\157\x74\x70"]);
    }
    function validate_submitted($KB, $lr)
    {
        global $wpmem_themsg;
        if ($lr === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $KB[$this->_emailKey])) {
            goto yz_;
        }
        if ($lr == VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $KB[$this->_phoneKey])) {
            goto PxS;
        }
        return true;
        goto Mc4;
        PxS:
        $wpmem_themsg = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        return false;
        Mc4:
        goto db2;
        yz_:
        $wpmem_themsg = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        return false;
        db2:
    }
    function _add_shortcode_to_wpmember($T0, $Pj)
    {
        $Eo = "\x3c\144\x69\x76\x20\163\164\x79\x6c\x65\75\x27\x64\151\x73\x70\154\x61\x79\72\x74\141\142\154\145\73\164\145\170\164\x2d\141\x6c\x69\x67\156\x3a\x63\x65\x6e\x74\x65\x72\73\47\x3e\x3c\151\155\x67\40\x73\x72\143\75\47" . MOV_URL . "\151\156\143\x6c\x75\x64\145\163\57\151\155\141\147\145\163\57\x6c\157\x61\x64\145\x72\x2e\x67\x69\x66\47\76\74\x2f\144\151\x76\x3e";
        $rL = "\x3c\x64\151\x76\40\x73\164\x79\154\145\75\47\155\x61\x72\x67\x69\x6e\x2d\164\x6f\160\x3a\40\x32\45\x3b\47\x3e\74\x62\x75\x74\x74\157\156\40\x74\x79\x70\145\x3d\x27\142\x75\x74\164\157\x6e\47\40\x63\x6c\141\163\163\x3d\47\142\165\164\x74\x6f\156\40\141\154\164\x27\x20\x73\x74\171\154\145\75\x27\x77\x69\x64\164\x68\x3a\61\x30\60\x25\73\x68\x65\x69\x67\150\x74\72\63\60\x70\x78\73";
        $rL .= "\x66\x6f\156\x74\55\x66\141\155\151\154\171\72\40\x52\x6f\x62\157\x74\157\x3b\146\157\x6e\x74\55\163\x69\172\x65\72\40\61\62\x70\170\40\x21\151\155\x70\157\x72\x74\141\156\x74\x3b\47\x20\151\x64\75\x27\155\x69\156\x69\x6f\162\x61\x6e\x67\x65\137\x6f\164\160\x5f\164\157\x6b\145\156\137\x73\x75\142\155\151\164\x27\40";
        $rL .= "\x74\151\164\154\145\x3d\47\x50\154\145\141\x73\145\40\x45\156\x74\145\x72\x20\x61\x6e\x20\47" . $T0 . "\47\164\x6f\x20\x65\x6e\x61\x62\x6c\x65\40\164\150\151\x73\56\47\x3e\103\x6c\151\x63\x6b\x20\110\x65\162\145\40\x74\x6f\x20\x56\x65\x72\x69\146\171\x20" . $T0 . "\74\x2f\x62\x75\x74\x74\157\x6e\76\74\x2f\x64\x69\x76\x3e";
        $rL .= "\74\144\151\x76\x20\163\x74\x79\154\x65\75\x27\155\141\x72\147\x69\156\x2d\x74\x6f\160\72\x32\x25\x27\x3e\x3c\x64\151\x76\40\151\x64\x3d\47\155\x6f\x5f\x6d\145\x73\163\141\147\x65\x27\x20\150\151\x64\x64\x65\x6e\x3d\x27\x27\40\x73\x74\x79\154\145\75\x27\142\x61\x63\153\147\x72\157\165\x6e\144\55\143\x6f\x6c\157\x72\x3a\x20\43\146\x37\x66\66\146\67\x3b\160\141\x64\x64\151\156\x67\x3a\x20";
        $rL .= "\x31\145\155\40\x32\x65\155\x20\x31\145\155\40\63\x2e\65\145\x6d\73\x27\76\x3c\57\144\151\x76\x3e\x3c\x2f\x64\x69\166\76";
        $rL .= "\x3c\163\x63\x72\151\x70\164\76\x6a\x51\x75\145\x72\x79\x28\144\157\x63\165\x6d\x65\x6e\x74\51\x2e\162\x65\141\144\x79\50\x66\165\156\143\x74\x69\x6f\156\50\x29\173\x24\x6d\157\x3d\152\121\x75\x65\162\171\73\44\x6d\x6f\50\x22\43\155\x69\156\x69\157\162\x61\156\147\145\137\157\164\160\x5f\164\x6f\153\145\156\137\x73\165\142\155\151\164\42\51\56\143\154\x69\143\153\x28\146\165\x6e\x63\164\x69\x6f\x6e\x28\157\x29\x7b\40";
        $rL .= "\166\x61\x72\40\145\75\x24\155\157\x28\42\x69\156\x70\165\164\x5b\156\x61\155\145\x3d" . $Pj . "\x5d\42\x29\56\x76\x61\154\50\51\x3b\x20\44\x6d\x6f\50\42\x23\155\157\137\x6d\x65\163\163\x61\147\145\x22\51\x2e\x65\155\x70\164\171\x28\x29\x2c\x24\x6d\x6f\x28\42\43\155\157\x5f\x6d\x65\x73\163\141\x67\x65\x22\51\56\141\160\160\145\156\x64\50\x22" . $Eo . "\x22\51\54";
        $rL .= "\x24\155\157\x28\42\x23\155\157\137\155\x65\x73\x73\x61\x67\x65\42\x29\56\163\150\x6f\167\x28\x29\54\44\x6d\x6f\x2e\141\152\x61\x78\50\173\165\162\154\x3a\42" . site_url() . "\x2f\77\x6f\160\164\151\157\156\75\155\151\156\151\x6f\162\x61\156\147\145\x2d\167\x70\155\145\155\x62\145\162\55\x66\157\162\x6d\42\x2c\x74\171\160\x65\72\42\120\117\x53\x54\x22\54";
        $rL .= "\144\141\x74\x61\x3a\x7b\x75\163\145\162\137" . $T0 . "\x3a\145\175\54\x63\162\157\x73\x73\x44\x6f\155\141\x69\156\x3a\x21\x30\54\144\x61\164\141\x54\171\160\x65\x3a\x22\152\163\x6f\156\x22\54\163\165\143\143\145\x73\x73\x3a\146\165\x6e\143\164\x69\x6f\x6e\50\x6f\51\173\x20";
        $rL .= "\x69\146\x28\157\x2e\162\145\163\165\x6c\164\x3d\x3d\x3d\x22\163\x75\143\x63\x65\x73\x73\42\51\x7b\x24\155\157\x28\x22\43\155\157\x5f\x6d\145\163\163\141\147\145\x22\51\x2e\x65\155\160\x74\171\50\x29\x2c\x24\155\157\x28\x22\43\155\x6f\x5f\x6d\145\163\x73\x61\147\x65\42\51\56\x61\160\160\145\156\x64\x28\x6f\x2e\x6d\145\x73\x73\x61\x67\145\x29\x2c";
        $rL .= "\x24\x6d\157\50\42\x23\x6d\x6f\x5f\155\x65\163\x73\141\x67\145\x22\x29\x2e\143\x73\163\50\x22\142\157\x72\144\145\x72\x2d\164\157\160\x22\x2c\x22\63\160\x78\40\x73\x6f\154\151\x64\x20\x67\x72\x65\x65\x6e\42\51\54\44\155\157\x28\42\151\x6e\x70\165\x74\133\x6e\141\x6d\145\x3d\145\x6d\141\151\154\137\166\145\162\151\x66\x79\135\x22\x29\56\146\x6f\143\x75\163\x28\51\175\145\x6c\x73\145\173";
        $rL .= "\44\155\157\50\42\43\155\x6f\137\155\145\x73\163\x61\147\145\42\51\x2e\145\155\160\164\171\x28\51\54\44\155\157\50\x22\x23\x6d\157\137\x6d\145\x73\x73\x61\147\x65\42\51\x2e\141\160\x70\145\x6e\144\50\x6f\56\155\x65\x73\163\141\147\x65\51\x2c\x24\155\157\50\x22\43\x6d\x6f\x5f\155\x65\163\x73\x61\147\145\42\51\56\143\163\x73\x28\x22\x62\157\x72\x64\145\x72\x2d\164\x6f\160\42\54\x22\x33\x70\170\40\163\x6f\154\x69\144\40\162\x65\x64\x22\x29";
        $rL .= "\x2c\44\155\157\x28\42\151\x6e\x70\165\164\133\156\141\155\145\x3d\x70\x68\x6f\156\x65\137\x76\145\x72\151\x66\171\x5d\x22\51\x2e\146\x6f\x63\x75\x73\x28\x29\175\40\x3b\x7d\x2c\x65\162\x72\157\162\72\146\165\x6e\x63\x74\x69\x6f\156\50\x6f\54\x65\x2c\x6e\x29\173\175\x7d\51\175\x29\x3b\175\x29\x3b\x3c\x2f\163\143\x72\x69\160\164\x3e";
        return $rL;
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        global $wpmem_themsg;
        $wpmem_themsg = MoUtility::_get_invalid_otp_method();
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        $this->unsetOTPSessionVariables();
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto qw9;
        }
        array_push($zX, $this->_phoneFormId);
        qw9:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Q_u;
        }
        return;
        Q_u:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\x70\x5f\155\x65\x6d\x62\x65\162\137\162\x65\x67\x5f\145\x6e\141\142\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x77\x70\137\155\145\155\142\145\x72\137\162\x65\147\137\x65\x6e\x61\142\x6c\x65\137\164\171\160\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\167\x70\x5f\x6d\x65\x6d\142\x65\162\137\162\145\x67\137\160\x68\157\x6e\145\137\x66\151\x65\x6c\144\x5f\153\x65\x79");
        if (!$this->basicValidationCheck(BaseMessages::WP_MEMBER_CHOOSE)) {
            goto zkG;
        }
        update_mo_option("\167\160\137\x6d\x65\x6d\142\145\x72\x5f\x72\x65\x67\137\x70\150\157\x6e\x65\137\146\x69\x65\154\x64\x5f\x6b\145\171", $this->_phoneKey);
        update_mo_option("\x77\x70\137\155\145\155\x62\145\162\137\162\145\147\x5f\145\156\141\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\167\160\x5f\x6d\145\x6d\142\x65\162\x5f\162\x65\147\x5f\145\156\141\x62\154\x65\x5f\164\171\160\145", $this->_otpType);
        zkG:
    }
}
