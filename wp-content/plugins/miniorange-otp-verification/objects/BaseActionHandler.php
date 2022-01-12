<?php


namespace OTP\Objects;

use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
class BaseActionHandler
{
    protected $_nonce;
    protected function __construct()
    {
    }
    protected function isValidRequest()
    {
        if (!(!current_user_can("\x6d\x61\x6e\x61\x67\145\x5f\x6f\160\164\151\x6f\156\x73") || !check_admin_referer($this->_nonce))) {
            goto U3;
        }
        wp_die(MoMessages::showMessage(MoMessages::INVALID_OP));
        U3:
        return true;
    }
    protected function isValidAjaxRequest($Zm)
    {
        if (check_ajax_referer($this->_nonce, $Zm)) {
            goto qy;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(BaseMessages::INVALID_OP), MoConstants::ERROR_JSON_TYPE));
        qy:
    }
    public function getNonceValue()
    {
        return $this->_nonce;
    }
}
