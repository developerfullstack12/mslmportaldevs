<?php


namespace OTP\Handler\Forms;

use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Traits\Instance;
use OTP\Helper\MoOTPDocs;
use ReflectionException;
class WooCommerceFrontendManagerForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_formKey = "\127\x43\x46\x4d";
        $this->_formName = mo_("\x57\157\157\103\x6f\155\x6d\x65\x72\143\145\40\x46\162\157\156\x74\145\156\x64\x20\115\141\x6e\141\x67\145\162\40\106\x6f\x72\x6d\40\50\127\103\106\x4d\x29\40\x3c\142\x3e\x3c\163\x70\141\156\40\163\164\x79\x6c\145\75\x27\143\x6f\x6c\157\162\x3a\x72\x65\x64\47\x3e\x5b\x50\162\x65\155\x69\x75\155\40\106\x6f\x72\155\x5d\x3c\57\163\160\141\x6e\76\x3c\x2f\142\76");
        $this->_formDocuments = MoOTPDocs::WCFM_FORM;
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
