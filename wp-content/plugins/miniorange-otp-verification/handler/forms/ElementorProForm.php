<?php


namespace OTP\Handler\Forms;

use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Traits\Instance;
use OTP\Helper\MoOTPDocs;
use ReflectionException;
class ElementorProForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_formKey = "\105\114\105\115\105\116\x54\117\122\137\120\x52\117";
        $this->_formName = mo_("\105\154\145\x6d\x65\x6e\x74\157\162\40\120\162\157\40\x46\x6f\162\155\x20\x3c\142\x3e\74\163\x70\x61\156\40\163\164\x79\x6c\x65\75\x27\x63\157\x6c\x6f\x72\x3a\162\x65\144\x27\x3e\x5b\120\x72\145\x6d\x69\165\155\x20\x46\157\162\x6d\x5d\74\x2f\x73\160\x61\x6e\76\x3c\x2f\x62\x3e");
        $this->_formDocuments = MoOTPDocs::ELEMENTOR_PRO;
        parent::__construct();
    }
    function handleForm()
    {
        return;
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        return;
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        return;
    }
    public function unsetOTPSessionVariables()
    {
        return;
    }
    public function getPhoneNumberSelector($zX)
    {
        return $zX;
    }
    function handleFormOptions()
    {
        return;
    }
}
