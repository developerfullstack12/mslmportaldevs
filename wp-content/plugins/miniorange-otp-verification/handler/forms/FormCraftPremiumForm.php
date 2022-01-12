<?php


namespace OTP\Handler\Forms;

use mysql_xdevapi\Session;
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
class FormCraftPremiumForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORMCRAFT;
        $this->_typePhoneTag = "\155\157\137\146\x6f\162\155\x63\162\141\x66\164\137\x70\150\157\x6e\x65\137\x65\x6e\x61\142\x6c\145";
        $this->_typeEmailTag = "\155\x6f\x5f\x66\x6f\x72\x6d\x63\162\141\x66\x74\137\x65\155\141\x69\154\137\145\x6e\x61\x62\x6c\145";
        $this->_formKey = "\106\117\122\115\103\122\101\106\x54\x50\122\105\115\x49\125\115";
        $this->_formName = mo_("\106\157\162\x6d\103\162\141\x66\164\x20\50\120\x72\x65\155\151\x75\x6d\x20\126\145\x72\163\151\157\x6e\51");
        $this->_isFormEnabled = get_mo_option("\x66\143\160\162\145\155\x69\165\x6d\x5f\145\156\141\x62\x6c\145");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::FORMCRAFT_PREMIUM;
        parent::__construct();
    }
    function handleForm()
    {
        if (MoUtility::getActivePluginVersion("\106\157\x72\155\x43\162\141\x66\164")) {
            goto Xq;
        }
        return;
        Xq:
        $this->_otpType = get_mo_option("\x66\x63\160\162\145\x6d\151\x75\x6d\x5f\x65\x6e\x61\x62\x6c\x65\137\x74\171\160\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\x66\x63\x70\162\145\x6d\x69\165\x6d\137\157\x74\x70\x5f\145\156\141\142\x6c\145\x64"));
        if (!empty($this->_formDetails)) {
            goto v7;
        }
        return;
        v7:
        if ($this->isFormCraftVersion3Installed()) {
            goto EW;
        }
        foreach ($this->_formDetails as $Zm => $zs) {
            array_push($this->_phoneFormId, "\56\156\146\x6f\x72\x6d\x5f\x6c\x69\x20\151\x6e\160\x75\164\133\156\141\x6d\x65\x5e\75" . $zs["\x70\150\157\156\x65\153\x65\171"] . "\135");
            Zv:
        }
        FP:
        goto eg;
        EW:
        foreach ($this->_formDetails as $Zm => $zs) {
            array_push($this->_phoneFormId, "\151\x6e\x70\165\164\133\156\x61\x6d\145\136\75" . $zs["\160\150\x6f\x6e\145\x6b\145\171"] . "\x5d");
            FA:
        }
        sy:
        eg:
        add_action("\x77\x70\x5f\x61\152\141\x78\137\x66\x6f\x72\x6d\x63\x72\141\146\x74\137\163\x75\142\x6d\151\164", array($this, "\166\141\154\x69\144\x61\x74\145\x5f\x66\157\162\155\143\x72\141\146\164\137\146\157\162\x6d\x5f\x73\165\x62\155\151\164"), 1);
        add_action("\x77\160\x5f\141\x6a\x61\x78\137\156\x6f\x70\x72\151\x76\137\x66\157\x72\x6d\143\x72\x61\x66\164\x5f\163\165\x62\155\151\x74", array($this, "\166\x61\154\x69\x64\141\164\145\137\146\x6f\162\155\143\x72\x61\146\x74\137\146\x6f\162\x6d\137\x73\x75\x62\155\x69\164"), 1);
        add_action("\x77\160\x5f\141\152\x61\170\137\146\x6f\x72\155\x63\x72\141\146\164\63\x5f\x66\157\x72\155\137\163\165\x62\x6d\151\x74", array($this, "\x76\141\154\x69\144\141\x74\x65\x5f\146\157\162\x6d\x63\162\141\x66\x74\x5f\x66\157\162\x6d\x5f\163\x75\x62\x6d\x69\164"), 1);
        add_action("\167\160\x5f\141\x6a\141\x78\x5f\x6e\x6f\160\162\151\166\x5f\146\x6f\x72\155\x63\x72\141\146\164\63\x5f\x66\157\x72\155\137\x73\165\142\x6d\x69\164", array($this, "\x76\x61\154\x69\x64\141\164\x65\x5f\146\x6f\162\155\x63\162\x61\146\x74\137\146\157\x72\x6d\x5f\x73\165\x62\x6d\151\x74"), 1);
        add_action("\167\x70\137\x65\x6e\x71\x75\145\x75\x65\x5f\163\143\162\151\x70\x74\163", array($this, "\145\156\161\x75\145\165\145\137\x73\143\x72\151\160\164\137\x6f\156\137\160\141\x67\x65"));
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\x70\164\x69\157\x6e", $_GET)) {
            goto ls;
        }
        return;
        ls:
        switch (trim($_GET["\157\x70\x74\151\x6f\156"])) {
            case "\155\x69\x6e\151\x6f\x72\141\x6e\147\x65\x2d\x66\x6f\162\x6d\x63\x72\x61\x66\x74\160\162\x65\155\x69\165\x6d\x2d\x76\x65\162\151\x66\x79":
                $this->_handle_formcraft_form($_POST);
                goto KJ;
            case "\x6d\x69\156\x69\157\162\x61\x6e\147\x65\x2d\x66\157\x72\x6d\143\x72\x61\146\164\x70\162\145\155\151\x75\x6d\x2d\146\157\162\x6d\55\x6f\x74\160\55\x65\156\141\x62\x6c\145\x64":
                wp_send_json($this->isVerificationEnabledForThisForm($_POST["\146\x6f\x72\x6d\x5f\x69\144"]));
                goto KJ;
        }
        bV:
        KJ:
    }
    function _handle_formcraft_form($pO)
    {
        if ($this->isVerificationEnabledForThisForm($_POST["\146\x6f\x72\155\137\x69\144"])) {
            goto EE;
        }
        return;
        EE:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto YW;
        }
        $this->_send_otp_to_email($pO);
        goto ix;
        YW:
        $this->_send_otp_to_phone($pO);
        ix:
    }
    function _send_otp_to_phone($pO)
    {
        if (array_key_exists("\x75\x73\145\x72\x5f\x70\x68\157\156\x65", $pO) && !MoUtility::isBlank($pO["\x75\x73\x65\162\137\x70\150\157\x6e\145"])) {
            goto KN;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto Rh;
        KN:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $pO["\165\163\x65\162\x5f\x70\x68\x6f\156\x65"]);
        $this->sendChallenge("\164\145\163\164", '', null, trim($pO["\x75\x73\x65\x72\x5f\160\150\157\156\x65"]), VerificationType::PHONE);
        Rh:
    }
    function _send_otp_to_email($pO)
    {
        if (array_key_exists("\165\x73\145\162\x5f\145\155\x61\151\x6c", $pO) && !MoUtility::isBlank($pO["\165\163\x65\162\137\x65\155\x61\151\x6c"])) {
            goto D7;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto q9;
        D7:
        SessionUtils::addEmailVerified($this->_formSessionVar, $pO["\x75\163\145\x72\137\x65\155\141\151\x6c"]);
        $this->sendChallenge("\x74\145\163\164", $pO["\x75\x73\145\162\x5f\145\155\x61\151\x6c"], null, $pO["\x75\x73\145\162\137\x65\155\x61\x69\154"], VerificationType::EMAIL);
        q9:
    }
    function validate_formcraft_form_submit()
    {
        $D5 = $_POST["\x69\144"];
        if ($this->isVerificationEnabledForThisForm($D5)) {
            goto N1;
        }
        return;
        N1:
        $VJ = $this->parseSubmittedData($_POST, $D5);
        $this->checkIfVerificationNotStarted($VJ);
        $fk = is_array($VJ["\160\150\x6f\x6e\x65"]["\x76\x61\154\165\x65"]) ? $VJ["\160\150\157\x6e\145"]["\166\x61\x6c\165\x65"][0] : $VJ["\160\150\157\156\x65"]["\x76\x61\x6c\165\x65"];
        $h4 = is_array($VJ["\145\x6d\x61\x69\154"]["\x76\x61\154\165\x65"]) ? $VJ["\x65\155\x61\x69\x6c"]["\x76\141\x6c\165\145"][0] : $VJ["\x65\155\x61\151\154"]["\x76\141\x6c\165\x65"];
        $lo = is_array($VJ["\x6f\x74\160"]["\166\x61\154\x75\x65"]) ? $VJ["\x6f\164\160"]["\x76\x61\x6c\165\x65"][0] : $VJ["\157\164\x70"]["\166\x61\x6c\x75\x65"];
        $lr = $this->getVerificationType();
        if ($lr === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $fk)) {
            goto Af;
        }
        if ($lr === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $h4)) {
            goto qL;
        }
        goto Ue;
        Af:
        $this->sendJSONErrorMessage(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), $VJ["\160\150\157\156\145"]["\x66\x69\145\154\144"]);
        goto Ue;
        qL:
        $this->sendJSONErrorMessage(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), $VJ["\x65\155\141\151\x6c"]["\x66\x69\145\x6c\144"]);
        Ue:
        if (!MoUtility::isBlank($VJ["\x6f\164\x70"]["\x76\x61\x6c\165\x65"])) {
            goto dM;
        }
        $this->sendJSONErrorMessage(MoUtility::_get_invalid_otp_method(), $VJ["\x6f\x74\160"]["\x66\151\145\x6c\x64"]);
        dM:
        SessionUtils::setFormOrFieldId($this->_formSessionVar, $VJ["\x6f\x74\160"]["\146\x69\x65\154\x64"]);
        $this->validateChallenge($lr, NULL, $lo);
    }
    function enqueue_script_on_page()
    {
        wp_register_script("\146\x63\160\162\145\x6d\151\165\155\x73\143\162\151\160\164", MOV_URL . "\x69\x6e\x63\154\x75\144\145\x73\x2f\152\163\x2f\x66\x6f\162\155\x63\x72\141\x66\164\160\162\x65\155\151\165\155\56\x6d\x69\156\x2e\x6a\x73\x3f\x76\x65\162\163\151\157\x6e\x3d" . MOV_VERSION, array("\x6a\x71\x75\145\162\x79"));
        wp_localize_script("\x66\143\x70\162\145\x6d\151\x75\155\x73\143\x72\x69\160\164", "\x6d\x6f\146\143\160\x76\x61\162\163", array("\151\155\x67\125\x52\x4c" => MOV_LOADER_URL, "\146\157\x72\x6d\103\x72\141\x66\x74\106\x6f\x72\x6d\x73" => $this->_formDetails, "\x73\151\x74\145\x55\122\114" => site_url(), "\157\x74\x70\124\171\160\145" => $this->_otpType, "\142\165\x74\164\x6f\156\x54\x65\x78\164" => mo_("\x43\x6c\151\x63\x6b\x20\150\145\x72\145\x20\164\157\x20\x73\145\x6e\144\x20\117\x54\x50"), "\142\x75\x74\x74\x6f\156\124\151\164\x6c\145" => $this->_otpType == $this->_typePhoneTag ? mo_("\120\154\x65\141\163\145\40\x65\156\x74\145\162\40\x61\40\x50\150\157\x6e\145\40\116\165\x6d\142\x65\162\x20\x74\157\40\x65\156\141\142\154\x65\x20\x74\x68\151\163\x20\x66\151\x65\x6c\x64\x2e") : mo_("\x50\154\145\x61\163\145\40\x65\156\164\145\162\x20\141\x20\120\150\x6f\x6e\145\40\116\x75\x6d\x62\x65\162\40\x74\157\40\145\156\x61\x62\154\x65\40\x74\150\x69\163\x20\146\x69\145\154\x64\56"), "\141\152\x61\170\x75\x72\154" => wp_ajax_url(), "\x74\171\160\x65\x50\150\x6f\x6e\x65" => $this->_typePhoneTag, "\x63\157\165\x6e\164\162\x79\104\162\x6f\x70" => get_mo_option("\x73\x68\157\167\137\x64\162\157\160\x64\x6f\x77\156\x5f\157\156\137\x66\157\x72\x6d"), "\x76\x65\x72\163\151\157\x6e\63" => $this->isFormCraftVersion3Installed()));
        wp_enqueue_script("\x66\143\160\162\x65\x6d\x69\165\155\x73\x63\x72\x69\x70\164");
    }
    function parseSubmittedData($post, $D5)
    {
        $pO = array();
        $form = $this->_formDetails[$D5];
        foreach ($post as $Zm => $zs) {
            if (!(strpos($Zm, "\x66\151\x65\x6c\144") === FALSE)) {
                goto ZN;
            }
            goto Kw;
            ZN:
            $this->getValueAndFieldFromPost($pO, "\x65\x6d\x61\151\x6c", $Zm, str_replace("\40", "\137", $form["\x65\x6d\141\x69\154\153\145\171"]), $zs);
            $this->getValueAndFieldFromPost($pO, "\160\150\157\156\x65", $Zm, str_replace("\x20", "\x5f", $form["\160\150\x6f\156\145\153\145\x79"]), $zs);
            $this->getValueAndFieldFromPost($pO, "\157\164\160", $Zm, str_replace("\x20", "\137", $form["\x76\145\x72\x69\146\171\x4b\x65\x79"]), $zs);
            Kw:
        }
        ml:
        return $pO;
    }
    function getValueAndFieldFromPost(&$pO, $r_, $zK, $DS, $zs)
    {
        if (!(is_null($pO[$r_]) && strpos($zK, $DS, 0) !== FALSE)) {
            goto KF;
        }
        $pO[$r_]["\166\x61\154\x75\x65"] = $this->isFormCraftVersion3Installed() && $r_ == "\x6f\x74\160" ? $zs[0] : $zs;
        $tp = strpos($zK, "\146\151\145\x6c\144", 0);
        $pO[$r_]["\x66\151\145\154\x64"] = $this->isFormCraftVersion3Installed() ? $zK : substr($zK, $tp, strpos($zK, "\137", $tp) - $tp);
        KF:
    }
    function isVerificationEnabledForThisForm($D5)
    {
        return array_key_exists($D5, $this->_formDetails);
    }
    function sendJSONErrorMessage($errors, $Pj)
    {
        if ($this->isFormCraftVersion3Installed()) {
            goto BE;
        }
        $Re["\145\x72\x72\157\x72\x73"] = mo_("\120\x6c\x65\x61\163\x65\40\x63\x6f\162\162\145\143\x74\40\x74\150\x65\40\x65\x72\162\x6f\x72\163\x20\141\x6e\144\x20\164\162\171\x20\x61\x67\x61\151\156");
        $Re[$Pj][0] = $errors;
        goto jd;
        BE:
        $Re["\146\x61\151\x6c\x65\x64"] = mo_("\x50\x6c\145\141\x73\x65\40\143\x6f\162\162\x65\143\x74\40\x74\x68\145\x20\x65\x72\162\157\x72\163\40\x61\156\144\x20\x74\x72\171\x20\x61\x67\x61\x69\x6e");
        $Re["\x65\162\162\x6f\162\x73"][$Pj] = $errors;
        jd:
        echo json_encode($Re);
        die;
    }
    function checkIfVerificationNotStarted($VJ)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto X4;
        }
        return;
        X4:
        if ($this->_otpType == $this->_typePhoneTag) {
            goto VO;
        }
        $this->sendJSONErrorMessage(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), $VJ["\x65\155\x61\151\154"]["\146\x69\145\154\x64"]);
        goto Kg;
        VO:
        $this->sendJSONErrorMessage(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), $VJ["\x70\x68\157\x6e\x65"]["\x66\151\145\x6c\x64"]);
        Kg:
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto hf;
        }
        return;
        hf:
        $Ua = SessionUtils::getFormOrFieldId($this->_formSessionVar);
        $this->sendJSONErrorMessage(MoUtility::_get_invalid_otp_method(), $Ua);
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
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto bv;
        }
        $zX = array_merge($zX, $this->_phoneFormId);
        bv:
        return $zX;
    }
    function getFieldId($pO, $VJ)
    {
        foreach ($VJ as $form) {
            if (!($form["\145\x6c\x65\x6d\x65\x6e\164\104\x65\146\x61\x75\154\x74\x73"]["\155\141\151\x6e\137\154\x61\142\145\154"] == $pO)) {
                goto Dg;
            }
            return $form["\x69\x64\145\x6e\x74\x69\x66\151\145\162"];
            Dg:
            Gz:
        }
        E1:
        return NULL;
    }
    function getFormCraftFormDataFromID($D5)
    {
        global $wpdb, $xs;
        $pp = $wpdb->get_var("\x53\x45\114\x45\x43\x54\40\155\145\x74\x61\137\x62\165\x69\154\144\145\162\x20\x46\122\117\115\40{$xs}\x20\127\110\x45\122\x45\40\x69\x64\x3d{$D5}");
        $pp = json_decode(stripcslashes($pp), 1);
        return $pp["\146\151\145\154\x64\163"];
    }
    function isFormCraftVersion3Installed()
    {
        return MoUtility::getActivePluginVersion("\106\157\x72\155\x43\162\141\146\164") == 3 ? true : false;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto XL;
        }
        return;
        XL:
        if (MoUtility::getActivePluginVersion("\x46\x6f\162\155\x43\162\x61\x66\x74")) {
            goto XG;
        }
        return;
        XG:
        $form = array();
        foreach (array_filter($_POST["\146\x63\160\x72\x65\x6d\151\x75\x6d\x5f\x66\157\x72\x6d"]["\146\x6f\x72\155"]) as $Zm => $zs) {
            !$this->isFormCraftVersion3Installed() ? $this->processAndGetFormData($_POST, $Zm, $zs, $form) : $this->processAndGetForm3Data($_POST, $Zm, $zs, $form);
            RF:
        }
        sB:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x66\143\x70\162\145\x6d\x69\x75\155\137\145\x6e\x61\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\146\x63\160\162\x65\x6d\151\165\155\x5f\145\x6e\141\142\154\x65\137\x74\171\160\145");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\x66\143\160\162\x65\155\151\165\155\x5f\145\x6e\x61\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\146\x63\160\x72\145\155\151\x75\155\137\145\x6e\x61\x62\x6c\x65\137\x74\171\x70\x65", $this->_otpType);
        update_mo_option("\x66\143\x70\162\145\x6d\151\165\155\x5f\157\x74\x70\x5f\x65\156\x61\x62\154\x65\144", maybe_serialize($this->_formDetails));
    }
    function processAndGetFormData($post, $Zm, $zs, &$form)
    {
        $form[$zs] = array("\x65\x6d\x61\151\x6c\x6b\145\171" => str_replace("\40", "\x20", $post["\146\x63\160\x72\x65\x6d\151\x75\155\x5f\x66\157\x72\155"]["\145\x6d\141\151\x6c\153\145\171"][$Zm]) . "\x5f\145\155\x61\x69\154\x5f\x65\155\141\x69\154\137", "\x70\x68\157\156\145\x6b\145\171" => str_replace("\x20", "\40", $post["\x66\143\160\162\x65\155\151\165\x6d\x5f\146\x6f\x72\155"]["\x70\150\157\156\145\x6b\x65\171"][$Zm]) . "\137\164\x65\x78\164\137", "\166\145\162\151\146\171\113\x65\x79" => str_replace("\x20", "\x20", $post["\146\143\x70\x72\x65\155\151\165\x6d\x5f\x66\157\x72\x6d"]["\x76\145\x72\151\x66\x79\x4b\x65\171"][$Zm]) . "\x5f\164\x65\x78\x74\137", "\160\150\157\x6e\x65\137\163\150\x6f\x77" => $post["\x66\143\160\x72\145\x6d\x69\x75\x6d\137\146\157\162\x6d"]["\x70\x68\x6f\156\x65\x6b\145\x79"][$Zm], "\145\155\x61\151\154\137\163\150\x6f\x77" => $post["\146\143\x70\x72\145\x6d\x69\165\155\x5f\146\157\x72\x6d"]["\145\155\x61\151\154\x6b\145\171"][$Zm], "\x76\x65\x72\151\x66\171\137\163\x68\157\167" => $post["\146\x63\160\162\145\x6d\151\x75\155\137\x66\157\x72\x6d"]["\x76\145\x72\x69\x66\171\x4b\145\171"][$Zm]);
    }
    function processAndGetForm3Data($post, $Zm, $zs, &$form)
    {
        $VJ = $this->getFormCraftFormDataFromID($zs);
        if (!MoUtility::isBlank($VJ)) {
            goto U8;
        }
        return;
        U8:
        $form[$zs] = array("\145\155\141\x69\x6c\x6b\145\171" => $this->getFieldId($post["\x66\143\160\162\145\x6d\x69\x75\155\137\146\x6f\162\155"]["\x65\155\x61\151\x6c\x6b\x65\171"][$Zm], $VJ), "\x70\x68\157\156\145\153\145\171" => $this->getFieldId($post["\146\x63\160\x72\x65\x6d\151\x75\155\x5f\146\x6f\162\x6d"]["\x70\150\x6f\x6e\145\x6b\x65\171"][$Zm], $VJ), "\x76\x65\162\151\146\171\113\x65\171" => $this->getFieldId($post["\x66\x63\x70\162\x65\x6d\151\x75\155\x5f\x66\x6f\162\155"]["\166\x65\162\x69\x66\x79\113\145\x79"][$Zm], $VJ), "\160\x68\x6f\x6e\145\x5f\x73\150\157\167" => $post["\x66\x63\x70\x72\145\x6d\151\165\x6d\137\x66\157\162\x6d"]["\x70\150\157\x6e\x65\x6b\x65\x79"][$Zm], "\x65\155\141\x69\x6c\137\163\x68\x6f\167" => $post["\146\143\160\162\x65\155\151\x75\x6d\x5f\x66\157\x72\155"]["\x65\x6d\x61\x69\154\153\x65\x79"][$Zm], "\x76\x65\162\x69\146\x79\x5f\163\150\x6f\x77" => $post["\146\x63\160\162\145\x6d\151\x75\x6d\137\146\x6f\x72\155"]["\x76\145\x72\x69\146\171\x4b\x65\x79"][$Zm]);
    }
}
