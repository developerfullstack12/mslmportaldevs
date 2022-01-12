<?php


namespace OTP\Objects;

use OTP\Helper\FormList;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
class FormHandler
{
    protected $_typePhoneTag;
    protected $_typeEmailTag;
    protected $_typeBothTag;
    protected $_formKey;
    protected $_formName;
    protected $_otpType;
    protected $_phoneFormId;
    protected $_isFormEnabled;
    protected $_restrictDuplicates;
    protected $_byPassLogin;
    protected $_isLoginOrSocialForm;
    protected $_isAjaxForm;
    protected $_phoneKey;
    protected $_emailKey;
    protected $_buttonText;
    protected $_formDetails;
    protected $_disableAutoActivate;
    protected $_formSessionVar;
    protected $_formSessionVar2;
    protected $_nonce = "\x66\x6f\x72\155\137\x6e\x6f\156\143\145";
    protected $_txSessionId = FormSessionVars::TX_SESSION_ID;
    protected $_formOption = "\155\157\x5f\143\165\x73\x74\x6f\155\145\x72\137\x76\x61\154\x69\144\x61\x74\x69\157\x6e\137\x73\145\x74\x74\151\156\147\x73";
    protected $_generateOTPAction;
    protected $_validateOTPAction;
    protected $_nonceKey = "\x73\145\x63\165\x72\151\164\x79";
    protected $_isAddOnForm = FALSE;
    protected $_formDocuments = array();
    const VALIDATED = "\x56\x41\x4c\x49\x44\x41\124\105\x44";
    const VERIFICATION_FAILED = "\166\x65\162\x69\146\151\x63\x61\164\x69\x6f\156\137\146\141\x69\x6c\x65\144";
    const VALIDATION_CHECKED = "\x76\x61\154\x69\144\x61\x74\x69\x6f\156\x43\150\x65\143\x6b\x65\144";
    protected function __construct()
    {
        add_action("\141\x64\155\151\156\137\151\156\151\164", array($this, "\150\141\x6e\144\154\145\x46\157\x72\x6d\117\160\164\x69\157\x6e\163"), 2);
        if (!(!MoUtility::micr() || !$this->isFormEnabled())) {
            goto tC;
        }
        return;
        tC:
        add_action("\x69\156\x69\164", array($this, "\150\x61\156\x64\154\x65\x46\157\162\155"), 1);
        add_filter("\155\157\137\160\x68\x6f\156\x65\x5f\x64\x72\x6f\160\x64\x6f\x77\156\x5f\163\145\154\x65\x63\164\x6f\x72", array($this, "\147\x65\x74\x50\x68\157\156\145\116\x75\155\142\x65\x72\123\x65\154\145\143\164\x6f\x72"), 1, 1);
        if (!(SessionUtils::isOTPInitialized($this->_formSessionVar) || SessionUtils::isOTPInitialized($this->_formSessionVar2))) {
            goto MZ;
        }
        add_action("\x6f\164\160\137\166\145\162\x69\146\151\143\141\x74\x69\x6f\x6e\137\163\x75\143\x63\x65\x73\163\x66\165\x6c", array($this, "\150\141\x6e\144\154\x65\x5f\x70\157\163\x74\137\166\x65\162\151\146\x69\x63\141\x74\151\157\156"), 1, 7);
        add_action("\x6f\x74\160\x5f\166\x65\162\x69\x66\x69\x63\x61\164\x69\x6f\156\137\146\141\151\x6c\x65\144", array($this, "\150\x61\156\144\x6c\x65\137\146\141\x69\x6c\145\x64\137\x76\x65\x72\x69\146\151\x63\x61\x74\151\x6f\156"), 1, 4);
        add_action("\x75\156\163\x65\x74\x5f\163\145\x73\x73\x69\x6f\156\137\x76\141\162\151\x61\142\x6c\145", array($this, "\x75\x6e\163\x65\x74\117\x54\x50\x53\145\x73\163\x69\x6f\x6e\126\x61\162\151\141\x62\x6c\145\163"), 1, 0);
        MZ:
        add_filter("\x69\x73\137\141\152\x61\x78\x5f\146\157\x72\155", array($this, "\151\163\x5f\141\152\x61\x78\x5f\x66\157\162\155\137\x69\156\x5f\x70\x6c\x61\x79"), 1, 1);
        add_filter("\151\x73\x5f\154\x6f\147\151\x6e\137\157\x72\x5f\163\x6f\143\x69\141\154\137\146\157\x72\155", array($this, "\151\163\114\157\147\x69\156\x4f\x72\x53\157\143\151\141\154\x46\157\162\155"), 1, 1);
        $ri = FormList::instance();
        $ri->add($this->getFormKey(), $this);
    }
    public function isLoginOrSocialForm($Hd)
    {
        return SessionUtils::isOTPInitialized($this->_formSessionVar) ? $this->getisLoginOrSocialForm() : $Hd;
    }
    public function is_ajax_form_in_play($WB)
    {
        return SessionUtils::isOTPInitialized($this->_formSessionVar) ? $this->_isAjaxForm : $WB;
    }
    public function sanitizeFormPOST($TR, $Qh = null)
    {
        $TR = ($Qh === null ? "\x6d\157\x5f\x63\165\x73\x74\x6f\155\x65\162\137\166\141\x6c\x69\144\141\x74\x69\x6f\x6e\x5f" : '') . $TR;
        return MoUtility::sanitizeCheck($TR, $_POST);
    }
    public function sendChallenge($wB, $CG, $errors, $J9 = null, $rI = "\x65\x6d\141\x69\154", $hs = '', $tA = null, $Wj = false)
    {
        do_action("\x6d\x6f\137\x67\x65\156\x65\162\x61\x74\145\137\x6f\164\160", $wB, $CG, $errors, $J9, $rI, $hs, $tA, $Wj);
    }
    public function validateChallenge($lr, $Co = "\x6d\x6f\x5f\x6f\164\x70\x5f\164\157\153\x65\x6e", $V7 = NULL)
    {
        do_action("\x6d\x6f\137\166\x61\154\151\144\x61\164\145\137\157\164\160", $lr, $Co, $V7);
    }
    public function basicValidationCheck($SF)
    {
        if (!($this->isFormEnabled() && MoUtility::isBlank($this->_otpType))) {
            goto Gp;
        }
        do_action("\x6d\x6f\x5f\162\145\147\x69\163\x74\x72\141\164\x69\x6f\156\137\x73\150\x6f\x77\x5f\155\145\163\x73\x61\x67\x65", MoMessages::showMessage($SF), MoConstants::ERROR);
        return false;
        Gp:
        return true;
    }
    public function getVerificationType()
    {
        $TT = array($this->_typePhoneTag => VerificationType::PHONE, $this->_typeEmailTag => VerificationType::EMAIL, $this->_typeBothTag => VerificationType::BOTH);
        return MoUtility::isBlank($this->_otpType) ? false : $TT[$this->_otpType];
    }
    protected function validateAjaxRequest()
    {
        if (check_ajax_referer($this->_nonce, $this->_nonceKey)) {
            goto PP;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(BaseMessages::INVALID_OP), MoConstants::ERROR_JSON_TYPE));
        die;
        PP:
    }
    protected function ajaxProcessingFields()
    {
        $TT = array($this->_typePhoneTag => array(VerificationType::PHONE), $this->_typeEmailTag => array(VerificationType::EMAIL), $this->_typeBothTag => array(VerificationType::PHONE, VerificationType::EMAIL));
        return $TT[$this->_otpType];
    }
    public function getPhoneHTMLTag()
    {
        return $this->_typePhoneTag;
    }
    public function getEmailHTMLTag()
    {
        return $this->_typeEmailTag;
    }
    public function getBothHTMLTag()
    {
        return $this->_typeBothTag;
    }
    public function getFormKey()
    {
        return $this->_formKey;
    }
    public function getFormName()
    {
        return $this->_formName;
    }
    public function getOtpTypeEnabled()
    {
        return $this->_otpType;
    }
    public function disableAutoActivation()
    {
        return $this->_disableAutoActivate;
    }
    public function getPhoneKeyDetails()
    {
        return $this->_phoneKey;
    }
    public function getEmailKeyDetails()
    {
        return $this->_emailKey;
    }
    public function isFormEnabled()
    {
        return $this->_isFormEnabled;
    }
    public function getButtonText()
    {
        return mo_($this->_buttonText);
    }
    public function getFormDetails()
    {
        return $this->_formDetails;
    }
    public function restrictDuplicates()
    {
        return $this->_restrictDuplicates;
    }
    public function bypassForLoggedInUsers()
    {
        return $this->_byPassLogin;
    }
    public function getisLoginOrSocialForm()
    {
        return (bool) $this->_isLoginOrSocialForm;
    }
    public function getFormOption()
    {
        return $this->_formOption;
    }
    public function isAjaxForm()
    {
        return $this->_isAjaxForm;
    }
    public function isAddOnForm()
    {
        return $this->_isAddOnForm;
    }
    public function getFormDocuments()
    {
        return $this->_formDocuments;
    }
}
