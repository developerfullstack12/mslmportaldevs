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
class FormMaker extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORM_MAKER;
        $this->_typePhoneTag = "\155\157\137\x66\157\162\155\137\x6d\141\x6b\x65\x72\137\160\x68\x6f\x6e\145\137\145\x6e\x61\142\x6c\x65";
        $this->_typeEmailTag = "\155\x6f\x5f\x66\157\x72\x6d\137\155\141\x6b\x65\x72\137\145\155\141\151\x6c\x5f\x65\156\x61\142\x6c\145";
        $this->_formName = mo_("\x46\157\x72\155\x20\x4d\141\153\x65\x72\40\x46\x6f\x72\155");
        $this->_formKey = "\106\117\x52\x4d\x5f\115\101\113\105\x52";
        $this->_isFormEnabled = get_mo_option("\146\x6f\x72\155\x6d\x61\153\145\162\137\145\156\x61\x62\154\145");
        $this->_otpType = get_mo_option("\146\x6f\162\x6d\x6d\x61\153\145\162\x5f\x65\156\141\142\154\145\x5f\x74\x79\160\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\x66\x6f\x72\x6d\155\x61\153\x65\162\x5f\157\x74\x70\137\x65\156\x61\x62\154\145\144"));
        $this->_buttonText = get_mo_option("\146\x6f\x72\155\155\x61\x6b\x65\162\x5f\x62\x75\164\x74\157\156\137\164\145\170\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\154\151\x63\x6b\x20\110\145\x72\145\x20\164\157\40\x73\x65\156\144\x20\117\124\x50");
        $this->_formDocuments = MoOTPDocs::FORMMAKER;
        parent::__construct();
        if (!$this->_isFormEnabled) {
            goto A8;
        }
        add_action("\x77\x70\137\x65\x6e\x71\x75\x65\165\x65\137\x73\x63\x72\151\x70\x74\x73", array($this, "\162\145\147\151\x73\x74\145\162\x5f\146\155\x5f\x62\165\x74\164\x6f\156\137\163\143\162\x69\x70\164"));
        A8:
    }
    function handleForm()
    {
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\160\x74\x69\x6f\x6e", $_GET)) {
            goto ZY;
        }
        return;
        ZY:
        switch (trim($_GET["\157\x70\x74\x69\157\x6e"])) {
            case "\155\x69\156\x69\157\x72\x61\x6e\x67\145\55\x66\155\x2d\x61\x6a\141\x78\55\x76\x65\x72\x69\x66\171":
                $this->_send_otp_fm_ajax_verify($_POST);
                goto P1;
            case "\x6d\x69\156\x69\x6f\162\141\156\x67\x65\x2d\146\x6d\x2d\x76\x65\x72\151\146\x79\55\143\x6f\144\145":
                $this->_validate_otp($_POST);
                goto P1;
        }
        sc:
        P1:
    }
    private function _validate_otp($post)
    {
        $this->validateChallenge($this->getVerificationType(), NULL, $post["\157\x74\x70\x5f\x74\x6f\153\x65\156"]);
    }
    function _send_otp_fm_ajax_verify($pO)
    {
        if ($this->_otpType == $this->_typePhoneTag) {
            goto Vx;
        }
        $this->_send_fm_ajax_otp_to_email($pO);
        goto pn;
        Vx:
        $this->_send_fm_ajax_otp_to_phone($pO);
        pn:
    }
    function _send_fm_ajax_otp_to_phone($pO)
    {
        if (!MoUtility::sanitizeCheck("\165\163\145\162\x5f\x70\x68\157\x6e\145", $pO)) {
            goto PH;
        }
        $this->sendOTP(trim($pO["\x75\x73\145\162\137\x70\150\157\156\145"]), NULL, trim($pO["\165\x73\145\162\x5f\160\150\x6f\x6e\145"]), VerificationType::PHONE);
        goto V0;
        PH:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        V0:
    }
    function _send_fm_ajax_otp_to_email($pO)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\145\162\x5f\x65\x6d\141\x69\154", $pO)) {
            goto Ix;
        }
        $this->sendOTP($pO["\165\x73\x65\x72\x5f\x65\x6d\x61\151\x6c"], $pO["\165\x73\x65\162\137\x65\155\141\x69\154"], NULL, VerificationType::EMAIL);
        goto zu;
        Ix:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        zu:
    }
    private function checkPhoneOrEmailIntegrity($On)
    {
        if ($this->getVerificationType() === VerificationType::PHONE) {
            goto rY;
        }
        return SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $On);
        goto O6;
        rY:
        return SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $On);
        O6:
    }
    private function sendOTP($ZI, $TK, $Zu, $lr)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($lr === VerificationType::PHONE) {
            goto Dh;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $ZI);
        goto aQ;
        Dh:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $ZI);
        aQ:
        $this->sendChallenge('', $TK, NULL, $Zu, $lr);
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto uM;
        }
        return;
        uM:
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        if ($this->checkPhoneOrEmailIntegrity($_POST["\x73\x75\x62\137\146\x69\145\154\144"])) {
            goto Ao;
        }
        if ($this->_otpType == $this->_typePhoneTag) {
            goto Aj;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        goto My;
        Aj:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        My:
        goto Ky;
        Ao:
        $this->unsetOTPSessionVariables();
        wp_send_json(MoUtility::createJson(self::VALIDATED, MoConstants::SUCCESS_JSON_TYPE));
        Ky:
    }
    function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->isFormEnabled() && $this->getVerificationType() === VerificationType::PHONE)) {
            goto jf;
        }
        array_push($zX, $this->_phoneFormId);
        jf:
        return $zX;
    }
    function register_fm_button_script()
    {
        wp_register_script("\x66\x6d\x6f\164\160\x62\x75\x74\164\x6f\x6e\x73\x63\162\x69\x70\x74", MOV_URL . "\151\x6e\x63\x6c\165\x64\145\163\57\152\x73\x2f\146\x6f\162\x6d\155\141\153\x65\x72\x2e\x6d\x69\x6e\56\x6a\163", array("\x6a\161\x75\x65\162\x79"));
        wp_localize_script("\x66\155\x6f\164\160\x62\x75\164\164\x6f\156\163\x63\162\x69\x70\164", "\155\x6f\x66\155\x76\141\162", array("\x73\x69\164\x65\x55\122\x4c" => site_url(), "\157\x74\160\x54\x79\160\145" => $this->_otpType, "\x66\x6f\162\155\104\x65\164\141\x69\154\x73" => $this->_formDetails, "\x62\x75\x74\x74\x6f\x6e\x74\x65\x78\x74" => mo_($this->_buttonText), "\151\x6d\x67\x55\x52\x4c" => MOV_URL . "\151\156\x63\154\x75\x64\145\x73\57\151\x6d\x61\147\x65\x73\x2f\x6c\157\x61\x64\x65\162\56\147\151\x66"));
        wp_enqueue_script("\146\155\x6f\x74\x70\x62\x75\164\164\157\156\x73\143\x72\151\160\x74");
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Jh;
        }
        return;
        Jh:
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_otpType = $this->sanitizeFormPOST("\x66\155\137\145\x6e\x61\x62\x6c\x65\137\164\171\160\x65");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x66\x6d\137\x65\156\141\x62\154\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\x66\x6d\x5f\x62\165\x74\164\157\x6e\x5f\164\145\x78\x74");
        if (!$this->basicValidationCheck(BaseMessages::FORMMAKER_CHOOSE)) {
            goto ok;
        }
        update_mo_option("\x66\157\x72\x6d\155\x61\x6b\145\x72\137\x65\x6e\141\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\146\x6f\162\155\x6d\141\153\145\162\x5f\x65\156\141\x62\154\x65\x5f\164\171\160\x65", $this->_otpType);
        update_mo_option("\x66\157\x72\155\x6d\x61\153\x65\162\137\157\164\x70\137\x65\x6e\x61\142\x6c\x65\x64", maybe_serialize($this->_formDetails));
        update_mo_option("\x66\157\162\155\x6d\141\153\x65\x72\x5f\142\x75\x74\164\157\x6e\x5f\x74\145\x78\164", $this->_buttonText);
        ok:
    }
    private function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\x66\157\x72\155\x6d\x61\x6b\x65\x72\137\146\x6f\162\x6d", $_POST)) {
            goto jG;
        }
        return array();
        jG:
        foreach (array_filter($_POST["\x66\157\x72\x6d\155\141\x6b\145\x72\x5f\x66\157\x72\155"]["\146\157\162\155"]) as $Zm => $zs) {
            $form[$zs] = array("\145\155\141\151\x6c\x6b\145\171" => $this->_get_efield_id($_POST["\146\x6f\162\155\155\x61\x6b\145\162\137\146\x6f\x72\155"]["\145\x6d\141\x69\154\x6b\145\171"][$Zm], $zs), "\x70\150\157\x6e\145\x6b\145\x79" => $this->_get_efield_id($_POST["\x66\157\162\155\x6d\x61\x6b\145\162\x5f\x66\157\162\155"]["\160\x68\x6f\156\145\x6b\145\x79"][$Zm], $zs), "\x76\x65\162\151\146\x79\113\145\171" => $this->_get_efield_id($_POST["\146\157\x72\x6d\x6d\141\x6b\x65\x72\x5f\x66\x6f\x72\155"]["\166\x65\x72\x69\x66\171\x4b\145\171"][$Zm], $zs), "\x70\x68\157\x6e\145\x5f\163\x68\157\167" => $_POST["\146\157\162\x6d\155\141\153\145\162\x5f\x66\157\x72\155"]["\x70\150\157\x6e\x65\x6b\145\171"][$Zm], "\145\155\x61\151\154\x5f\x73\x68\x6f\x77" => $_POST["\x66\157\x72\x6d\155\141\153\145\162\x5f\x66\157\162\155"]["\145\155\141\151\154\153\145\171"][$Zm], "\x76\145\162\151\x66\171\x5f\163\150\157\167" => $_POST["\146\x6f\x72\155\155\141\x6b\x65\162\137\146\157\162\155"]["\x76\x65\162\x69\x66\171\113\145\171"][$Zm]);
            EZ:
        }
        EO:
        return $form;
    }
    private function _get_efield_id($Nt, $form)
    {
        global $wpdb;
        $O2 = $wpdb->get_row("\x53\105\114\105\x43\x54\x20\52\40\x46\122\117\x4d\40{$wpdb->prefix}\146\x6f\x72\155\155\x61\153\145\162\x20\167\150\145\162\145\x20\x60\151\144\140\x20\x3d" . $form);
        if (!MoUtility::isBlank($O2)) {
            goto PA;
        }
        return '';
        PA:
        $KB = explode("\52\x3a\x2a\x6e\145\167\x5f\146\x69\x65\x6c\x64\x2a\x3a\52", $O2->form_fields);
        $vl = $Yk = $Kv = array();
        foreach ($KB as $Pj) {
            $oQ = explode("\x2a\72\52\x69\x64\x2a\x3a\52", $Pj);
            if (MoUtility::isBlank($oQ)) {
                goto Nz;
            }
            array_push($vl, $oQ[0]);
            if (!array_key_exists(1, $oQ)) {
                goto Sl;
            }
            $oQ = explode("\x2a\x3a\52\x74\x79\160\145\x2a\72\x2a", $oQ[1]);
            array_push($Yk, $oQ[0]);
            $oQ = explode("\52\72\x2a\x77\x5f\x66\x69\x65\x6c\144\x5f\x6c\x61\x62\145\x6c\x2a\72\x2a", $oQ[1]);
            Sl:
            array_push($Kv, $oQ[0]);
            Nz:
            WT:
        }
        Qp:
        $Zm = array_search($Nt, $Kv);
        return "\43\x77\x64\x66\x6f\162\x6d\x5f" . $vl[$Zm] . "\x5f\145\154\145\155\145\156\164" . $form;
    }
}
