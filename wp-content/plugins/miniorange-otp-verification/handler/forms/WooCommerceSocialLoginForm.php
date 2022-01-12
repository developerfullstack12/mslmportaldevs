<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Traits\Instance;
use ReflectionException;
use WC_Emails;
use WC_Social_Login_Provider_Profile;
class WooCommerceSocialLoginForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_oAuthProviders = array("\146\x61\x63\145\x62\x6f\157\153", "\164\x77\x69\164\x74\145\162", "\147\x6f\x6f\147\x6c\145", "\x61\155\x61\x7a\157\x6e", "\x6c\x69\x6e\x6b\145\144\111\156", "\x70\x61\x79\160\141\154", "\151\x6e\163\164\x61\147\162\x61\x6d", "\x64\151\163\x71\165\x73", "\171\141\x68\157\x6f", "\166\x6b");
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = TRUE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WC_SOCIAL_LOGIN;
        $this->_otpType = "\160\150\157\156\x65";
        $this->_phoneFormId = "\43\x6d\x6f\x5f\x70\x68\x6f\156\x65\x5f\156\x75\155\x62\145\162";
        $this->_formKey = "\127\x43\x5f\x53\117\103\x49\101\114\137\x4c\x4f\x47\x49\116";
        $this->_formName = mo_("\x57\x6f\x6f\x63\157\155\155\145\162\143\145\40\123\x6f\x63\x69\141\x6c\40\x4c\x6f\147\151\x6e\x20\74\151\76\50\x20\123\115\x53\40\x56\145\162\151\146\151\143\x61\164\151\x6f\x6e\x20\x4f\x6e\x6c\171\x20\x29\74\x2f\151\x3e");
        $this->_isFormEnabled = get_mo_option("\x77\143\x5f\163\x6f\143\x69\141\x6c\x5f\x6c\157\147\151\156\137\145\x6e\x61\142\154\145");
        $this->_formDocuments = MoOTPDocs::WC_SOCIAL_LOGIN;
        parent::__construct();
    }
    function handleForm()
    {
        $this->includeRequiredFiles();
        foreach ($this->_oAuthProviders as $gn) {
            add_filter("\x77\143\x5f\x73\157\x63\x69\141\154\x5f\x6c\157\147\x69\x6e\137" . $gn . "\137\160\162\x6f\x66\x69\x6c\x65", array($this, "\x6d\157\x5f\x77\x63\137\x73\x6f\x63\151\141\154\x5f\154\x6f\x67\x69\x6e\x5f\160\162\157\146\151\154\x65"), 99, 2);
            add_filter("\167\x63\x5f\x73\x6f\x63\151\141\x6c\137\x6c\157\147\x69\x6e\137" . $gn . "\137\x6e\145\167\x5f\165\x73\x65\x72\x5f\x64\141\164\141", array($this, "\x6d\x6f\x5f\x77\143\137\163\x6f\x63\x69\141\x6c\137\x6c\x6f\147\x69\x6e"), 99, 2);
            bs:
        }
        LS:
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\x70\164\x69\x6f\x6e", $_REQUEST)) {
            goto mX;
        }
        return;
        mX:
        switch (trim($_REQUEST["\157\x70\x74\x69\x6f\x6e"])) {
            case "\155\x69\x6e\151\x6f\x72\141\156\x67\145\x2d\x61\x6a\141\170\x2d\x6f\164\x70\55\x67\x65\156\x65\x72\x61\164\145":
                $this->_handle_wc_ajax_send_otp($_POST);
                goto aP;
            case "\x6d\x69\x6e\151\x6f\x72\141\x6e\x67\x65\55\141\152\x61\170\55\x6f\164\x70\55\166\x61\154\x69\x64\141\164\x65":
                $this->processOTPEntered($_REQUEST);
                goto aP;
            case "\x6d\x6f\137\141\x6a\141\170\137\x66\157\162\155\x5f\166\x61\154\151\144\x61\164\145":
                $this->_handle_wc_create_user_action($_POST);
                goto aP;
        }
        I2:
        aP:
    }
    function includeRequiredFiles()
    {
        if (function_exists("\151\x73\x5f\160\154\x75\147\151\156\x5f\141\x63\x74\x69\x76\145")) {
            goto Xy;
        }
        include_once ABSPATH . "\x77\x70\55\141\144\x6d\x69\x6e\x2f\x69\x6e\x63\154\165\144\145\x73\x2f\160\x6c\x75\x67\x69\x6e\x2e\x70\x68\x70";
        Xy:
        if (!is_plugin_active("\x77\x6f\157\x63\157\155\x6d\145\162\x63\145\55\163\x6f\x63\x69\141\154\55\x6c\157\147\151\x6e\57\167\x6f\157\143\157\155\x6d\145\x72\x63\145\55\x73\x6f\143\151\141\x6c\x2d\154\x6f\x67\151\x6e\x2e\160\x68\x70")) {
            goto hH;
        }
        require_once plugin_dir_path(MOV_DIR) . "\x77\x6f\x6f\x63\157\x6d\x6d\x65\x72\143\145\55\163\157\143\151\x61\x6c\x2d\154\x6f\x67\x69\x6e\x2f\x69\x6e\143\154\165\144\145\x73\57\x63\154\141\163\163\x2d\x77\143\x2d\163\157\x63\x69\141\154\x2d\x6c\157\147\x69\156\x2d\160\162\157\166\x69\x64\145\162\55\x70\162\157\146\x69\x6c\x65\x2e\x70\150\160";
        hH:
    }
    function mo_wc_social_login_profile($ke, $az)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        MoPHPSessions::addSessionVar("\167\x63\137\160\162\x6f\166\x69\144\x65\162", $ke);
        $_SESSION["\x77\x63\137\160\162\x6f\166\x69\144\x65\162\137\x69\144"] = maybe_serialize($az);
        return $ke;
    }
    function mo_wc_social_login($N9, $ke)
    {
        $this->sendChallenge(NULL, $N9["\x75\163\145\x72\x5f\145\x6d\x61\151\x6c"], NULL, NULL, "\145\170\x74\x65\162\x6e\141\154", NULL, array("\144\141\x74\x61" => $N9, "\x6d\145\163\x73\141\x67\145" => MoMessages::showMessage(MoMessages::PHONE_VALIDATION_MSG), "\x66\x6f\162\155" => "\x57\103\x5f\x53\117\x43\x49\x41\114", "\x63\x75\x72\154" => MoUtility::currentPageUrl()));
    }
    function _handle_wc_create_user_action($AA)
    {
        if (!(!$this->checkIfVerificationNotStarted() && SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType()))) {
            goto F2;
        }
        $this->create_new_wc_social_customer($AA);
        F2:
    }
    function create_new_wc_social_customer($AC)
    {
        require_once plugin_dir_path(MOV_DIR) . "\167\157\157\x63\157\x6d\155\145\x72\143\x65\x2f\151\x6e\x63\x6c\x75\144\x65\x73\57\143\154\x61\163\163\55\x77\x63\x2d\x65\x6d\x61\151\154\x73\x2e\160\150\x70";
        WC_Emails::init_transactional_emails();
        $GL = MoPHPSessions::getSessionVar("\167\x63\137\160\x72\157\x76\151\144\145\162");
        $az = maybe_unserialize($_SESSION["\167\143\x5f\x70\x72\x6f\x76\151\x64\x65\x72\137\151\144"]);
        $this->unsetOTPSessionVariables();
        $ke = new WC_Social_Login_Provider_Profile($az, $GL);
        $fk = $AC["\x6d\x6f\x5f\160\150\157\x6e\145\137\x6e\x75\x6d\x62\x65\162"];
        $AC = array("\x72\157\x6c\x65" => "\143\165\x73\164\x6f\155\x65\x72", "\x75\163\x65\x72\137\x6c\x6f\x67\x69\x6e" => $ke->has_email() ? sanitize_email($ke->get_email()) : $ke->get_nickname(), "\165\x73\x65\x72\x5f\145\155\x61\x69\x6c" => $ke->get_email(), "\x75\163\145\x72\137\160\x61\x73\163" => wp_generate_password(), "\x66\151\x72\163\x74\137\x6e\x61\155\145" => $ke->get_first_name(), "\154\x61\x73\164\x5f\x6e\141\x6d\145" => $ke->get_last_name());
        if (!empty($AC["\165\x73\145\x72\137\154\x6f\x67\151\156"])) {
            goto AO;
        }
        $AC["\165\x73\x65\162\x5f\154\x6f\x67\151\156"] = $AC["\146\x69\x72\x73\164\137\x6e\x61\155\145"] . $AC["\154\141\x73\164\x5f\156\141\x6d\145"];
        AO:
        $yP = 1;
        $Ta = $AC["\x75\163\145\x72\137\x6c\157\147\151\x6e"];
        Zu:
        if (!username_exists($AC["\165\163\145\x72\x5f\154\157\147\x69\x6e"])) {
            goto u7;
        }
        $AC["\x75\x73\x65\x72\x5f\x6c\x6f\x67\151\x6e"] = $Ta . $yP;
        $yP++;
        goto Zu;
        u7:
        $yx = wp_insert_user($AC);
        update_user_meta($yx, "\x62\151\154\x6c\151\x6e\147\137\160\150\157\156\x65", MoUtility::processPhoneNumber($fk));
        update_user_meta($yx, "\164\145\154\x65\x70\x68\157\x6e\x65", MoUtility::processPhoneNumber($fk));
        do_action("\x77\157\x6f\143\157\155\155\x65\162\x63\145\x5f\143\162\145\141\x74\145\144\x5f\143\165\163\x74\x6f\155\x65\x72", $yx, $AC, false);
        $user = get_user_by("\151\144", $yx);
        $ke->update_customer_profile($user->ID, $user);
        if (!($SF = apply_filters("\167\x63\x5f\x73\157\x63\151\141\x6c\137\x6c\x6f\x67\x69\156\137\163\x65\164\x5f\141\x75\x74\x68\x5f\x63\157\x6f\x6b\x69\145", '', $user))) {
            goto xI;
        }
        wc_add_notice($SF, "\x6e\x6f\x74\x69\143\x65");
        goto bY;
        xI:
        wc_set_customer_auth_cookie($user->ID);
        update_user_meta($user->ID, "\x5f\167\x63\137\x73\x6f\x63\x69\141\x6c\x5f\x6c\x6f\x67\151\x6e\x5f" . $ke->get_provider_id() . "\x5f\154\157\x67\151\x6e\137\x74\151\155\145\x73\164\141\155\x70", current_time("\x74\151\155\x65\163\x74\141\155\x70"));
        update_user_meta($user->ID, "\137\x77\143\137\163\157\x63\x69\141\154\137\154\x6f\147\151\x6e\137" . $ke->get_provider_id() . "\137\154\157\147\151\156\137\x74\x69\155\x65\x73\x74\141\155\160\137\147\155\164", time());
        do_action("\167\143\x5f\x73\157\143\x69\x61\154\x5f\154\x6f\x67\151\x6e\x5f\165\163\145\x72\x5f\x61\165\x74\150\145\x6e\x74\x69\143\141\x74\145\144", $user->ID, $ke->get_provider_id());
        bY:
        if (is_wp_error($yx)) {
            goto QG;
        }
        $this->redirect(null, $yx);
        goto pd;
        QG:
        $this->redirect("\145\162\x72\157\162", 0, $yx->get_error_code());
        pd:
    }
    function redirect($QH = null, $ZS = 0, $Ck = "\167\143\x2d\x73\157\143\x69\141\x6c\x2d\154\x6f\147\151\x6e\x2d\x65\x72\x72\157\x72")
    {
        $user = get_user_by("\x69\x64", $ZS);
        if (MoUtility::isBlank($user->user_email)) {
            goto uP;
        }
        $Xe = get_transient("\x77\143\163\154\x5f" . md5($_SERVER["\122\105\x4d\x4f\124\105\x5f\x41\104\x44\x52"] . $_SERVER["\x48\124\x54\120\137\x55\123\x45\x52\137\x41\x47\105\x4e\124"]));
        $Xe = $Xe ? esc_url(urldecode($Xe)) : wc_get_page_permalink("\155\x79\141\x63\x63\x6f\x75\156\164");
        delete_transient("\x77\143\163\x6c\137" . md5($_SERVER["\x52\105\x4d\x4f\124\105\137\x41\x44\x44\x52"] . $_SERVER["\110\124\x54\120\x5f\x55\x53\x45\122\x5f\101\x47\105\x4e\124"]));
        goto CS;
        uP:
        $Xe = add_query_arg("\x77\x63\x2d\x73\157\143\151\141\x6c\55\x6c\157\147\x69\x6e\x2d\x6d\x69\x73\x73\151\156\x67\x2d\145\x6d\x61\x69\154", "\x74\x72\165\x65", wc_customer_edit_account_url());
        CS:
        if (!("\x65\x72\162\157\162" === $QH)) {
            goto xA;
        }
        $Xe = add_query_arg($Ck, "\164\x72\x75\145", $Xe);
        xA:
        wp_safe_redirect(esc_url_raw($Xe));
        die;
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $lr);
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS, MoConstants::SUCCESS_JSON_TYPE));
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    function _handle_wc_ajax_send_otp($pO)
    {
        if ($this->checkIfVerificationNotStarted()) {
            goto il;
        }
        $this->sendChallenge("\x61\x6a\141\x78\x5f\x70\150\157\156\145", '', null, trim($pO["\165\163\145\x72\137\160\150\x6f\x6e\x65"]), $this->_otpType, null, $pO);
        il:
    }
    function processOTPEntered($pO)
    {
        if (!$this->checkIfVerificationNotStarted()) {
            goto U_;
        }
        return;
        U_:
        if ($this->processPhoneNumber($pO)) {
            goto Gk;
        }
        $this->validateChallenge($this->getVerificationType());
        goto D2;
        Gk:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        D2:
    }
    function processPhoneNumber($pO)
    {
        $fk = MoPHPSessions::getSessionVar("\x70\x68\157\x6e\145\x5f\x6e\x75\155\x62\145\x72\x5f\155\x6f");
        return strcmp($fk, MoUtility::processPhoneNumber($pO["\165\163\x65\x72\137\160\x68\157\x6e\x65"])) != 0;
    }
    function checkIfVerificationNotStarted()
    {
        return !SessionUtils::isOTPInitialized($this->_formSessionVar);
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!$this->isFormEnabled()) {
            goto yt;
        }
        array_push($zX, $this->_phoneFormId);
        yt:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto X7;
        }
        return;
        X7:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\143\x5f\x73\x6f\x63\151\141\x6c\137\x6c\x6f\x67\x69\x6e\137\145\x6e\141\x62\x6c\x65");
        update_mo_option("\x77\x63\137\x73\x6f\x63\x69\x61\154\x5f\x6c\157\x67\151\156\x5f\x65\x6e\141\x62\x6c\x65", $this->_isFormEnabled);
    }
}
