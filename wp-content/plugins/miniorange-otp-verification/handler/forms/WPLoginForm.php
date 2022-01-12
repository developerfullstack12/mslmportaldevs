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
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
use WP_User;
class WPLoginForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_savePhoneNumbers;
    private $_byPassAdmin;
    private $_allowLoginThroughPhone;
    private $_skipPasswordCheck;
    private $_userLabel;
    private $_delayOtp;
    private $_delayOtpInterval;
    private $_skipPassFallback;
    private $_createUserAction;
    private $_timeStampMetaKey = "\155\157\166\137\154\141\x73\x74\137\x76\145\x72\x69\146\151\x65\144\x5f\144\164\x74\155";
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = TRUE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WP_LOGIN_REG_PHONE;
        $this->_formSessionVar2 = FormSessionVars::WP_DEFAULT_LOGIN;
        $this->_phoneFormId = "\x23\155\x6f\137\160\150\x6f\156\x65\137\x6e\165\155\x62\145\162";
        $this->_typePhoneTag = "\155\x6f\x5f\167\160\137\x6c\x6f\147\x69\156\x5f\160\150\157\156\145\137\145\x6e\x61\142\154\x65";
        $this->_typeEmailTag = "\155\157\137\x77\160\x5f\154\x6f\x67\151\x6e\137\145\155\141\151\x6c\137\145\x6e\x61\x62\x6c\x65";
        $this->_formKey = "\x57\x50\x5f\x44\x45\x46\x41\x55\x4c\x54\137\x4c\x4f\x47\111\x4e";
        $this->_formName = mo_("\127\x6f\x72\x64\120\x72\145\163\x73\x20\57\40\x57\157\x6f\x43\x6f\x6d\155\x65\x72\143\x65\40\x2f\40\125\x6c\x74\151\x6d\141\x74\x65\x20\x4d\x65\155\142\145\x72\x20\x4c\157\x67\151\x6e\x20\x46\157\162\x6d");
        $this->_isFormEnabled = get_mo_option("\167\x70\137\x6c\x6f\147\x69\156\x5f\145\156\141\142\154\145");
        $this->_userLabel = get_mo_option("\167\160\x5f\x75\x73\x65\162\x6e\141\155\145\x5f\154\x61\x62\x65\x6c\137\164\145\170\164");
        $this->_userLabel = $this->_userLabel ? mo_($this->_userLabel) : mo_("\x55\163\x65\162\x6e\x61\155\145\54\x20\x45\x2d\155\x61\x69\154\40\157\x72\40\x50\x68\157\x6e\145\x20\116\157\56");
        $this->_skipPasswordCheck = get_mo_option("\x77\x70\x5f\154\x6f\x67\151\156\x5f\x73\153\151\160\x5f\160\x61\x73\163\167\x6f\x72\144");
        $this->_allowLoginThroughPhone = get_mo_option("\x77\160\x5f\154\x6f\147\x69\156\x5f\141\154\x6c\x6f\167\137\160\x68\157\156\x65\137\154\x6f\147\x69\156");
        $this->_skipPassFallback = get_mo_option("\x77\160\x5f\154\x6f\147\x69\156\137\163\153\151\x70\137\x70\141\163\163\167\x6f\162\x64\x5f\x66\x61\154\154\x62\x61\x63\153");
        $this->_delayOtp = get_mo_option("\x77\x70\137\154\x6f\147\151\x6e\137\x64\x65\154\x61\x79\x5f\157\164\160");
        $this->_delayOtpInterval = get_mo_option("\167\x70\x5f\x6c\x6f\x67\151\x6e\137\144\145\154\x61\171\137\x6f\x74\160\137\x69\x6e\164\145\x72\166\x61\x6c");
        $this->_delayOtpInterval = $this->_delayOtpInterval ? $this->_delayOtpInterval : 43800;
        $this->_formDocuments = MoOTPDocs::LOGIN_FORM;
        if (!($this->_skipPasswordCheck || $this->_allowLoginThroughPhone)) {
            goto zO;
        }
        add_action("\154\157\147\151\156\137\x65\156\161\165\145\165\x65\137\x73\143\162\x69\x70\164\x73", array($this, "\x6d\151\156\151\x6f\162\141\x6e\x67\145\137\162\145\x67\x69\163\x74\145\162\137\x6c\x6f\x67\x69\156\x5f\163\143\x72\151\160\164"));
        add_action("\167\x70\x5f\145\x6e\x71\x75\x65\x75\x65\137\x73\x63\x72\x69\160\164\163", array($this, "\155\151\156\151\157\162\141\156\147\145\x5f\x72\145\x67\151\x73\x74\145\x72\137\x6c\157\147\151\156\137\163\x63\x72\x69\x70\164"));
        zO:
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\167\160\137\x6c\157\147\151\x6e\x5f\145\x6e\141\x62\154\x65\137\164\x79\x70\145");
        $this->_phoneKey = get_mo_option("\167\160\x5f\x6c\x6f\x67\x69\x6e\137\153\145\171");
        $this->_savePhoneNumbers = get_mo_option("\167\160\x5f\x6c\157\147\151\x6e\137\162\145\x67\151\x73\164\x65\x72\137\x70\x68\x6f\x6e\x65");
        $this->_byPassAdmin = get_mo_option("\x77\x70\137\x6c\157\147\x69\x6e\137\142\171\x70\141\x73\x73\137\141\x64\155\151\x6e");
        $this->_restrictDuplicates = get_mo_option("\167\160\x5f\154\x6f\x67\x69\156\x5f\162\x65\x73\164\x72\151\x63\x74\137\144\165\160\x6c\151\x63\141\x74\145\x73");
        add_filter("\x61\x75\164\x68\x65\156\x74\x69\x63\x61\164\x65", array($this, "\x5f\x68\x61\156\x64\154\145\x5f\x6d\x6f\137\167\x70\137\154\x6f\x67\x69\x6e"), 99, 3);
        add_action("\167\160\137\x61\x6a\x61\170\137\x6d\157\x2d\141\144\155\151\x6e\x2d\143\150\145\x63\153", array($this, "\151\163\101\144\x6d\x69\x6e"));
        add_action("\x77\160\137\141\152\141\170\137\156\157\160\162\x69\166\x5f\x6d\x6f\x2d\141\x64\x6d\151\x6e\55\143\150\x65\x63\153", array($this, "\x69\x73\101\x64\x6d\x69\156"));
        if (!class_exists("\x55\115")) {
            goto tO;
        }
        add_filter("\x77\160\x5f\141\165\x74\x68\145\156\164\151\x63\141\x74\x65\x5f\x75\x73\145\x72", array($this, "\x5f\x67\x65\164\x5f\x61\x6e\x64\x5f\x72\145\x74\165\x72\156\137\x75\x73\145\162"), 99, 2);
        tO:
        $this->routeData();
    }
    function isAdmin()
    {
        $HR = MoUtility::sanitizeCheck("\x75\x73\x65\x72\156\141\x6d\145", $_POST);
        $user = is_email($HR) ? get_user_by("\145\155\141\151\x6c", $HR) : get_user_by("\x6c\x6f\x67\x69\156", $HR);
        $Zj = MoConstants::SUCCESS_JSON_TYPE;
        $Zj = $user ? in_array("\141\144\x6d\151\x6e\151\163\164\x72\141\164\x6f\x72", $user->roles) ? $Zj : "\145\x72\x72\157\162" : "\145\162\x72\x6f\162";
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_EXISTS), $Zj));
    }
    function routeData()
    {
        if (array_key_exists("\157\x70\x74\x69\x6f\156", $_REQUEST)) {
            goto L7;
        }
        return;
        L7:
        switch (trim($_REQUEST["\x6f\x70\x74\x69\x6f\x6e"])) {
            case "\x6d\x69\156\x69\x6f\162\141\156\147\x65\x2d\141\x6a\141\170\55\157\x74\x70\55\x67\145\156\145\x72\141\x74\145":
                $this->_handle_wp_login_ajax_send_otp();
                goto qv;
            case "\155\x69\156\151\157\x72\x61\156\147\x65\55\141\152\x61\x78\x2d\x6f\x74\x70\55\166\141\154\151\x64\x61\x74\145":
                $this->_handle_wp_login_ajax_form_validate_action();
                goto qv;
            case "\x6d\157\x5f\141\x6a\141\x78\x5f\x66\x6f\162\x6d\137\166\141\154\x69\x64\141\x74\145":
                $this->_handle_wp_login_create_user_action();
                goto qv;
        }
        Oy:
        qv:
    }
    function miniorange_register_login_script()
    {
        wp_register_script("\155\x6f\x6c\157\x67\x69\x6e", MOV_URL . "\x69\156\143\x6c\x75\144\x65\163\57\152\163\x2f\x6c\x6f\x67\151\x6e\146\157\x72\155\56\x6d\x69\x6e\56\152\x73", array("\152\161\x75\x65\x72\x79"));
        wp_localize_script("\x6d\x6f\x6c\157\147\151\x6e", "\x6d\x6f\x76\x61\162\x6c\157\147\151\156", array("\x75\163\145\162\x4c\141\142\x65\154" => $this->_allowLoginThroughPhone ? $this->_userLabel : null, "\163\153\151\160\x50\167\144\x43\150\x65\x63\x6b" => $this->_skipPasswordCheck, "\163\153\151\160\120\167\144\106\141\154\154\142\141\x63\x6b" => $this->_skipPassFallback, "\x62\165\164\164\157\x6e\x74\145\x78\164" => mo_("\x4c\157\x67\x69\156\40\x77\151\164\150\40\x4f\x54\120"), "\151\163\x41\144\x6d\151\x6e\x41\143\164\x69\157\156" => "\x6d\x6f\55\x61\x64\x6d\x69\156\55\143\150\x65\x63\153", "\x62\x79\120\141\163\163\x41\x64\x6d\151\x6e" => $this->_byPassAdmin, "\x73\151\x74\145\125\122\114" => wp_ajax_url()));
        wp_enqueue_script("\x6d\x6f\x6c\157\x67\151\x6e");
    }
    function _get_and_return_user($HR, $hs)
    {
        if (!is_object($HR)) {
            goto Os;
        }
        return $HR;
        Os:
        $user = $this->getUser($HR, $hs);
        if (!is_wp_error($user)) {
            goto Gb;
        }
        return $user;
        Gb:
        UM()->login()->auth_id = $user->data->ID;
        UM()->form()->errors = null;
        return $user;
    }
    function byPassLogin($user, $aB)
    {
        $w7 = get_userdata($user->data->ID);
        $co = $w7->roles;
        return in_array("\141\x64\155\x69\156\151\163\x74\x72\141\x74\x6f\162", $co) && $this->_byPassAdmin || $aB || $this->delayOTPProcess($user->data->ID);
    }
    function _handle_wp_login_create_user_action()
    {
        $Ou = function ($AA) {
            $HR = MoUtility::sanitizeCheck("\154\157\147", $AA);
            if ($HR) {
                goto tz;
            }
            $HN = array_filter($AA, function ($Zm) {
                return strpos($Zm, "\x75\x73\145\162\156\x61\155\x65") === 0;
            }, ARRAY_FILTER_USE_KEY);
            $HR = !empty($HN) ? array_shift($HN) : $HR;
            tz:
            return is_email($HR) ? get_user_by("\x65\155\x61\151\x6c", $HR) : get_user_by("\154\x6f\x67\151\x6e", $HR);
        };
        $AA = $_POST;
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto LQ;
        }
        return;
        LQ:
        $user = $Ou($AA);
        update_user_meta($user->data->ID, $this->_phoneKey, $this->check_phone_length($AA["\x6d\x6f\137\160\150\x6f\x6e\145\x5f\x6e\x75\x6d\142\x65\x72"]));
        $this->login_wp_user($user->data->user_login);
    }
    function login_wp_user($zF, $tA = null)
    {
        $user = is_email($zF) ? get_user_by("\x65\155\x61\x69\x6c", $zF) : ($this->allowLoginThroughPhone() && MoUtility::validatePhoneNumber($zF) ? $this->getUserFromPhoneNumber(MoUtility::processPhoneNumber($zF)) : get_user_by("\154\x6f\147\151\156", $zF));
        wp_set_auth_cookie($user->data->ID);
        if (!($this->_delayOtp && $this->_delayOtpInterval > 0)) {
            goto aI;
        }
        update_user_meta($user->data->ID, $this->_timeStampMetaKey, time());
        aI:
        $this->unsetOTPSessionVariables();
        do_action("\167\x70\x5f\154\x6f\147\151\x6e", $user->user_login, $user);
        $nT = MoUtility::isBlank($tA) ? site_url() : $tA;
        wp_redirect($nT);
        die;
    }
    function _handle_mo_wp_login($user, $HR, $hs)
    {
        if (MoUtility::isBlank($HR)) {
            goto aY;
        }
        $aB = $this->skipOTPProcess($hs);
        $user = $this->getUser($HR, $hs);
        if (!is_wp_error($user)) {
            goto RQ;
        }
        return $user;
        RQ:
        if (!$this->byPassLogin($user, $aB)) {
            goto Vt;
        }
        return $user;
        Vt:
        $this->startOTPVerificationProcess($user, $HR, $hs);
        aY:
        return $user;
    }
    function startOTPVerificationProcess($user, $HR, $hs)
    {
        $lr = $this->getVerificationType();
        if (!(SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $lr) || SessionUtils::isStatusMatch($this->_formSessionVar2, self::VALIDATED, $lr))) {
            goto iR;
        }
        return;
        iR:
        if ($lr === VerificationType::PHONE) {
            goto X6;
        }
        if (!($lr === VerificationType::EMAIL)) {
            goto Ec;
        }
        $h4 = $user->data->user_email;
        $this->startEmailVerification($HR, $h4);
        Ec:
        goto iV;
        X6:
        $J9 = get_user_meta($user->data->ID, $this->_phoneKey, true);
        $J9 = $this->check_phone_length($J9);
        $this->askPhoneAndStartVerification($user, $this->_phoneKey, $HR, $J9);
        $this->fetchPhoneAndStartVerification($HR, $hs, $J9);
        iV:
    }
    function getUser($HR, $hs = null)
    {
        $user = is_email($HR) ? get_user_by("\x65\x6d\x61\x69\x6c", $HR) : get_user_by("\x6c\x6f\147\151\156", $HR);
        if (!($this->_allowLoginThroughPhone && MoUtility::validatePhoneNumber($HR))) {
            goto tg;
        }
        $HR = MoUtility::processPhoneNumber($HR);
        $user = $this->getUserFromPhoneNumber($HR);
        tg:
        if (!($user && !$this->isLoginWithOTP($user->roles))) {
            goto cx;
        }
        $user = wp_authenticate_username_password(NULL, $user->data->user_login, $hs);
        cx:
        return $user ? $user : new WP_Error("\111\x4e\126\101\114\x49\x44\137\x55\x53\105\122\116\101\x4d\105", mo_("\40\x3c\x62\x3e\x45\x52\x52\117\x52\x3a\74\x2f\142\76\x20\x49\x6e\x76\141\x6c\151\x64\x20\x55\x73\145\x72\x4e\141\x6d\145\x2e\x20"));
    }
    function getUserFromPhoneNumber($HR)
    {
        global $wpdb;
        $h8 = $wpdb->get_row("\123\x45\114\105\x43\x54\40\140\x75\163\x65\162\x5f\x69\x64\140\x20\106\x52\117\x4d\x20\140{$wpdb->prefix}\x75\x73\145\x72\x6d\145\x74\x61\x60" . "\127\110\105\122\x45\40\140\155\x65\x74\141\137\153\145\x79\140\x20\x3d\40\47{$this->_phoneKey}\47\40\101\x4e\104\x20\x60\155\145\x74\x61\137\166\x61\x6c\x75\145\x60\x20\75\40\40\47{$HR}\x27");
        return !MoUtility::isBlank($h8) ? get_userdata($h8->user_id) : false;
    }
    function askPhoneAndStartVerification($user, $Zm, $HR, $J9)
    {
        if (MoUtility::isBlank($J9)) {
            goto jM;
        }
        return;
        jM:
        if (!$this->savePhoneNumbers()) {
            goto kI;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->sendChallenge(NULL, $user->data->user_login, NULL, NULL, "\145\x78\164\145\162\x6e\x61\x6c", NULL, array("\144\x61\164\141" => array("\x75\x73\145\x72\137\154\x6f\x67\151\x6e" => $HR), "\155\x65\x73\x73\x61\147\x65" => MoMessages::showMessage(MoMessages::REGISTER_PHONE_LOGIN), "\x66\x6f\x72\x6d" => $Zm, "\143\x75\162\154" => MoUtility::currentPageUrl()));
        goto Ov;
        kI:
        miniorange_site_otp_validation_form(null, null, null, MoMessages::showMessage(MoMessages::PHONE_NOT_FOUND), null, null);
        Ov:
    }
    function fetchPhoneAndStartVerification($HR, $hs, $J9)
    {
        MoUtility::initialize_transaction($this->_formSessionVar2);
        $u8 = isset($_REQUEST["\162\145\x64\x69\x72\x65\143\x74\137\164\x6f"]) ? $_REQUEST["\162\145\x64\151\162\x65\x63\x74\x5f\164\157"] : MoUtility::currentPageUrl();
        $this->sendChallenge($HR, null, null, $J9, VerificationType::PHONE, $hs, $u8, false);
    }
    function startEmailVerification($HR, $h4)
    {
        MoUtility::initialize_transaction($this->_formSessionVar2);
        $this->sendChallenge($HR, $h4, null, null, VerificationType::EMAIL);
    }
    function _handle_wp_login_ajax_send_otp()
    {
        $pO = $_POST;
        if ($this->restrictDuplicates() && !MoUtility::isBlank($this->getUserFromPhoneNumber($pO["\165\163\x65\x72\x5f\160\x68\x6f\156\x65"]))) {
            goto NC;
        }
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Wk;
        }
        goto eL;
        NC:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_EXISTS), MoConstants::ERROR_JSON_TYPE));
        goto eL;
        Wk:
        $this->sendChallenge("\x61\152\141\x78\x5f\x70\150\157\x6e\x65", '', null, trim($pO["\165\x73\145\162\137\x70\150\x6f\156\x65"]), VerificationType::PHONE, null, $pO);
        eL:
    }
    function _handle_wp_login_ajax_form_validate_action()
    {
        $pO = $_POST;
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto cL;
        }
        return;
        cL:
        $fk = MoPHPSessions::getSessionVar("\160\150\x6f\x6e\145\137\156\165\x6d\142\145\x72\137\x6d\x6f");
        if (strcmp($fk, $this->check_phone_length($pO["\165\x73\x65\162\137\x70\x68\x6f\156\145"]))) {
            goto nk;
        }
        $this->validateChallenge($this->getVerificationType());
        goto sv;
        nk:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        sv:
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto pw;
        }
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $lr);
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
        pw:
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar2)) {
            goto m4;
        }
        miniorange_site_otp_validation_form($wB, $CG, $J9, MoUtility::_get_invalid_otp_method(), "\x70\x68\157\x6e\x65", FALSE);
        m4:
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto vj;
        }
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $lr);
        wp_send_json(MoUtility::createJson('', MoConstants::SUCCESS_JSON_TYPE));
        vj:
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar2)) {
            goto m0;
        }
        $HR = MoUtility::isBlank($wB) ? MoUtility::sanitizeCheck("\154\x6f\x67", $_POST) : $wB;
        $HR = MoUtility::isBlank($HR) ? MoUtility::sanitizeCheck("\x75\163\x65\x72\x6e\x61\x6d\x65", $_POST) : $HR;
        $this->login_wp_user($HR, $tA);
        m0:
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar, $this->_formSessionVar2));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!$this->isFormEnabled()) {
            goto IR;
        }
        array_push($zX, $this->_phoneFormId);
        IR:
        return $zX;
    }
    private function isLoginWithOTP($cW = array())
    {
        $j_ = mo_("\x4c\157\147\x69\156\40\167\151\164\150\40\x4f\x54\x50");
        if (!(in_array("\141\x64\155\x69\156\x69\163\164\162\141\164\157\x72", $cW) && $this->_byPassAdmin)) {
            goto a0;
        }
        return false;
        a0:
        return MoUtility::sanitizeCheck("\167\x70\55\163\x75\x62\x6d\x69\x74", $_POST) == $j_ || MoUtility::sanitizeCheck("\x6c\x6f\147\151\156", $_POST) == $j_ || MoUtility::sanitizeCheck("\154\157\x67\x69\156\x74\x79\x70\x65", $_POST) == $j_;
    }
    private function skipOTPProcess($hs)
    {
        return $this->_skipPasswordCheck && $this->_skipPassFallback && isset($hs) && !$this->isLoginWithOTP();
    }
    private function check_phone_length($fk)
    {
        $NL = MoUtility::processPhoneNumber($fk);
        return strlen($NL) >= 5 ? $NL : '';
    }
    private function delayOTPProcess($ZS)
    {
        if (!($this->_delayOtp && $this->_delayOtpInterval < 0)) {
            goto uI;
        }
        return TRUE;
        uI:
        $cz = get_user_meta($ZS, $this->_timeStampMetaKey, true);
        if (!MoUtility::isBlank($cz)) {
            goto QT;
        }
        return FALSE;
        QT:
        $eL = time() - $cz;
        return $this->_delayOtp && $eL < $this->_delayOtpInterval * 60;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto pv;
        }
        return;
        pv:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\160\x5f\154\157\x67\151\156\x5f\145\156\141\x62\154\x65");
        $this->_savePhoneNumbers = $this->sanitizeFormPOST("\x77\x70\137\x6c\x6f\147\151\156\x5f\162\145\x67\x69\163\x74\145\162\x5f\x70\150\157\156\x65");
        $this->_byPassAdmin = $this->sanitizeFormPOST("\x77\160\x5f\154\x6f\147\x69\156\137\142\171\x70\x61\x73\163\x5f\x61\144\x6d\x69\x6e");
        $this->_phoneKey = $this->sanitizeFormPOST("\x77\x70\x5f\154\x6f\147\x69\156\x5f\x70\150\x6f\156\145\137\x66\x69\x65\x6c\144\137\x6b\x65\171");
        $this->_allowLoginThroughPhone = $this->sanitizeFormPOST("\x77\x70\137\x6c\x6f\x67\151\x6e\x5f\x61\154\x6c\157\167\137\160\x68\157\156\145\x5f\x6c\x6f\x67\x69\156");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\167\160\137\154\157\x67\151\156\x5f\162\145\x73\x74\162\151\143\x74\x5f\x64\165\x70\x6c\151\143\x61\164\x65\x73");
        $this->_otpType = $this->sanitizeFormPOST("\x77\160\137\154\x6f\x67\151\156\137\x65\x6e\x61\142\x6c\x65\137\164\x79\160\x65");
        $this->_skipPasswordCheck = $this->sanitizeFormPOST("\x77\160\137\154\x6f\x67\151\156\x5f\x73\x6b\151\160\x5f\x70\141\x73\163\167\157\x72\x64");
        $this->_userLabel = $this->sanitizeFormPOST("\x77\x70\137\165\163\145\162\x6e\x61\155\145\x5f\x6c\141\142\x65\x6c\137\164\x65\x78\164");
        $this->_skipPassFallback = $this->sanitizeFormPOST("\x77\x70\x5f\x6c\x6f\147\151\x6e\x5f\163\153\x69\x70\x5f\x70\141\163\x73\x77\x6f\162\x64\137\146\x61\154\154\x62\141\143\153");
        $this->_delayOtp = $this->sanitizeFormPOST("\x77\x70\x5f\154\x6f\147\x69\x6e\137\x64\145\x6c\141\x79\137\x6f\x74\x70");
        $this->_delayOtpInterval = $this->sanitizeFormPOST("\167\160\137\x6c\x6f\147\151\156\x5f\x64\145\x6c\141\171\137\157\164\160\x5f\x69\156\x74\145\162\166\141\x6c");
        update_mo_option("\x77\160\137\x6c\x6f\147\x69\156\x5f\145\156\x61\x62\154\145\x5f\164\171\160\145", $this->_otpType);
        update_mo_option("\x77\x70\137\154\157\x67\x69\156\137\145\156\141\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\167\160\137\x6c\157\147\x69\156\137\162\x65\x67\x69\163\x74\x65\x72\x5f\160\150\157\x6e\x65", $this->_savePhoneNumbers);
        update_mo_option("\167\160\x5f\x6c\157\147\x69\x6e\x5f\x62\171\160\x61\163\x73\x5f\x61\144\155\151\x6e", $this->_byPassAdmin);
        update_mo_option("\x77\x70\x5f\154\x6f\x67\151\x6e\137\153\x65\x79", $this->_phoneKey);
        update_mo_option("\x77\x70\137\x6c\157\x67\151\156\x5f\141\154\154\157\x77\x5f\x70\150\157\156\145\137\154\157\x67\151\x6e", $this->_allowLoginThroughPhone);
        update_mo_option("\x77\160\137\x6c\157\x67\x69\x6e\137\162\145\x73\164\x72\x69\x63\x74\x5f\144\x75\160\154\x69\x63\x61\164\x65\x73", $this->_restrictDuplicates);
        update_mo_option("\x77\160\137\x6c\x6f\147\x69\156\137\163\153\x69\160\x5f\160\x61\x73\x73\167\x6f\x72\x64", $this->_skipPasswordCheck && $this->_isFormEnabled);
        update_mo_option("\x77\160\137\x6c\x6f\147\x69\x6e\x5f\163\x6b\151\x70\x5f\x70\x61\163\x73\x77\x6f\162\144\x5f\146\141\x6c\154\x62\141\x63\153", $this->_skipPassFallback);
        update_mo_option("\167\x70\137\x75\163\145\162\x6e\x61\x6d\x65\137\x6c\141\x62\145\154\137\164\x65\x78\x74", $this->_userLabel);
        update_mo_option("\x77\160\137\x6c\x6f\147\151\156\x5f\x64\x65\154\141\171\x5f\157\164\x70", $this->_delayOtp && $this->_isFormEnabled);
        update_mo_option("\x77\x70\137\x6c\157\x67\151\156\x5f\x64\145\x6c\x61\x79\137\x6f\x74\160\137\x69\x6e\x74\145\162\166\141\x6c", $this->_delayOtpInterval);
    }
    public function savePhoneNumbers()
    {
        return $this->_savePhoneNumbers;
    }
    function byPassCheckForAdmins()
    {
        return $this->_byPassAdmin;
    }
    function allowLoginThroughPhone()
    {
        return $this->_allowLoginThroughPhone;
    }
    public function getSkipPasswordCheck()
    {
        return $this->_skipPasswordCheck;
    }
    public function getUserLabel()
    {
        return mo_($this->_userLabel);
    }
    public function getSkipPasswordCheckFallback()
    {
        return $this->_skipPassFallback;
    }
    public function isDelayOtp()
    {
        return $this->_delayOtp;
    }
    public function getDelayOtpInterval()
    {
        return $this->_delayOtpInterval;
    }
}
