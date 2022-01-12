<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class FormCraftBasicForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORMCRAFT;
        $this->_typePhoneTag = "\x6d\157\137\x66\x6f\x72\x6d\143\162\141\x66\x74\x5f\x70\x68\157\x6e\145\x5f\145\156\x61\x62\154\145";
        $this->_typeEmailTag = "\155\157\x5f\x66\157\162\x6d\143\x72\141\146\164\x5f\x65\x6d\141\x69\x6c\x5f\x65\x6e\141\x62\x6c\x65";
        $this->_formKey = "\x46\117\x52\x4d\103\122\101\x46\124\x42\x41\x53\111\x43";
        $this->_formName = mo_("\106\157\x72\x6d\x43\x72\141\x66\164\40\x42\141\x73\151\x63\x20\50\x46\162\x65\x65\x20\x56\x65\162\x73\151\157\x6e\51");
        $this->_isFormEnabled = get_mo_option("\146\x6f\x72\155\143\162\x61\146\x74\137\x65\156\x61\x62\154\x65");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::FORMCRAFT_BASIC_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        if ($this->isFormCraftPluginInstalled()) {
            goto rO8;
        }
        return;
        rO8:
        $this->_otpType = get_mo_option("\146\x6f\x72\155\x63\x72\141\146\164\137\x65\156\x61\x62\x6c\x65\137\164\171\x70\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\146\157\x72\155\143\162\141\146\x74\x5f\157\x74\160\x5f\145\x6e\141\x62\154\145\144"));
        if (!empty($this->_formDetails)) {
            goto eO5;
        }
        return;
        eO5:
        foreach ($this->_formDetails as $Zm => $zs) {
            array_push($this->_phoneFormId, "\x5b\x64\141\x74\141\x2d\x69\x64\75" . $Zm . "\135\40\151\156\160\165\164\133\x6e\141\155\145\x3d" . $zs["\160\150\x6f\156\145\153\145\171"] . "\135");
            vRU:
        }
        K66:
        add_action("\x77\x70\x5f\x61\152\141\x78\x5f\x66\157\x72\155\x63\162\x61\x66\x74\x5f\142\141\163\151\x63\x5f\146\x6f\x72\155\137\163\x75\x62\155\151\164", array($this, "\x76\141\154\151\144\x61\164\145\x5f\146\x6f\162\x6d\x63\162\141\x66\164\x5f\x66\157\x72\x6d\x5f\163\165\142\155\x69\x74"), 1);
        add_action("\167\x70\137\x61\x6a\141\x78\x5f\156\x6f\x70\162\x69\x76\137\x66\x6f\162\x6d\x63\162\141\146\x74\137\x62\x61\163\x69\143\x5f\146\157\x72\155\137\163\165\142\x6d\151\x74", array($this, "\166\141\x6c\151\144\x61\164\145\x5f\146\157\x72\155\x63\162\141\x66\x74\x5f\x66\157\x72\x6d\x5f\x73\165\x62\x6d\151\164"), 1);
        add_action("\x77\160\137\x65\x6e\161\165\145\x75\x65\x5f\163\x63\x72\x69\160\164\x73", array($this, "\x65\156\161\x75\x65\165\145\137\x73\143\162\x69\160\x74\x5f\x6f\x6e\137\160\141\x67\145"));
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\x70\164\151\157\x6e", $_GET)) {
            goto uq7;
        }
        return;
        uq7:
        switch (trim($_GET["\157\160\x74\151\x6f\x6e"])) {
            case "\x6d\x69\156\151\x6f\x72\141\x6e\x67\145\55\146\x6f\x72\155\x63\x72\x61\x66\x74\x2d\166\145\162\x69\146\171":
                $this->_handle_formcraft_form($_POST);
                goto a1K;
            case "\155\151\156\x69\x6f\162\141\x6e\x67\145\x2d\146\157\x72\155\143\162\x61\146\164\x2d\146\x6f\x72\x6d\55\157\164\x70\55\145\x6e\x61\142\154\x65\x64":
                wp_send_json($this->isVerificationEnabledForThisForm($_POST["\x66\x6f\x72\155\137\x69\144"]));
                goto a1K;
        }
        t_5:
        a1K:
    }
    function _handle_formcraft_form($pO)
    {
        if ($this->isVerificationEnabledForThisForm($_POST["\146\157\162\x6d\x5f\x69\x64"])) {
            goto NI3;
        }
        return;
        NI3:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto DL6;
        }
        $this->_send_otp_to_email($pO);
        goto JCW;
        DL6:
        $this->_send_otp_to_phone($pO);
        JCW:
    }
    function _send_otp_to_phone($pO)
    {
        if (array_key_exists("\165\x73\145\x72\137\160\150\157\156\145", $pO) && !MoUtility::isBlank($pO["\x75\x73\x65\x72\x5f\160\x68\x6f\156\x65"])) {
            goto LmD;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto Ddn;
        LmD:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $pO["\x75\163\145\x72\x5f\x70\x68\x6f\x6e\145"]);
        $this->sendChallenge("\x74\x65\x73\x74", '', null, trim($pO["\165\x73\145\162\x5f\160\x68\157\156\145"]), VerificationType::PHONE);
        Ddn:
    }
    function _send_otp_to_email($pO)
    {
        if (array_key_exists("\165\x73\145\162\x5f\145\155\141\x69\x6c", $pO) && !MoUtility::isBlank($pO["\165\163\x65\x72\x5f\x65\x6d\141\x69\x6c"])) {
            goto VGB;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto Kzb;
        VGB:
        SessionUtils::addEmailVerified($this->_formSessionVar, $pO["\165\x73\x65\x72\137\145\x6d\x61\x69\x6c"]);
        $this->sendChallenge("\x74\145\163\164", $pO["\165\163\145\x72\x5f\145\155\141\151\154"], null, $pO["\165\163\145\x72\x5f\x65\155\141\x69\154"], VerificationType::EMAIL);
        Kzb:
    }
    function validate_formcraft_form_submit()
    {
        $D5 = $_POST["\x69\144"];
        if ($this->isVerificationEnabledForThisForm($D5)) {
            goto t18;
        }
        return;
        t18:
        $this->checkIfVerificationNotStarted($D5);
        $VJ = $this->_formDetails[$D5];
        $lr = $this->getVerificationType();
        if ($lr === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $_POST[$VJ["\160\150\x6f\156\x65\153\x65\171"]])) {
            goto IB8;
        }
        if ($lr === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $_POST[$VJ["\145\155\x61\x69\154\x6b\145\x79"]])) {
            goto zM7;
        }
        goto ChT;
        IB8:
        $this->sendJSONErrorMessage(array("\145\162\162\x6f\162\x73" => array($this->_formDetails[$D5]["\160\150\157\156\x65\x6b\145\171"] => MoMessages::showMessage(MoMessages::PHONE_MISMATCH))));
        goto ChT;
        zM7:
        $this->sendJSONErrorMessage(array("\x65\x72\162\157\x72\x73" => array($this->_formDetails[$D5]["\x65\155\141\x69\x6c\x6b\145\x79"] => MoMessages::showMessage(MoMessages::EMAIL_MISMATCH))));
        ChT:
        if (MoUtility::sanitizeCheck($_POST, $VJ["\x76\145\x72\151\x66\171\113\145\171"])) {
            goto DEo;
        }
        $this->sendJSONErrorMessage(array("\x65\x72\162\x6f\162\x73" => array($this->_formDetails[$D5]["\x76\145\162\151\146\x79\x4b\145\171"] => MoUtility::_get_invalid_otp_method())));
        DEo:
        SessionUtils::setFormOrFieldId($this->_formSessionVar, $D5);
        $this->validateChallenge($lr, NULL, $_POST[$VJ["\x76\145\162\x69\146\x79\x4b\145\171"]]);
    }
    function enqueue_script_on_page()
    {
        wp_register_script("\146\x6f\162\155\x63\x72\x61\146\x74\163\x63\162\x69\x70\x74", MOV_URL . "\x69\x6e\143\154\165\144\x65\163\57\152\x73\57\146\x6f\x72\155\143\x72\141\x66\164\x62\141\163\151\x63\56\155\x69\x6e\x2e\x6a\x73\77\x76\x65\x72\x73\x69\157\x6e\75" . MOV_VERSION, array("\x6a\161\165\x65\x72\x79"));
        wp_localize_script("\146\x6f\162\x6d\143\162\x61\146\x74\163\x63\x72\x69\x70\x74", "\155\x6f\x66\143\x76\141\162\x73", array("\x69\x6d\x67\x55\122\114" => MOV_LOADER_URL, "\x66\x6f\162\x6d\x43\162\x61\x66\x74\106\157\x72\x6d\x73" => $this->_formDetails, "\163\x69\x74\x65\125\122\x4c" => site_url(), "\x6f\x74\160\124\x79\160\145" => $this->_otpType, "\142\x75\x74\164\x6f\156\124\x65\x78\164" => mo_("\103\x6c\x69\x63\x6b\x20\x68\145\x72\145\40\164\x6f\40\163\x65\156\144\x20\117\x54\x50"), "\x62\x75\164\x74\x6f\156\124\x69\164\x6c\x65" => $this->_otpType === $this->_typePhoneTag ? mo_("\120\x6c\x65\141\x73\x65\x20\145\x6e\164\x65\162\40\141\40\120\x68\157\156\x65\x20\116\165\x6d\142\x65\162\40\164\157\x20\145\x6e\x61\142\154\x65\x20\x74\x68\151\163\x20\146\151\145\x6c\144\56") : mo_("\120\154\x65\141\163\145\x20\145\156\164\x65\162\x20\141\40\120\150\157\x6e\x65\40\116\x75\155\x62\145\162\x20\x74\157\x20\145\x6e\141\142\154\x65\x20\x74\150\151\x73\x20\x66\x69\x65\x6c\144\56"), "\141\152\141\170\165\162\154" => wp_ajax_url(), "\x74\171\x70\x65\120\x68\157\x6e\145" => $this->_typePhoneTag, "\x63\157\x75\156\x74\x72\171\104\x72\157\x70" => get_mo_option("\163\x68\157\167\137\x64\162\157\160\144\x6f\x77\x6e\x5f\157\156\x5f\x66\x6f\x72\x6d")));
        wp_enqueue_script("\x66\157\162\x6d\x63\162\x61\x66\x74\x73\x63\162\151\x70\x74");
    }
    function isVerificationEnabledForThisForm($D5)
    {
        return array_key_exists($D5, $this->_formDetails);
    }
    function sendJSONErrorMessage($errors)
    {
        $Re["\146\x61\151\154\145\144"] = mo_("\120\154\x65\x61\163\145\40\143\157\x72\x72\x65\143\164\x20\x74\x68\145\40\x65\162\162\157\162\x73");
        $Re["\x65\x72\x72\x6f\162\163"] = $errors;
        echo json_encode($Re);
        die;
    }
    function checkIfVerificationNotStarted($D5)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto XeI;
        }
        return;
        XeI:
        $PV = MoMessages::showMessage(MoMessages::PLEASE_VALIDATE);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto f0f;
        }
        $this->sendJSONErrorMessage(array("\x65\162\162\x6f\162\163" => array($this->_formDetails[$D5]["\145\155\x61\151\x6c\x6b\145\x79"] => $PV)));
        goto Us1;
        f0f:
        $this->sendJSONErrorMessage(array("\145\x72\x72\x6f\x72\x73" => array($this->_formDetails[$D5]["\x70\x68\x6f\x6e\145\153\x65\x79"] => $PV)));
        Us1:
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto brW;
        }
        return;
        brW:
        $a8 = SessionUtils::getFormOrFieldId($this->_formSessionVar);
        $this->sendJSONErrorMessage(array("\x65\162\162\x6f\162\163" => array($this->_formDetails[$a8]["\166\145\x72\151\x66\x79\113\x65\171"] => MoUtility::_get_invalid_otp_method())));
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
            goto P6N;
        }
        $zX = array_merge($zX, $this->_phoneFormId);
        P6N:
        return $zX;
    }
    function isFormCraftPluginInstalled()
    {
        return MoUtility::getActivePluginVersion("\x46\x6f\x72\x6d\x43\x72\141\x66\164") < 3 ? true : false;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto CGV;
        }
        return;
        CGV:
        if ($this->isFormCraftPluginInstalled()) {
            goto mwc;
        }
        return;
        mwc:
        if (array_key_exists("\146\157\x72\x6d\x63\x72\x61\x66\x74\137\146\x6f\x72\x6d", $_POST)) {
            goto J85;
        }
        return;
        J85:
        foreach (array_filter($_POST["\x66\157\x72\155\143\162\x61\x66\x74\x5f\146\157\x72\155"]["\146\x6f\x72\155"]) as $Zm => $zs) {
            $VJ = $this->getFormCraftFormDataFromID($zs);
            if (!MoUtility::isBlank($VJ)) {
                goto a4W;
            }
            goto hbA;
            a4W:
            $tb = $this->getFieldIDs($_POST, $Zm, $VJ);
            $form[$zs] = array("\145\x6d\x61\x69\154\x6b\x65\171" => $tb["\145\x6d\x61\x69\x6c\113\145\171"], "\x70\x68\157\156\x65\153\145\171" => $tb["\x70\150\x6f\x6e\x65\x4b\x65\171"], "\166\x65\162\151\146\x79\x4b\x65\171" => $tb["\166\x65\162\151\146\x79\x4b\145\x79"], "\160\x68\157\x6e\145\x5f\163\x68\157\x77" => $_POST["\146\157\162\x6d\x63\162\141\x66\164\x5f\x66\x6f\x72\155"]["\x70\x68\x6f\156\145\153\x65\171"][$Zm], "\x65\x6d\x61\151\154\x5f\163\x68\x6f\x77" => $_POST["\x66\157\x72\x6d\143\x72\141\146\x74\137\146\157\162\155"]["\145\x6d\x61\x69\154\x6b\145\171"][$Zm], "\166\145\x72\151\x66\171\x5f\x73\150\x6f\x77" => $_POST["\146\x6f\162\x6d\143\x72\141\146\164\137\x66\x6f\x72\155"]["\x76\145\x72\x69\x66\x79\x4b\x65\x79"][$Zm]);
            hbA:
        }
        A7s:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x66\157\162\155\143\162\141\x66\x74\x5f\x65\156\141\x62\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x66\157\162\x6d\x63\x72\x61\146\x74\x5f\145\156\x61\x62\154\x65\x5f\164\x79\160\145");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\x66\x6f\162\155\x63\162\141\146\x74\x5f\145\156\x61\142\154\145", $this->_isFormEnabled);
        update_mo_option("\146\157\162\155\143\162\141\146\164\x5f\145\x6e\x61\142\x6c\x65\x5f\x74\171\x70\145", $this->_otpType);
        update_mo_option("\x66\x6f\x72\x6d\143\162\141\146\164\x5f\157\164\x70\137\145\156\141\142\x6c\x65\144", maybe_serialize($this->_formDetails));
    }
    private function getFieldIDs($pO, $Zm, $VJ)
    {
        $tb = array("\145\x6d\141\x69\154\113\145\171" => '', "\x70\x68\157\156\145\x4b\145\x79" => '', "\x76\145\162\x69\146\171\x4b\x65\171" => '');
        if (!empty($pO)) {
            goto bMo;
        }
        return $tb;
        bMo:
        foreach ($VJ as $form) {
            if (!(strcasecmp($form["\x65\154\x65\155\x65\x6e\164\x44\x65\146\141\165\154\x74\163"]["\155\141\151\156\137\154\141\x62\145\x6c"], $pO["\146\x6f\x72\x6d\x63\162\141\146\164\x5f\146\x6f\x72\x6d"]["\x65\155\x61\151\x6c\153\x65\171"][$Zm]) === 0)) {
                goto mom;
            }
            $tb["\145\155\x61\x69\154\x4b\145\171"] = $form["\151\144\x65\x6e\x74\x69\x66\151\x65\162"];
            mom:
            if (!(strcasecmp($form["\145\154\x65\x6d\x65\x6e\164\x44\145\146\141\165\154\x74\x73"]["\155\x61\x69\x6e\137\154\x61\142\145\x6c"], $pO["\x66\x6f\x72\x6d\143\162\141\146\x74\x5f\x66\157\x72\155"]["\160\150\157\x6e\x65\x6b\x65\x79"][$Zm]) === 0)) {
                goto aFa;
            }
            $tb["\x70\150\157\x6e\145\x4b\x65\171"] = $form["\x69\144\145\156\x74\151\146\151\145\162"];
            aFa:
            if (!(strcasecmp($form["\x65\154\145\155\145\x6e\164\x44\145\146\141\165\154\x74\x73"]["\x6d\141\x69\x6e\137\154\141\142\145\x6c"], $pO["\146\x6f\x72\x6d\x63\x72\x61\146\164\x5f\146\157\162\x6d"]["\x76\x65\162\151\146\x79\x4b\145\171"][$Zm]) === 0)) {
                goto sP5;
            }
            $tb["\166\145\162\x69\146\171\113\x65\171"] = $form["\x69\x64\x65\x6e\x74\151\x66\151\x65\x72"];
            sP5:
            Ydh:
        }
        A1R:
        return $tb;
    }
    function getFormCraftFormDataFromID($D5)
    {
        global $wpdb, $forms_table;
        $pp = $wpdb->get_var("\123\x45\x4c\105\x43\x54\40\155\145\x74\141\137\142\x75\151\x6c\x64\x65\162\40\106\x52\117\x4d\x20{$forms_table}\x20\x57\x48\105\x52\x45\40\151\144\75{$D5}");
        $pp = json_decode(stripcslashes($pp), 1);
        return $pp["\146\151\145\154\144\x73"];
    }
}
