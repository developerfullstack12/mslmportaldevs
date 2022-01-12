<?php


namespace OTP\Addons\CustomMessage\Handler;

use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\BaseAddOnHandler;
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoOTPDocs;
class CustomMessages extends BaseAddOnHandler
{
    use Instance;
    public $_adminActions = array("\x6d\x6f\137\x63\165\x73\x74\x6f\155\145\x72\137\x76\x61\154\x69\x64\141\x74\x69\x6f\156\137\141\x64\x6d\x69\x6e\137\143\165\163\164\x6f\x6d\x5f\160\150\157\x6e\x65\x5f\x6e\x6f\164\151\146" => "\x5f\155\x6f\137\x76\141\x6c\x69\144\141\x74\151\157\156\137\163\145\156\x64\x5f\163\x6d\163\137\156\x6f\x74\151\146\x5f\x6d\163\147", "\155\157\x5f\x63\x75\163\x74\x6f\x6d\x65\x72\137\x76\141\x6c\151\144\x61\x74\151\x6f\x6e\137\x61\144\155\151\156\x5f\x63\x75\163\164\x6f\x6d\x5f\145\x6d\141\x69\154\137\156\x6f\164\x69\x66" => "\x5f\x6d\x6f\137\x76\141\154\151\x64\x61\164\x69\157\x6e\x5f\x73\145\156\144\137\145\x6d\141\151\154\x5f\156\x6f\164\x69\146\137\155\163\x67");
    function __construct()
    {
        parent::__construct();
        $this->_nonce = "\155\157\x5f\141\144\x6d\151\156\137\141\143\x74\x69\x6f\x6e\163";
        if ($this->moAddOnV()) {
            goto AN;
        }
        return;
        AN:
        $this->_addonSessionVar = "\143\x75\x73\x74\157\x6d\x5f\155\145\x73\163\141\x67\x65\x5f\x61\x64\x64\x6f\156";
        $this->send_admin_notification();
        foreach ($this->_adminActions as $R6 => $tz) {
            add_action("\x77\x70\x5f\x61\x6a\141\170\137{$R6}", array($this, $tz));
            add_action("\141\144\x6d\x69\x6e\137\160\x6f\163\164\x5f{$R6}", array($this, $tz));
            ca:
        }
        Rc:
    }
    public function send_admin_notification()
    {
        if (!MoPHPSessions::getSessionVar($this->_addonSessionVar)) {
            goto Id;
        }
        MoPHPSessions::getSessionVar($this->_addonSessionVar)["\x72\x65\x73\x75\x6c\164"] == MoConstants::SUCCESS_JSON_TYPE ? do_action("\155\157\x5f\x72\145\147\x69\x73\164\x72\x61\164\151\157\x6e\137\163\150\157\x77\137\x6d\x65\163\163\x61\x67\145", MoPHPSessions::getSessionVar($this->_addonSessionVar)["\155\x65\x73\x73\141\x67\x65"], MoConstants::CUSTOM_MESSAGE_ADDON_SUCCESS) : do_action("\x6d\x6f\137\x72\145\x67\x69\163\x74\x72\x61\x74\x69\x6f\156\x5f\x73\150\x6f\167\137\155\x65\x73\x73\x61\147\145", MoPHPSessions::getSessionVar($this->_addonSessionVar)["\155\145\x73\163\141\147\145"], MoConstants::CUSTOM_MESSAGE_ADDON_ERROR);
        $this->unsetSessionVariables();
        Id:
    }
    public function unsetSessionVariables()
    {
        MoPHPSessions::unsetSession($this->_addonSessionVar);
    }
    public function _mo_validation_send_sms_notif_msg()
    {
        $hj = MoUtility::sanitizeCheck("\x61\x6a\141\170\137\x6d\x6f\144\145", $_POST);
        $hj ? $this->isValidAjaxRequest("\163\x65\x63\x75\x72\151\164\x79") : $this->isValidRequest();
        $Hb = explode("\73", $_POST["\155\x6f\137\x70\150\x6f\x6e\145\x5f\x6e\165\x6d\142\145\162\x73"]);
        $SF = $_POST["\x6d\x6f\137\143\165\x73\x74\x6f\x6d\x65\162\x5f\166\x61\x6c\151\144\x61\x74\151\157\x6e\x5f\x63\165\163\x74\x6f\x6d\x5f\163\155\x73\x5f\x6d\163\147"];
        $SC = null;
        foreach ($Hb as $fk) {
            $SC = MoUtility::send_phone_notif($fk, $SF);
            zN:
        }
        eP:
        $hj ? $this->checkStatusAndSendJSON($SC) : $this->checkStatusAndShowMessage($SC);
    }
    public function _mo_validation_send_email_notif_msg()
    {
        $hj = MoUtility::sanitizeCheck("\x61\x6a\141\x78\x5f\x6d\x6f\x64\145", $_POST);
        $hj ? $this->isValidAjaxRequest("\x73\145\x63\165\x72\x69\164\171") : $this->isValidRequest();
        $Ax = explode("\73", $_POST["\164\x6f\x45\155\141\x69\154"]);
        $SC = null;
        foreach ($Ax as $h4) {
            $SC = MoUtility::send_email_notif($_POST["\x66\x72\157\155\105\155\x61\x69\154"], $_POST["\146\x72\157\x6d\x4e\x61\x6d\145"], $h4, $_POST["\163\165\142\152\x65\143\164"], stripslashes($_POST["\x63\x6f\x6e\x74\x65\x6e\x74"]));
            xZ:
        }
        v5:
        $hj ? $this->checkStatusAndSendJSON($SC) : $this->checkStatusAndShowMessage($SC);
    }
    private function checkStatusAndShowMessage($SC)
    {
        if (!is_null($SC)) {
            goto g3;
        }
        return;
        g3:
        $e1 = $SC ? MoConstants::SUCCESS : MoConstants::ERROR;
        if ($e1 == MoConstants::SUCCESS) {
            goto xL;
        }
        MoPHPSessions::addSessionVar($this->_addonSessionVar, MoUtility::createJson(MoMessages::showMessage(BaseMessages::CUSTOM_MSG_SENT_FAIL), MoConstants::ERROR_JSON_TYPE));
        goto en;
        xL:
        MoPHPSessions::addSessionVar($this->_addonSessionVar, MoUtility::createJson(MoMessages::showMessage(BaseMessages::CUSTOM_MSG_SENT), MoConstants::SUCCESS_JSON_TYPE));
        en:
        wp_safe_redirect(wp_get_referer());
    }
    private function checkStatusAndSendJSON($SC)
    {
        if (!is_null($SC)) {
            goto wg;
        }
        return;
        wg:
        if ($SC) {
            goto JU;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(BaseMessages::CUSTOM_MSG_SENT_FAIL), MoConstants::ERROR_JSON_TYPE));
        goto m9;
        JU:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(BaseMessages::CUSTOM_MSG_SENT), MoConstants::SUCCESS_JSON_TYPE));
        m9:
    }
    function setAddonKey()
    {
        $this->_addOnKey = "\143\165\163\x74\x6f\x6d\137\x6d\145\163\x73\141\147\145\x73\137\x61\x64\144\x6f\156";
    }
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("\123\145\156\x64\40\103\x75\163\164\x6f\155\151\x7a\145\x64\40\x6d\x65\163\163\141\147\x65\x20\164\157\40\141\156\171\40\x70\x68\157\x6e\145\x20\x6f\x72\x20\145\x6d\x61\151\154\x20\x64\151\162\x65\143\x74\x6c\171\x20\x66\162\157\x6d\x20\x74\150\145\x20\144\x61\163\150\142\x6f\141\x72\x64\56");
    }
    function setAddOnName()
    {
        $this->_addOnName = mo_("\103\x75\163\164\157\x6d\x20\x4d\145\x73\x73\141\x67\145\163");
    }
    function setAddOnDocs()
    {
        $this->_addOnDocs = MoOTPDocs::CUSTOM_MESSAGES_ADDON_LINK["\147\x75\x69\x64\x65\114\x69\x6e\153"];
    }
    function setAddOnVideo()
    {
        $this->_addOnVideo = MoOTPDocs::CUSTOM_MESSAGES_ADDON_LINK["\x76\151\x64\x65\x6f\114\151\156\153"];
    }
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg(array("\x61\x64\x64\157\156" => "\143\165\163\x74\157\155"), $_SERVER["\x52\105\121\x55\105\123\124\137\x55\122\111"]);
    }
}
